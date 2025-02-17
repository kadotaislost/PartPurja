<?php
require '../includes/database.php';

$title = "Home Page";
include '../includes/header.php';
include '../includes/navbar.php';

$conn = new Database();

// Fetch categories (still needed)
$categoriesQuery = "SELECT * FROM categories";
$categoriesResult = $conn->select($categoriesQuery);

?>

<div class="max-w-7xl mx-auto mt-6">
    <div class="flex gap-4">
        <!-- Sidebar for Categories -->
        <aside class="p-5 sticky top-32 w-[30%] h-[80vh] overflow-auto rounded-lg shadow-lg bg-white hidden md:block">
            <h2 class="text-lg font-semibold mb-4">Categories</h2>
             <ul class="space-y-2">
                    <li>
                        <a href="#" class="block p-2 hover:bg-blue-100 rounded category-link" data-category-id="0">
                        All Categories
                        </a>
                    </li>
                <?php foreach ($categoriesResult as $category) : ?>
                    <li>
                        <a href="#" class="block p-2 hover:bg-blue-100 rounded category-link" 
                        data-category-id="<?= $category['category_id']; ?>">
                            <?= htmlspecialchars($category['category_name']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                </ul>
        </aside>

        <!-- Products Section -->
        <main class="w-full">
                 <!-- Responsive Mobile Sidebar -->
            <div class = "flex items-center gap-2 mb-4 justify-between">
                <div class = 'flex items-center gap-2'>
                    <div class="md:hidden">
                        <button id="toggleSidebar" class = "cursor-pointer p-2 bg-neutral rounded-lg" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class ="fill-white"viewBox="0 -960 960 960"><path d="m260-520 220-360 220 360zM700-80q-75 0-127.5-52.5T520-260t52.5-127.5T700-440t127.5 52.5T880-260t-52.5 127.5T700-80m-580-20v-320h320v320zm580-60q42 0 71-29t29-71-29-71-71-29-71 29-29 71 29 71 71 29m-500-20h160v-160H200zm202-420h156l-78-126zm298 340"/></svg></button>
                        <div id="mobileSidebar" class="hidden absolute mt-2 p-4 bg-white rounded-lg shadow-lg">
                            <ul class="space-y-2">
                                <li>
                                    <a href="#" class="block p-2 hover:bg-blue-100 rounded category-link" data-category-id="0">
                                    All Categories
                                    </a>
                                </li>
                            <?php foreach ($categoriesResult as $category) : ?>
                                <li>
                                    <a href="#" class="block p-2 hover:bg-blue-100 rounded category-link" 
                                    data-category-id="<?= $category['category_id']; ?>">
                            <?= htmlspecialchars($category['category_name']); ?>
                                </a>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold ">Latest Uploads</h2>
                </div>

                <button class =' btn btn-secondary btn-outline'><a href="requests.php">Requests</a></button>
            </div>     
            <!-- Product List (Initially Empty, Filled by AJAX) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4" id="productList"></div>
        </main>
    </div>
</div>

<script>

    document.getElementById("toggleSidebar").addEventListener("click", function() {
                            var sidebar = document.getElementById("mobileSidebar");
                            sidebar.classList.toggle("hidden");

                        });
    let currentCategory = 0; // Store the selected category

    function fetchProducts(categoryId = 0) {
        currentCategory = categoryId; // Update the currently selected category
        let url = "fetch_products.php";
        if (categoryId > 0) {
            url += "?category_id=" + categoryId;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                let productContainer = document.getElementById("productList");

                // Clear current products
                productContainer.innerHTML = "";

                // Loop through each product and dynamically insert into the DOM
                data.forEach(product => {
                    let productHTML = `
                        <div class="rounded-lg p-4 shadow-lg bg-white">
                            <img src="${product.image_url}" 
                                 alt="${product.title}" 
                                 class="w-full h-45 object-cover rounded-lg">
                            
                            <h3 class="font-semibold text-lg mt-2">${product.title}</h3>
                            <p class="text-gray-500">${product.description.substring(0, 50)}...</p>
                            
                            <div class="flex justify-between items-center">
                                <p class="text-green-600 font-bold mt-2">NRS ${product.price}</p>
                                <p class="text-xs text-gray bg-gray-200 px-2 py-1 rounded-full">
                                    ${product.product_condition.charAt(0).toUpperCase() + product.product_condition.slice(1)}
                                </p> 
                            </div>
                            
                            <div class="text-sm font-light text-gray-800 mt-2">By ${product.full_name}</div>
                            <a href="product.php?id=${product.product_id}" 
                               class="block mt-3 text-center text-white py-2 rounded-lg btn btn-primary">
                                View Details
                            </a>
                        </div>
                    `;
                    productContainer.innerHTML += productHTML;
                });
            })
            .catch(error => console.error("Error fetching products:", error));
    }

    // Event listener for category clicks
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".category-link").forEach(link => {
            link.addEventListener("click", function (event) {
                event.preventDefault(); // Prevent page reload
                
                let categoryId = this.getAttribute("data-category-id");
                fetchProducts(categoryId);
            });
        });

        // Fetch all products on initial load
        fetchProducts();
    });

    // Refresh products every 3 seconds while keeping the selected category
    setInterval(() => {
        fetchProducts(currentCategory);
    }, 3000);
</script>


<?php include '../includes/footer.php'; ?>
