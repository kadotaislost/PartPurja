<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'database.php';

// Fetch categories
$db = new Database();
$categories = $db->select("SELECT * FROM categories");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['images'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $category = (int) $_POST['category'];
    $condition = htmlspecialchars($_POST['condition']);
    $price = (float) $_POST['price'];
    $user_id = $_SESSION['user_id'];

    // Insert product into database
    $productQuery = "INSERT INTO products (title, description, category_id, product_condition, price, user_id) VALUES (?, ?, ?, ?, ?, ?)"; 
    $returnId = $db->create($productQuery, [$title, $description, $category, $condition, $price, $user_id]);
    
    if ($returnId) {
        $imageUrls = [];
        $uploadDir = '../assets/uploads/';
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Loop through each uploaded file
        foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['images']['error'][$index] === UPLOAD_ERR_OK) {
                $fileName = preg_replace('/[^A-Za-z0-9.\-_]/', '_', basename($_FILES['images']['name'][$index]));
                $fileType = $_FILES['images']['type'][$index];

                // Check if the file type is allowed
                if (in_array($fileType, $allowedTypes)) {
                    // Generate a unique filename for each image
                    $newFileName = $uploadDir . uniqid() . '_' . $fileName;

                    // Move the file to the upload directory
                    if (move_uploaded_file($tmpName, $newFileName)) {
                        $imageUrls[] = $newFileName;

                        // Insert each image into the database
                        $imageQuery = "INSERT INTO product_images (product_id, image_url) VALUES (?, ?)";
                        $db->create($imageQuery, [$returnId, $newFileName]);
                    }
                }
            }
        }
        
        $_SESSION['success'] = "Product posted successfully.";
        header('Location: index.php');
        exit();
    
    }
}
include '../includes/header.php';
include '../includes/navbar.php';

?>

<div class="max-w-7xl mx-auto mt-6">
    <form id="uploadForm" method="POST" enctype="multipart/form-data" class="w-[80%] mx-auto bg-white rounded-lg shadow-2xl p-10">
        <div class="text-3xl font-medium text-info-content mb-4">POST YOUR PRODUCT</div>

        <div class="mb-4">
            <label for="title" class="block text-lg font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" class="p-2 w-full rounded-lg border border-gray-400 focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
            <textarea rows="5" name="description" id="description" class="p-2 w-full rounded-lg border border-gray-400 focus:outline-none" required></textarea>
        </div>

        <div class="mb-4">
            <label for="category" class="block text-lg font-medium text-gray-700">Category</label>
            <select name="category" id="category" class="p-2 w-full rounded-lg border border-gray-400 text-gray-600 focus:outline-none" required>
                <option value="">Select a Category</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= htmlspecialchars($category['category_id']); ?>"><?= htmlspecialchars($category['category_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="condition" class="block text-lg font-medium text-gray-700">Condition</label>
            <select name="condition" id="condition" class="p-2 w-full rounded-lg border border-gray-400 focus:outline-none text-gray-600" required>
                <option value="">Select a Condition</option>
                <option value="New">New</option>
                <option value="Used">Used</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="images" class="block text-lg font-medium text-gray-700">Upload Images</label>
            <input type="file" name="images[]" id="images" class="p-2 w-full rounded-lg border border-gray-400 focus:outline-none" accept=".jpg, .jpeg, .png" multiple required>
        </div>

        <!-- Image Preview Container -->
        <div id="preview-container" class="flex flex-wrap gap-4"></div>

        <div class="mb-4">
            <label for="price" class="block text-lg font-medium text-gray-700">Price</label>
            <input type="number" name="price" id="price" class="p-2 w-full rounded-lg border border-gray-400 focus:outline-none" required>
        </div>

        <button type="submit" id="uploadButton" class="bg-blue-600 cursor-pointer hover:bg-blue-800 text-white p-2 rounded-lg w-full">
            Post Product
        </button>
    </form>


</div>

<?php include '../includes/footer.php'; ?>