<?php
include "../includes/db.php";
require '../includes/auth.php';

$insert = false;

session_start();
requireLogin();
if (!isset($_SESSION['user_id'])) {
    header('Location:login.php'); // Redirect to login page
    exit;
}
$email = $_SESSION['email'];
$username = explode('@', $email)[0]; // '@' se email ko tod kar pehla part le lo



if (isset($_POST['addProduct'])) {
    $product_name = $_POST['product_name'];
    $product_sku = $_POST['product_sku'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_category_id = $_POST['product_category_id'];
    $promotion_category_id = $_POST['promotion_category_id'];

    // Image Upload
    $image1 = $_FILES['product_image_1']['name'];
    $image2 = $_FILES['product_image_2']['name'];
    $target_dir = "../assets/images/product_image/";
    $target_file1 = $target_dir . basename($image1);
    $target_file2 = $target_dir . basename($image2);

    move_uploaded_file($_FILES['product_image_1']['tmp_name'], $target_file1);
    move_uploaded_file($_FILES['product_image_2']['tmp_name'], $target_file2);

    // Insert Query
    $sql = "INSERT INTO products (product_name, product_sku, product_description, product_price, product_category_id, promotion_category_id, product_image_1, product_image_2) 
            VALUES ('$product_name', '$product_sku', '$product_description', '$product_price', '$product_category_id', '$promotion_category_id', '$image1', '$image2')";

    if (mysqli_query($conn, $sql)) {
        $insert = true;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch Categories
$categories_result = mysqli_query($conn, "SELECT * FROM category");
$categories = [];
while ($row = mysqli_fetch_assoc($categories_result)) {
    $categories[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Amour Roses</title>

    <!-- Tailwind is included -->
    <link rel="stylesheet" href="../assets/css/main.css">

    <link rel="shortcut icon" href="https://www.pngmart.com/files/21/Admin-Profile-PNG-Image.png" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>

    <div id="app">

        <nav id="navbar-main" class="navbar is-fixed-top">
            <div class="navbar-brand">
                <a class="navbar-item mobile-aside-button">
                    <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
                </a>
            </div>
            <div class="navbar-brand is-right">
                <a class="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
                    <span class="icon"><i class="mdi mdi-dots-vertical mdi-24px"></i></span>
                </a>
            </div>
            <div class="navbar-menu" id="navbar-menu">
                <div class="navbar-end">

                    <div class="navbar-item dropdown has-divider has-user-avatar">
                        <a class="navbar-link">
                            <div class="user-avatar">
                                <img src="https://img.freepik.com/premium-vector/man-avatar-profile-picture-isolated-background-avatar-profile-picture-man_1293239-4866.jpg?semt=ais_hybrid"
                                    alt="John Doe" class="rounded-full">
                            </div>
                            <div class="is-user-name"><?php echo htmlspecialchars($username); ?></div>
                            <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
                        </a>
                        <div class="navbar-dropdown">
                            <a href="#" class="navbar-item">
                                <span class="icon"><i class="mdi mdi-account"></i></span>
                                <span>My Profile</span>
                            </a>
                            <a class="navbar-item">
                                <span class="icon"><i class="mdi mdi-settings"></i></span>
                                <span>Settings</span>
                            </a>
                            <a class="navbar-item">
                                <span class="icon"><i class="mdi mdi-email"></i></span>
                                <span>Messages</span>
                            </a>
                            <hr class="navbar-divider">
                            <a href="logout.php" class="navbar-item">
                                <span class="icon"><i class="mdi mdi-logout"></i></span>
                                <span>Log Out</span>
                            </a>
                        </div>
                    </div>
                    <a href="#" class="navbar-item has-divider desktop-icon-only">
                        <span class="icon"><i class="mdi mdi-help-circle-outline"></i></span>
                        <span>About</span>
                    </a>
                    <a href="https://github.com/Aliyan669/Amour-Roses"
                        class="navbar-item has-divider desktop-icon-only">
                        <span class="icon"><i class="mdi mdi-github-circle"></i></span>
                        <span>GitHub</span>
                    </a>
                    <a title="Log out" href="logout.php" class="navbar-item desktop-icon-only">
                        <span class="icon"><i class="mdi mdi-logout"></i></span>
                        <span>Log out</span>
                    </a>
                </div>
            </div>
        </nav>

        <aside class="aside is-placed-left is-expanded">
            <div class="aside-tools">
                <div>
                    <img src="../assets/images/logo.png" width="180px">
                </div>
            </div>
            <div class="menu is-menu-main ">
                <p class="menu-label">General</p>
                <ul class="menu-list">
                    <li class="--set-active-tables-html">
                        <a href="index.php">
                            <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
                            <span class="menu-item-label">Dashboard</span>
                        </a>
                    </li>
                </ul>
                <p class="menu-label">Data</p>
                <ul class="menu-list">
                    <li class="--set-active-tables-html">
                        <a href="orders.php">
                            <span class="icon"><i class="mdi mdi-cart-outline"></i></span>
                            <span class="menu-item-label">Orders</span>
                        </a>
                    </li>

                    <li class="active">
                        <a class="dropdown">
                            <span class="icon"><i class="mdi mdi-tag-text-outline"></i></span>
                            <span class="menu-item-label">Products</span>
                            <span class="icon seticon"><i class="mdi mdi-chevron-down"></i></span>
                        </a>
                        <ul>
                            <li class="--set-active-tables-html">
                                <a href="allProduct.php">
                                    <span class="icon"><i class="mdi mdi-check-all"></i></span>
                                    <span class="menu-item-label">All Products</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="addProduct.php">
                                    <span class="icon"><i class="mdi mdi-plus"></i></span>
                                    <span class="menu-item-label">Add Products</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="--set-active-tables-html">
                        <a class="dropdown">
                            <span class="icon"><i class="mdi mdi-shape-plus"></i></span>
                            <span class="menu-item-label">Category</span>
                            <span class="icon seticon"><i class="mdi mdi-chevron-down"></i></span>
                        </a>
                        <ul>
                            <li class="--set-active-tables-html">
                                <a href="allCategory.php">
                                    <span class="icon"><i class="mdi mdi-check-all"></i></span>
                                    <span class="menu-item-label">All Category</span>
                                </a>
                            </li>
                            <li class="--set-active-tables-html">
                                <a href="addCategory.php">
                                    <span class="icon"><i class="mdi mdi-plus"></i></span>
                                    <span class="menu-item-label">Add Category</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="--set-active-tables-html">
                        <a class="dropdown">
                            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
                            <span class="menu-item-label">Users</span>
                            <span class="icon seticon"><i class="mdi mdi-chevron-down"></i></span>
                        </a>
                        <ul>
                            <li class="--set-active-tables-html">
                                <a href="allUsers.php">
                                    <span class="icon"><i class="mdi mdi-check-all"></i></span>
                                    <span class="menu-item-label">All User</span>
                                </a>
                            </li>
                            <li class="--set-active-tables-html">
                                <a href="addUsers.php">
                                    <span class="icon"><i class="mdi mdi-plus"></i></span>
                                    <span class="menu-item-label">Add User</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
                <p class="menu-label">About</p>
                <ul class="menu-list">

                    <li>
                        <a href="#" class="has-icon">
                            <span class="icon"><i class="mdi mdi-help-circle"></i></span>
                            <span class="menu-item-label">About</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <?php
        //  Alert Success Popup
        if ($insert) {
            echo "<div id='alert-border-1'
            class='flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800'
            role='alert'>
            <div class='ms-3 text-sm font-medium'>
              <b> Success!</b> Product Has Been Added Successfully.
            </div>
            <button type='button'
                class='ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700'
                data-dismiss-target='#alert-border-1' aria-label='Close'>
                <span class='sr-only'>Dismiss</span>
                <svg class='w-3 h-3' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none'
                    viewBox='0 0 14 14'>
                    <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2'
                        d='m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6' />
                </svg>
            </button>
        </div>";
        }

        ?>

        <section class="is-title-bar">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
                <ul>
                    <li>Admin</li>
                    <li> Add Products</li>
                </ul>

            </div>
        </section>

        <section class="is-hero-bar">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
                <h1 class="title">
                    Add Products
                </h1>
            </div>
        </section>

        <section class="section main-section">

            <form method="POST" enctype="multipart/form-data">
                <div class="space-y-12">

                    <div class="border-b border-gray-900/10 pb-12">

                        <div class="grid grid-cols-2  gap-x-4 gap-y-8 ">

                            <div class="sm:grid-cols-1">
                                <label for="product_name" class="block text-base font-medium text-gray-800">Product
                                    Name</label>
                                <div class="mt-2">
                                    <div
                                        class="flex items-center rounded-md bg-white pl-3  outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-blue-600">
                                        <input type="text" name="product_name" id="product_name"
                                            class="block min-w-0 grow py-2.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6"
                                            placeholder="Enter Product Name">
                                    </div>
                                </div>
                            </div>

                            <div class="sm:grid-cols-1">
                                <label for="product_sku" class="block text-base font-medium text-gray-800">Product
                                    SKU</label>
                                <div class="mt-2">
                                    <div
                                        class="flex items-center rounded-md bg-white pl-3  outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-blue-600">
                                        <input type="text" name="product_sku" id="product_sku"
                                            class="block min-w-0 grow py-2.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6"
                                            placeholder="Enter Product SKU">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="grid grid-cols-1 gap-x-4 gap-y-8 mt-6  ">

                            <div>
                                <label for="product_Description"
                                    class="block text-base font-medium text-gray-800">Product
                                    Description</label>
                                <div class="mt-2">
                                    <textarea name="product_description" id="product_description" rows="4"
                                        placeholder="Enter Product Description"
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6"></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="grid grid-cols-3 gap-x-4 gap-y-8 mt-6  ">

                            <div>
                                <label for="product_price" class="block text-base font-medium text-gray-800">Product
                                    Price</label>
                                <div class="mt-2">
                                    <div
                                        class="flex items-center rounded-md bg-white pl-3  outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-blue-600">
                                        <input type="number" name="product_price" id="product_price"
                                            class="block min-w-0 grow py-2.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6"
                                            placeholder="Enter Product Price">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="product_Category" class="block text-base font-medium text-gray-900">Product
                                    Category</label>
                                <div class="mt-2 grid grid-cols-1">
                                    <select id="product_Category" name="product_category_id"
                                        autocomplete="product_Category"
                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6">
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['cate_id'] ?>"><?= $category['cate_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <div>
                                <label for="promotion_category"
                                    class="block text-base font-medium text-gray-900">Promotion
                                    Category</label>
                                <div class="mt-2 grid grid-cols-1">
                                    <select id="promotion_category" name="promotion_category_id"
                                        autocomplete="promotion_category"
                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6">
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['cate_id'] ?>"><?= $category['cate_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>

                            </div>


                        </div>

                        <div class="grid grid-cols-2 gap-x-4 gap-y-8 mt-8">
                            <div>
                                <label for="product_image_1" class="block text-base font-medium text-gray-800">Product
                                    Image 1</label>
                                <div
                                    class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 py-10">
                                    <div class="text-center">
                                        <svg class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="mt-4 flex text-sm/6 text-gray-600">
                                            <label for="product_image_1"
                                                class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2 hover:text-blue-500">
                                                <span>Upload a file</span>
                                                <input id="product_image_1" name="product_image_1" type="file"
                                                    class="sr-only">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="product_image_2" class="block text-base font-medium text-gray-800">Product
                                    Image 2</label>
                                <div
                                    class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 py-10">
                                    <div class="text-center">
                                        <svg class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1-1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="mt-4 flex text-sm/6 text-gray-600">
                                            <label for="product_image_2"
                                                class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2 hover:text-blue-500">
                                                <span>Upload a file</span>
                                                <input id="product_image_2" name="product_image_2" type="file"
                                                    class="sr-only">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="mt-6 mb-12 flex items-center justify-start gap-x-6">
                    <button type="button" class="text-sm/6 font-semibold text-gray-900">Cancel</button>
                    <button name="addProduct"
                        class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Save</button>
                </div>

            </form>
        </section>

        <footer class="footer">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                <div class="flex items-center justify-start space-x-3">
                    <div>
                        © 2024, Amour Roses.
                    </div>

                    <div>
                        <p>Developed By: Aliyan Amir</p>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <!-- Scripts below are for demo only -->
    <script type="text/javascript" src="../assets/js/main.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script type="text/javascript" src="../assets/js/chart.sample.min.js"></script>

    <!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

</body>

<script>
    /// Tailwind Alert Close Button
    document.addEventListener('DOMContentLoaded', () => {
        const closeButtons = document.querySelectorAll('[data-dismiss-target]');
        closeButtons.forEach(button => {
            button.addEventListener('click', () => {
                const target = document.querySelector(button.getAttribute('data-dismiss-target'));
                if (target) {
                    target.classList.add('hidden'); // Alert ko hide karein
                }
            });
        });
    });
</script>

</html>