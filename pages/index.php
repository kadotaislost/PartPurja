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
        <aside class="p-5 sticky top-32 w-1/3 h-[80vh] overflow-auto rounded-lg shadow-lg bg-white hidden md:block">
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
        <main class="grow">
            
                <h2 class="text-xl font-bold mb-4">Latest Uploads</h2>

            

            <!-- Product List (Initially Empty, Filled by AJAX) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4" id="productList"></div>
        </main>
    </div>
</div>

<script>
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
                               class="block mt-3 text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
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
