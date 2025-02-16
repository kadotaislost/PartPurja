<?php
include '../includes/header.php';
include '../includes/navbar.php';
require '../includes/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = new Database();
    $productQuery = "SELECT products.*, GROUP_CONCAT(product_images.image_url) AS image_urls, categories.category_name, users.full_name, users.phone
                     FROM products 
                     LEFT JOIN product_images ON products.product_id = product_images.product_id 
                     LEFT JOIN categories ON products.category_id = categories.category_id
                     LEFT JOIN users ON products.user_id = users.user_id
                     WHERE products.product_id = ?
                     GROUP BY products.product_id";
    $productResult = $conn->select($productQuery, [$id]);

    if (!$productResult) {
        echo "<h1 class='text-center mt-10 text-2xl'>Product not found</h1>";
        exit;
    }

    $product = $productResult[0];
    $productImages = explode(',', $product['image_urls']);
} else {
    header('Location: index.php');
    exit;
}

$hideButtons = count($productImages) <= 1 ? 'hidden' : '';

// Fetch comments for the product
$commentsQuery = "SELECT comments.comment_text, users.full_name, users.profile_image, comments.created_at 
                  FROM comments 
                  LEFT JOIN users ON comments.user_id = users.user_id 
                  WHERE comments.product_id = ? 
                  ORDER BY comments.created_at DESC";
$comments = $conn->select($commentsQuery, [$id]);
?>

<div class="max-w-7xl mx-auto mt-6">
    <div class="flex flex-col lg:flex-row gap-4">
        <!-- Product Image Carousel -->
        <div class="w-full lg:w-1/2 relative">
            <div class="carousel_container relative overflow-hidden rounded-lg shadow-lg">
                <?php foreach ($productImages as $index => $image_url) : ?>
                    <div class="w-full h-[400px] sm:h-[500px] md:h-[550px] lg:h-[600px] carousel-item <?= $index === 0 ? 'block' : 'hidden'; ?>">
                        <img src="../assets/<?= htmlspecialchars($image_url); ?>" alt="<?= htmlspecialchars($product['title']); ?>" class="w-full h-full object-cover rounded-lg shadow-lg">
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Navigation Buttons -->
            <button class="cursor-pointer absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full <?= $hideButtons; ?>" onclick="prevImage()">&#10094;</button>
            <button class="cursor-pointer absolute top-1/2 right-2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full <?= $hideButtons; ?>" onclick="nextImage()">&#10095;</button>
        </div>

        <!-- Product Details -->
        <div class=" w-full lg:w-1/2 bg-white p-5 rounded-lg shadow-lg">
            <div class = "flex items-center justify-between">
                <h1 class="text-3xl font-semibold text-gray-900"><?= htmlspecialchars($product['title']); ?></h1>
                <span class = "bg-base-200 text-sm py-2 px-4 rounded-full text-gray-600"><?= htmlspecialchars($product['category_name']); ?></span>
            </div>
            <p class = "mt-6 text-gray-700 font-semibold text-lg ">Description:</p>
            <p class="text-lg text-gray-700 mt-1 "><?= nl2br(htmlspecialchars($product['description'])); ?></p>
            
            <p class="text-lg text-gray-600 mt-4"><span class="font-semibold">Condition:</span> <span class = "font-md text-warning"><?= htmlspecialchars($product['product_condition']); ?></span></p>





            <p class="text-lg text-gray-600 mt-4"><span class="font-semibold">Product Status:</span> <span><?= htmlspecialchars($product['product_status']); ?></span></p>


         


            <p class="text-lg text-gray-600 mt-4"><span class="font-semibold">Contact:</span> <span><?= htmlspecialchars($product['phone']); ?></span></p>

            <p class="text-lg text-gray-600 mt-4"><span class="font-semibold">Posted by:</span> <span ><?= htmlspecialchars($product['full_name']); ?></span></p>

            
            <div class = 'flex items-center justify-between mt-6'>
                <p class="text-green-600 font-bold mt-2 text-2xl">NRS <?= htmlspecialchars($product['price']); ?></p>

                <p class="text-md text-gray-600 mt-2"> <?= date("F j, Y", strtotime(htmlspecialchars($product['created_at']))); ?></p>
            </div>
            
        </div>
    </div>

    <!-- Comment Section -->
    <div class="mt-10 bg-white p-12 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Comments</h2>

        <!-- Display Comments -->
        <div class="space-y-4">
        <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="border border-gray-200 p-4 rounded-lg flex items-start gap-4">
                <img src="../assets/profile_pictures/<?= htmlspecialchars($comment['profile_image']); ?>" 
                     alt="<?= htmlspecialchars($comment['full_name']); ?>" 
                     class="w-10 h-10 rounded-full object-cover">
                <div>
                    <p class="font-semibold text-gray-900"><?= htmlspecialchars($comment['full_name']); ?></p>
                    <p class="text-gray-700"><?= htmlspecialchars($comment['comment_text']); ?></p>
                    <p class="text-sm text-gray-500"><?= date("F j, Y, g:i a", strtotime($comment['created_at'])); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">No comments yet. Be the first to ask about this product.</p>
        <?php endif; ?>
    </div>


        <!-- Add Comment Form -->
        <form action="add_comment.php" method="POST" class="mt-6">
            <input type="hidden" name="product_id" value="<?= $id; ?>">
            <textarea name="comment_text" rows="3" class=" focus:outline-none w-full p-3 border rounded-lg" placeholder="Ask a question about this product..." required></textarea>
            <button type="submit" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg">Post Comment</button>
        </form>
    </div>
</div>

<!-- JavaScript for Image Carousel -->
<script>
    let currentImageIndex = 0;
    const images = document.querySelectorAll('.carousel-item');

    function showImage(index) {
        images.forEach((img, i) => {
            img.classList.toggle('block', i === index);
            img.classList.toggle('hidden', i !== index);
        });
    }

    function prevImage() {
        currentImageIndex = (currentImageIndex > 0) ? currentImageIndex - 1 : images.length - 1;
        showImage(currentImageIndex);
    }

    function nextImage() {
        currentImageIndex = (currentImageIndex < images.length - 1) ? currentImageIndex + 1 : 0;
        showImage(currentImageIndex);
    }

    // Auto-slide images every 5 seconds
    setInterval(() => {
        nextImage();
    }, 5000);
</script>

<?php include '../includes/footer.php'; ?>