<?php
require '../includes/database.php';

$title = "Home Page";
include '../includes/header.php';
include '../includes/navbar.php';

$conn = new Database();

$categoriesQuery = "SELECT * FROM categories";
$categoriesResult = $conn->select($categoriesQuery);
$productsQuery = "SELECT products.*, product_images.image_url 
                  FROM products 
                  LEFT JOIN product_images ON products.product_id = product_images.product_id 
                  GROUP BY products.product_id
                  ORDER BY created_at DESC ";

$productsResult = $conn->select($productsQuery);

?>

<div class="max-w-7xl mx-auto mt-6">
    <div class="flex gap-4">
        <!-- Sidebar for Categories -->
        
        <aside class="p-5 sticky top-32 w-1/3 h-[80vh] overflow-auto rounded-lg shadow-lg bg-white hidden md:block">
    <h2 class="text-lg font-semibold mb-4">Categories</h2>
    <ul class="space-y-2">
        <?php foreach ($categoriesResult as $category) : ?>
            <li>
                <a href="category.php?id=<?= $category['category_id']; ?>" class="block p-2 hover:bg-gray-100 rounded">
                    <?= htmlspecialchars($category['category_name']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>





 <!-- Products Section  -->
      <main class="grow">
    
        <!-- Responsive Mobile Sidebar -->
         <div class = "flex items-center gap-2 mb-4">
         <div class="md:hidden">
            <button id="toggleSidebar" class = "p-2 bg-neutral rounded-lg" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class ="fill-white"viewBox="0 -960 960 960"><path d="m260-520 220-360 220 360zM700-80q-75 0-127.5-52.5T520-260t52.5-127.5T700-440t127.5 52.5T880-260t-52.5 127.5T700-80m-580-20v-320h320v320zm580-60q42 0 71-29t29-71-29-71-71-29-71 29-29 71 29 71 71 29m-500-20h160v-160H200zm202-420h156l-78-126zm298 340"/></svg></button>
            <div id="mobileSidebar" class="hidden absolute mt-2 p-4 bg-white rounded-lg shadow-lg">
                <ul class="space-y-2">
                    <?php foreach ($categoriesResult as $category) : ?>
                        <li>
                            <a href="category.php?id=<?= $category['category_id']; ?>" class="block p-2 hover:bg-gray-100 rounded">
                                <?= htmlspecialchars($category['category_name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <script>
            document.getElementById("toggleSidebar").addEventListener("click", function() {
                var sidebar = document.getElementById("mobileSidebar");
                sidebar.classList.toggle("hidden");

            });
        </script>
         <h2 class="text-xl font-bold ">Latest Uploads</h2>
         </div>
        


    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <?php foreach ($productsResult as $product) : ?>
            <div class=" rounded-lg p-4 shadow-lg bg-white">
                <img src="../assets/<?= htmlspecialchars($product['image_url']); ?>" 
                     alt="<?= htmlspecialchars($product['title']); ?>" 
                     class="w-full h-40 object-cover rounded-lg">
                
                <h3 class="font-semibold text-lg mt-2"><?= htmlspecialchars($product['title']); ?></h3>
                <p class="text-gray-500"><?= substr(htmlspecialchars($product['description']), 0, 60); ?>...</p>
                
                <div class="flex justify-between items-center">
                    <p class="text-green-600 font-bold mt-2">NRS <?= htmlspecialchars($product['price']); ?></p>
                    <p class="text-xs text-gray bg-gray-200 px-2 rounded-full">
                        <?= htmlspecialchars(ucfirst($product['product_condition'])); ?>
                    </p>
                </div>
                
                <a href="product.php?id=<?= $product['product_id']; ?>" 
                   class="block mt-3 text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    View Details
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</main>

    </div>
   
</div>

<?php include '../includes/footer.php'; ?>
