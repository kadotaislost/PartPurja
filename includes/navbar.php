<?php
session_start();
include 'header.php';

// Example user session data (Ensure this data is properly set after login)
$userLoggedIn = isset($_SESSION['user_id']); // Check if user is logged in
$fullName = $userLoggedIn ? $_SESSION['full_name'] : ''; // User's full name
$profilePicture = $userLoggedIn ? $_SESSION['profile_image'] : ''; // User's profile picture
?>

<nav class="sticky top-0 z-10 border border-b-gray-200 bg-base-100">
    <div class="max-w-7xl mx-auto py-7">
        <div class="flex justify-between items-center gap-5">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="../assets/images/logo_noborder.png" alt="PartPurja Logo" class="w-12 h-12 rounded-full">
                <p class="text-2xl font-semibold ml-2">
                    <a href="index.php" class="hover:text-gray-700">PartPurja</a>
                </p>
            </div>

            <!-- Search Bar -->
            <div class="flex-1 max-w-lg bg-none border border-neutral-400 p-2 rounded-lg focus-within:border-black">
                <form class="px-2 flex items-center justify-between" action="search.php" method="GET">
                    <input type="text" name="search" placeholder="Search" class="w-full border-none focus:outline-none bg-transparent">
                    <button type="submit" aria-label="Search" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 960 960" class="w-6 h-6">
                            <path fill="currentColor" d="M784 840 532 588q-30 24-69 38t-83 14q-109 0-184.5-75.5T120 380t75.5-184.5T380 120t184.5 75.5T640 380q0 44-14 83t-38 69l252 252zM380 560q75 0 127.5-52.5T560 380t-52.5-127.5T380 200t-127.5 52.5T200 380t52.5 127.5T380 560"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex lg:items-center gap-16">
                <a class="btn flex items-center gap-2 btn-neutral bg-neutral-900 hover:bg-neutral" href="createpost.php">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white opacity-80 w-6 h-6" viewBox="0 -960 960 960">
                        <path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160zm40 200q-83 0-156-31.5T197-197t-85.5-127T80-480t31.5-156T197-763t127-85.5T480-880t156 31.5T763-763t85.5 127T880-480t-31.5 156T763-197t-127 85.5T480-80m0-80q134 0 227-93t93-227-93-227-227-93-227 93-93 227 93 227 227 93m0-320"/>
                    </svg>
                    Post for free
                </a>

                <?php if (!$userLoggedIn): ?>
                    <div class="flex items-center gap-4">
                        <a class="btn btn-primary btn-soft px-6" href="register.php">Signup</a>
                        <a class="btn btn-neutral btn-outline px-6" href="login.php">Login</a>
                    </div>
                <?php else: ?>
                    <div class="flex items-center gap-4">
                        <a href="profile.php" class="flex items-center gap-4">
                            <img src="<?= htmlspecialchars($profilePicture) ?>" alt="Profile" class="w-12 h-12 rounded-full border">
                            <span class="text-lg font-semibold"><?= htmlspecialchars($fullName) ?></span>
                        </a>
                        <a class="btn btn-neutral btn-outline px-6" href="logout.php">Logout</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <div class="block lg:hidden">
                <button id="menu-button" aria-label="Toggle Menu" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden mt-4">
            <div class="flex flex-col gap-2 p-4 bg-gray-50 rounded-lg">
                <a class="btn w-full text-center hover:bg-gray-100 p-2 rounded" href="createpost.php">
                    <svg xmlns="http://www.w3.org/2000/svg" class="opacity-50 w-6 h-6" viewBox="0 -960 960 960">
                        <path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160zm40 200q-83 0-156-31.5T197-197t-85.5-127T80-480t31.5-156T197-763t127-85.5T480-880t156 31.5T763-763t85.5 127T880-480t-31.5 156T763-197t-127 85.5T480-80m0-80q134 0 227-93t93-227-93-227-227-93-227 93-93 227 93 227 227 93m0-320"/>
                    </svg>Post for free
                </a>

                <?php if (!$userLoggedIn): ?>
                    <a class="btn w-full text-center hover:bg-gray-100 p-2 rounded" href="register.php">Signup</a>
                    <a class="btn w-full text-center hover:bg-gray-100 p-2 rounded" href="login.php">Login</a>
                <?php else: ?>
                    <a href="profile.php" class="flex items-center gap-3 p-2 rounded hover:bg-gray-100">
                        <img src="<?= htmlspecialchars($profilePicture) ?>" alt="Profile" class="w-10 h-10 rounded-full border">
                        <span class="text-lg font-semibold"><?= htmlspecialchars($fullName) ?></span>
                    </a>
                    <a class="btn w-full text-center hover:bg-gray-100 p-2 rounded" href="logout.php">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById('menu-button').addEventListener('click', function() {
        var menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
        menu.classList.toggle('block');
    });
</script>
