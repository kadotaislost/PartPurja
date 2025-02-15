<?php
include '../includes/header.php';
include '../includes/navbar.php';
require '../includes/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = new Database();
    $productQuery = "SELECT products.*, GROUP_CONCAT(product_images.image_url) AS image_urls, categories.category_name, users.full_name
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
?>

<div class="max-w-7xl mx-auto mt-6 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Product Image Carousel -->
        <div class="w-full lg:w-1/2 relative">
            <div class="carousel_container relative">
                <?php foreach ($productImages as $index => $image_url) : ?>
                    <div class="w-full h-[400px] sm:h-[500px] md:h-[550px] lg:h-[600px] carousel-item <?= $index === 0 ? 'block' : 'hidden'; ?>">
                        <img src="../assets/<?= htmlspecialchars($image_url); ?>" alt="<?= htmlspecialchars($product['title']); ?>" class="w-full h-full object-cover rounded-lg shadow-lg">
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Navigation Buttons -->
            <button class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full <?= $hideButtons; ?>" onclick="prevImage()">&#10094;</button>
            <button class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full <?= $hideButtons; ?>" onclick="nextImage()">&#10095;</button>
        </div>

        <!-- Product Details -->
        <div class="w-full lg:w-1/2">
            <h1 class="text-2xl font-semibold"><?= htmlspecialchars($product['title']); ?></h1>
            <p class="text-lg text-gray-600 mt-2"><?= htmlspecialchars($product['category_name']); ?></p>
            <p class="text-lg text-gray-600 mt-2">Price: <span class="font-bold">NRS <?= htmlspecialchars($product['price']); ?></span></p>
            <p class="text-lg text-gray-600 mt-2">Condition: <?= htmlspecialchars($product['product_condition']); ?></p>
            <p class="text-lg text-gray-600 mt-2">Posted on: <?= date("F j, Y", strtotime(htmlspecialchars($product['created_at']))); ?></p>
            <p class="text-lg text-gray-600 mt-2">Description:</p>
            <p class="text-md text-gray-700"><?= nl2br(htmlspecialchars($product['description'])); ?></p>
            <p class="text-lg text-gray-600 mt-2">Product Status: <span class="font-bold"><?= htmlspecialchars($product['product_status']); ?></span></p>
            <p class="text-lg text-gray-600 mt-2">Posted by: <span class="font-bold"><?= htmlspecialchars($product['full_name']); ?></span></p>
        </div>
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
</script>
