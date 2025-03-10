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

?>

<div class="max-w-7xl mx-auto mt-6">
    <div class="flex flex-col lg:flex-row gap-4">
        <!-- Product Image Carousel -->
        <div class="w-full lg:w-1/2 relative">
            <div class="carousel_container relative overflow-hidden rounded-lg shadow-lg">
                <?php foreach ($productImages as $index => $image_url) : ?>
                    <div class="w-full h-[400px] sm:h-[500px] md:h-[550px] lg:h-[600px] carousel-item <?= $index === 0 ? 'block' : 'hidden'; ?>">
                        <img src="<?= htmlspecialchars($image_url); ?>" alt="<?= htmlspecialchars($product['title']); ?>" class="w-full h-full object-cover rounded-lg shadow-lg">
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
        <form action="add_comment.php" method="POST" class="mb-4">
            <div class = "sm:flex sm:gap-2 sm:items-center">
                <input type="hidden" name="product_id" value="<?= $id; ?>">
                <textarea name="comment_text" rows="1" class="sm:grow w-full focus:outline-none  p-3 border rounded-lg" placeholder="Ask a question about this product..." required></textarea>
                <button type="" class="sm:w-[180px] px-4 py-2 cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Post Comment</button>
            </div>
            
        </form>
        <!-- Display Comments -->
        <div id="comments-section" class="space-y-4"></div>


        <!-- Add Comment Form -->
        
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


    // Function to Fetch and Display Comments
    function fetchComments() {
        fetch(`fetch_comments.php?product_id=<?= $_GET['id'] ?>`)
            .then(response => response.json())
            .then(comments => {
                let commentsSection = document.getElementById("comments-section");
                commentsSection.innerHTML = ""; // Clear existing comments

                if (comments.length === 0) {
                    commentsSection.innerHTML = "<p class='text-gray-500'>No comments yet. Be the first to ask about this product.</p>";
                    return;
                }

                comments.forEach(comment => {
                    let commentHTML = `
                        <div class="border border-gray-200 p-4 rounded-lg flex items-start gap-4">
                            <img src="${comment.profile_image}" alt="${comment.full_name}" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <p class="font-semibold text-gray-900">${comment.full_name}</p>
                                <p class="text-gray-700">${comment.comment_text}</p>
                                <p class="text-sm text-gray-500 mt-2">${new Date(comment.created_at).toLocaleString()}</p>
                            </div>
                        </div>
                    `;
                    commentsSection.innerHTML += commentHTML;
                });
            })
            .catch(error => console.error("Error fetching comments:", error));
    }

fetchComments();
setInterval(fetchComments, 5000);
</script>

<?php include '../includes/footer.php'; ?>