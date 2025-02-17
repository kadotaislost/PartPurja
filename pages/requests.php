<?php
include '../includes/header.php';
include '../includes/database.php';
include '../includes/navbar.php';

$conn = new Database();

// Fetch product requests from the database
$requestsQuery = "SELECT product_requests.*, users.full_name, categories.category_name 
                  FROM product_requests 
                  LEFT JOIN users ON product_requests.user_id = users.user_id 
                  LEFT JOIN categories ON product_requests.category_id = categories.category_id 
                  ORDER BY product_requests.created_at DESC";
$requests = $conn->select($requestsQuery);

// Fetch categories (still needed)
$categoriesQuery = "SELECT * FROM categories";
$categoriesResult = $conn->select($categoriesQuery);
?>

<div class="max-w-7xl mx-auto mt-6">
    <div class = "flex items-center justify-between mb-6">
        <h1 class="text-3xl font-semibold text-gray-900 ">Product Requests</h1>
        <?php 
        if(isset($_SESSION['user_id'])){
            echo '<button class="btn btn-secondary btn-outline" onclick="document.getElementById(\'my_modal_4\').showModal();">Add Request</button>';
        } 

        ?>
        <dialog id="my_modal_4" class="modal">
            <div class="modal-box w-11/12 max-w-5xl">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <h3 class="text-2xl font-bold">ADD REQUEST!</h3>

                
                <form method="post" action="add_request.php" class="mt-4">
                    <div class="mb-4">
                        <label for="request_title" class="block text-sm font-medium text-gray-700 mb-1">Request Title</label>
                        <input type="text" name="request_title" id="request_title" class="input w-full border border-gray-400 focus:outline-none focus:border-gray-600" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" class="textarea w-full border border-gray-400 focus:outline-none focus:border-gray-600" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" id="category_id" class="select w-full border border-gray-400 focus:outline-none focus:border-gray-600 text-gray-700" required>
                            <option value="">Select a Category</option>
                            <?php foreach ($categoriesResult as $category) : ?>
                                <option value="<?= htmlspecialchars($category['category_id']); ?>"><?= htmlspecialchars($category['category_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class = "btn btn-primary"> Submit request</button>
                    

                </form>


            </div>
        </dialog>
        
    </div>
    
    <div class="grid grid-cols-1  gap-6">
        <?php if (!empty($requests)): ?>
            <?php foreach ($requests as $request): ?>
                <div class="border border-gray-200 rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 bg-white">
                        <div class = "flex sm:flex-row flex-col sm:items-center gap-4 mb-2">
                            <h4 class="text-lg font-semibold"><?= htmlspecialchars($request['request_title']); ?></h4>
                            <div class = "grow flex items-center justify-between">

                                <p class="text-sm text-gray-800 bg-gray-100 px-2 py-1 rounded-3xl"> <?= htmlspecialchars($request['category_name']); ?></p>
                                <p class="text-sm text-info border border-gray-300  px-2 py-1 rounded-full"> <?= htmlspecialchars($request['status']); ?></p>
                            </div>


                        </div>

                        <p class="text-gray-600"><?= htmlspecialchars($request['description']); ?></p>

                        <p class="text-sm text-gray-500 mt-2">Requested by: <?= htmlspecialchars($request['full_name']); ?></p>
                        <div class = "flex sm:flex-row flex-col sm:items-center justify-between mt-2">

                            <p class="text-sm text-gray-500"><?= date("F j, Y, g:i a", strtotime($request['created_at'])); ?></p>
                            <button class= "btn sm:mt-0 mt-4 btn-primary cursor-pointer sm:w-[10%]"> Accept</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">No product requests found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>