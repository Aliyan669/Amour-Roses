<?php
include "../includes/db.php";

$update = false;
$delete = false;

require '../includes/auth.php';
session_start();
requireLogin();
if (!isset($_SESSION['user_id'])) {
    header('Location:login.php'); // Redirect to login page
    exit;
}
$email = $_SESSION['email'];
$username = explode('@', $email)[0]; // '@' se email ko tod kar pehla part le lo


// Delete
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $sql = "DELETE from products WHERE product_id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // echo "Successfully Product Deleted";
        $delete = true;
        // header("Location: allProduct.php");


    } else {
        echo "failed product Deleted " . mysqli_error($conn);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture POST data
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productDescription = $_POST['product_description'];
    $productPrice = $_POST['product_price'];
    $productSKU = $_POST['product_sku'];
    $productCategoryId = $_POST['product_category_id'];
    $promotionCategoryId = $_POST['promotion_category_id'];

    // Handle image uploads
    $targetDir = "../assets/images/product_image/";
    $productImage1 = null;
    $productImage2 = null;

    // Check if images are uploaded and move them
    if ($_FILES['product_image_1']['name']) {
        $productImage1 = $_FILES['product_image_1']['name'];
        $targetFile1 = $targetDir . basename($productImage1);
        move_uploaded_file($_FILES['product_image_1']['tmp_name'], $targetFile1);
    }
    if ($_FILES['product_image_2']['name']) {
        $productImage2 = $_FILES['product_image_2']['name'];
        $targetFile2 = $targetDir . basename($productImage2);
        move_uploaded_file($_FILES['product_image_2']['tmp_name'], $targetFile2);
    }
    // Build the SQL query
    $sql = "UPDATE products 
            SET 
                product_name = '$productName',   
                product_description = '$productDescription',
                product_price = '$productPrice',
                product_sku = '$productSKU',
                product_category_id = '$productCategoryId',
                promotion_category_id = '$promotionCategoryId'";

    // Update product image only if a new image is uploaded
    if ($productImage1) {
        $sql .= ", product_image_1 = '$productImage1'";
    }
    if ($productImage2) {
        $sql .= ", product_image_2 = '$productImage2'";
    }

    $sql .= " WHERE product_id = '$productId'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check for success
    if ($result) {
        // echo "Product Updated Successfully.";
        $update = true;
    } else {
        echo "Failed to update product: " . mysqli_error($conn);
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

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

    <!-- Tailwind is included -->
    <link rel="stylesheet" href="../assets/css/main.css">

    <link rel="shortcut icon" href="https://www.pngmart.com/files/21/Admin-Profile-PNG-Image.png" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .modal-card {
            max-height: 80vh;
            /* 80% of the viewport height */
            overflow-y: auto;
            /* Enables vertical scrolling */
        }

        /* Modal body container */
        .modal-card-body {
            max-height: 60vh;
            /* Adjust as needed */
            overflow-y: auto;
            /* Enables scrolling when the content exceeds this height */
            padding-right: 15px;
            /* Add right padding to prevent overlap of scroll */
        }

        .pro_image {
            margin: 0px 0px 20px 0px;
        }
    </style>

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
                            <li class="active">
                                <a href="allProduct.php">
                                    <span class="icon"><i class="mdi mdi-check-all"></i></span>
                                    <span class="menu-item-label">All Products</span>
                                </a>
                            </li>
                            <li class="--set-active-tables-html">
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
        if ($update) {
            echo "<div id='alert-border-1'
            class='flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800'
            role='alert'>
            <div class='ms-3 text-sm font-medium'>
              <b> Success!</b> Product Has Been Updated Successfully.
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

        if ($delete) {
            echo "<div id='alert-border-1'
            class='flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800'
            role='alert'>
            <div class='ms-3 text-sm font-medium'>
              <b>Success!</b> Product Has Been Deleted Successfully.
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
                    <li> All Products</li>
                </ul>

            </div>
        </section>

        <section class="is-hero-bar">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
                <h1 class="title">
                    All Products
                </h1>
                <a href="allProduct.php">
                    <button class="button blue">Refresh</button>
                </a>
            </div>
        </section>

        <section class="section main-section">

            <div class="card has-table ">
                <div class="card-content">
                    <table id="myTable">
                        <thead>

                            <tr>
                                <th>Id</th>
                                <th>Product Name</th>
                                <th>Product Description</th>
                                <th>Product Price</th>
                                <th>Product SKU</th>
                                <th>Product Category</th>
                                <th>Promotion Category</th>
                                <th>Image 1</th>
                                <th>Image 2</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            $result = $conn->query("
                            SELECT 
                                p.*, 
                                c.cate_name AS product_category_name, 
                                pc.cate_name AS promotion_category_name 
                            FROM products p
                            LEFT JOIN category c ON p.product_category_id = c.cate_id
                            LEFT JOIN category pc ON p.promotion_category_id = pc.cate_id
                        ");
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $counter ?></td>
                                    <td data-label="product_name"><?= $row['product_name'] ?></td>
                                    <td data-label="product_description"><?= $row['product_description'] ?></td>
                                    <td data-label="product_price"><?= $row['product_price'] ?></td>
                                    <td data-label="product_sku"><?= $row['product_sku'] ?></td>
                                    <td data-label="product_category"><?= $row['product_category_name'] ?></td>
                                    <td data-label="promotion_category"><?= $row['promotion_category_name'] ?></td>
                                    <td class="image-cell">
                                        <div class="image pro_image">
                                            <img src="../assets/images/product_image/<?= $row['product_image_1'] ?>"
                                                alt="product_image_1" />
                                        </div>
                                    </td>
                                    <td class="image-cell">
                                        <div class="image pro_image">
                                            <img src="../assets/images/product_image/<?= $row['product_image_2'] ?>"
                                                alt="product_image_2" />
                                        </div>
                                    </td>

                                    <td class="actions-cell">
                                        <div class="buttons   nowrap">
                                            <button class="button small blue --jb-modal" data-target="View-modal"
                                                onclick="openViewModal('<?= $row['product_name'] ?>', '<?= $row['product_description'] ?>', '<?= $row['product_price'] ?>' , '<?= $row['product_sku'] ?>', '<?= $row['product_category_name'] ?>', '<?= $row['promotion_category_name'] ?>' , '<?= $row['product_image_1'] ?>' , '<?= $row['product_image_2'] ?>')"
                                                type="button">
                                                <span class="icon"><i class="mdi mdi-eye"></i></span>
                                            </button>
                                            <button class="button small green --jb-modal" data-target="Edit-modal" onclick="openEditModal({
            id: '<?= $row['product_id'] ?>',
            name: '<?= $row['product_name'] ?>',
            description: '<?= $row['product_description'] ?>',
            price: '<?= $row['product_price'] ?>',
            sku: '<?= $row['product_sku'] ?>',
            category_id: '<?= $row['product_category_id'] ?>',
            promotion_id: '<?= $row['promotion_category_id'] ?>',
            image_1: '<?= $row['product_image_1'] ?>',
            image_2: '<?= $row['product_image_2'] ?>'
        })" type="button">
                                                <span class="icon"><i class="mdi mdi-square-edit-outline"></i></span>
                                            </button>
                                            <button class="button small red --jb-modal" onclick="openDeleteModal(this)"
                                                data-target="delete-modal" data-userid="<?= $row['product_id'] ?>"
                                                type="button">
                                                <span class="icon"><i class="mdi mdi-trash-can-outline"></i></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $counter++;
                            } ?>

                        </tbody>
                    </table>

                </div>
            </div>


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

        <!-- Delete Modal -->
        <div id="delete-modal" class="modal">
            <div class="modal-background --jb-modal-close"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Delete</p>
                </header>
                <section class="modal-card-body">
                    <p>You Want to Delete?</p>
                </section>
                <footer class="modal-card-foot">
                    <button class="button --jb-modal-close">No</button>

                    <a id="confirmDeleteBtn" href="?delete">
                        <button class="button red --jb-modal-close">Yes</button>
                    </a>
                </footer>
            </div>
        </div>


        <!-- View Modal -->
        <div id="View-modal" class="modal">
            <div class="modal-background --jb-modal-close"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">View Products</p>
                    <button class="delete --jb-modal-close" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                    <div class="field">
                        <label class="label">Product Name</label>
                        <div class="control">
                            <p id="viewProductName"> </p>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Product Description</label>
                        <div class="control">
                            <p id="viewProductDescription"></p>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Product Price</label>
                        <div class="control">
                            <p id="viewProductPrice"></p>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Product SKU</label>
                        <div class="control">
                            <p id="viewProductSKU"></p>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Product Category</label>
                        <div class="control">
                            <p id="viewProductCategory"></p>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Promotion Category</label>
                        <div class="control">
                            <p id="viewPromotionCategory"></p>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Product Image 1</label>
                        <div class="control">
                            <img width="200px" id="viewProductImage_1" src="">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Product Image 2</label>
                        <div class="control">

                            <img width="200px" id="viewProductImage_2" src="">
                        </div>
                    </div>

                </section>
                <footer class="modal-card-foot">
                    <button class="button --jb-modal-close">Close</button>
                </footer>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="Edit-modal" class="modal">
            <div class="modal-background --jb-modal-close"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Edit Product</p>
                    <button class="delete --jb-modal-close" aria-label="close"></button>
                </header>
                <form id="editProductForm" method="POST" enctype="multipart/form-data" action="allProduct.php">
                    <section class="modal-card-body">
                        <input type="hidden" id="editProductId" name="product_id">
                        <div class="field">
                            <label class="label">Product Name</label>
                            <div class="control">
                                <input type="text" id="editProductName" name="product_name"
                                    placeholder="Enter Product Name" required
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Product Description</label>
                            <div class="control">
                                <textarea id="editProductDescription" placeholder="Enter Product Description" rows="1"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6"
                                    rows="4" type="text" name="product_description" required> </textarea>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Product Price</label>
                            <div class="control">
                                <input type="number" id="editProductPrice" name="product_price"
                                    placeholder="Enter Product Price" required
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Product SKU</label>
                            <div class="control">
                                <input type="text" id="editProductSKU" name="product_sku"
                                    placeholder="Enter Product SKU" required
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6">
                            </div>
                        </div>

                        <div class="field">
                            <label for="product_category" class="block text-base font-medium text-gray-900">Product
                                Category</label>
                            <div class="mt-2 grid grid-cols-1">
                                <select id="editProductCategory" name="product_category_id"
                                    autocomplete="product_category"
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
                            <label for="promotion_category" class="block text-base font-medium text-gray-900">Promotion
                                Category</label>
                            <div class="mt-2 grid grid-cols-1">
                                <select id="editPromotionCategory" name="promotion_category_id"
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

                        <div>
                            <label for="cover-photo" class="block text-basefont-medium text-gray-800">Product Image
                                1</label>
                            <div
                                class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 py-2">
                                <div class="text-center">
                                    <svg class="mx-auto size-8 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                                        aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div class="mt-2 flex text-sm/6 text-gray-600">
                                        <label for="product_image_1"
                                            class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-blue-500">
                                            <span>Upload a file</span>
                                            <input id="product_image_1" name="product_image_1" type="file"
                                                class="sr-only" id="editProductImage1">
                                            <img id="currentProductImage1" width="100px" class="mt-2">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="cover-photo" class="block text-basefont-medium text-gray-800">Product Image
                                2</label>
                            <div
                                class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 py-2">
                                <div class="text-center">
                                    <svg class="mx-auto size-8 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                                        aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div class="mt-2 flex text-sm/6 text-gray-600">
                                        <label for="product_image_2"
                                            class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-blue-500">
                                            <span>Upload a file</span>
                                            <input id="product_image_2" name="product_image_2" type="file"
                                                class="sr-only" id="editProductImage2">
                                            <img id="currentProductImage2" width="100px" class="mt-2">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button type="button" class="button --jb-modal-close">Cancel</button>
                        <button type="submit" class="button blue">Update</button>
                    </footer>
                </form>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script>
        let table = new DataTable('#myTable');

    </script>

    <!-- Scripts below are for demo only -->
    <script type="text/javascript" src="../assets/js/main.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script type="text/javascript" src="../assets/js/chart.sample.min.js"></script>

    <!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

</body>

<script>
    function openDeleteModal(button) {
        // User ID lein button se
        const product_id = button.getAttribute('data-userid');

        // Modal ka Confirm Button
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        // Set Delete Link Dynamically
        confirmDeleteBtn.href = "?delete=" + product_id;

        // Modal ko Show Karein
        document.getElementById('deleteModal').classList.add('is-active');
    }

    // Modal Close Karein
    document.querySelectorAll('.--jb-modal-close').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteModal').classList.remove('is-active');
        });
    });


    // Edit Modal
    function openEditModal(product) {
        // Populate fields with product data
        document.getElementById('editProductId').value = product.id;
        document.getElementById('editProductName').value = product.name;
        document.getElementById('editProductDescription').value = product.description;
        document.getElementById('editProductPrice').value = product.price;
        document.getElementById('editProductSKU').value = product.sku;

        // Set selected options for dropdowns
        document.getElementById('editProductCategory').value = product.category_id;
        document.getElementById('editPromotionCategory').value = product.promotion_id;

        // Set images
        document.getElementById('currentProductImage1').src = `../assets/images/product_image/${product.image_1}`;
        document.getElementById('currentProductImage2').src = `../assets/images/product_image/${product.image_2}`;

        // Show modal
        document.getElementById('Edit-modal').classList.add('is-active');
    }

    // Close modal functionality
    document.querySelectorAll('.--jb-modal-close').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('Edit-modal').classList.remove('is-active');
        });
    });


    // View Modal
    function openViewModal(product_name, product_description, product_price, product_sku, cate_name, promotion_category_id, product_image_1, product_image_2) {
        // Fill the modal input fields with the selected user's data
        document.getElementById('viewProductName').innerText = product_name;
        document.getElementById('viewProductDescription').innerText = product_description;
        document.getElementById('viewProductPrice').innerText = product_price;
        document.getElementById('viewProductSKU').innerText = product_sku;
        document.getElementById('viewProductCategory').innerText = cate_name;
        document.getElementById('viewPromotionCategory').innerText = promotion_category_id;
        document.getElementById('viewProductImage_1').src = `../assets/images/product_image/${product_image_1}`;
        document.getElementById('viewProductImage_2').src = `../assets/images/product_image/${product_image_2}`;

        // Show the modal
        document.getElementById('View-modal').classList.add('is-active');

    }

    // Close modal functionality
    document.querySelectorAll('.--jb-modal-close').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('View-modal').classList.remove('is-active');
        });
    });



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