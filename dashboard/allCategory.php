<?php
include "../includes/db.php";
require '../includes/auth.php';

$update = false;
$delete = false;

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

    $sql = "DELETE from category WHERE cate_id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // echo "Successfully Data Deleted";
        // header("Location: allCategory.php");
        $delete = true;

    } else {
        echo "failed Category Deleted " . mysqli_error($conn);
    }
}


// Update Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cate_id'])) {
    $cate_id = (int) $_POST['cate_id'];
    $cate_name = $_POST['cate_name'];
    $cate_description = $_POST['cate_description'];

    // Image Handling
    $imageSql = '';
    if (!empty($_FILES['cate_image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['cate_image']['name']);
        $targetDir = "../assets/images/cate_image/";
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES['cate_image']['tmp_name'], $targetFile)) {
            $imageSql = ", cate_image='$imageName'";
        } else {
            echo "Error uploading image.";
        }
    }

    $sql = "UPDATE category 
            SET cate_name='$cate_name', cate_description='$cate_description' $imageSql  WHERE cate_id=$cate_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $update = true;
        // echo "category Updated ";
    } else {
        echo "Failed Data Updated " . mysqli_error($conn);
    }
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
            margin: 5px 0px 5px 0px;
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
                            <a class="navbar-item">
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
                    <a target="_blank" href="https://github.com/Aliyan669/Amour-Roses"
                        class="navbar-item has-divider desktop-icon-only">
                        <span class="icon"><i class="mdi mdi-github-circle"></i></span>
                        <span>GitHub</span>
                    </a>
                    <a href="logout.php" title="Log out" class="navbar-item desktop-icon-only">
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

                    <li class="--set-active-tables-html">
                        <a class="dropdown">
                            <span class="icon"><i class="mdi mdi-tag-text-outline"></i></span>
                            <span class="menu-item-label">Products</span>
                            <span class="icon seticon"><i class="mdi mdi-chevron-down"></i></span>
                        </a>
                        <ul>
                            <li>
                                <a href="allProduct.php">
                                    <span class="icon"><i class="mdi mdi-check-all"></i></span>
                                    <span class="menu-item-label">All Products</span>
                                </a>
                            </li>
                            <li>
                                <a href="addProduct.php">
                                    <span class="icon"><i class="mdi mdi-plus"></i></span>
                                    <span class="menu-item-label">Add Products</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="active">
                        <a class="dropdown">
                            <span class="icon"><i class="mdi mdi-shape-plus"></i></span>
                            <span class="menu-item-label">Category</span>
                            <span class="icon seticon"><i class="mdi mdi-chevron-down"></i></span>
                        </a>
                        <ul>
                            <li class="active">
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
                            <li>
                                <a href="allUsers.php">
                                    <span class="icon"><i class="mdi mdi-check-all"></i></span>
                                    <span class="menu-item-label">All User</span>
                                </a>
                            </li>
                            <li>
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
              <b> Success!</b> Category Has Been Updated Successfully.
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
              <b>Success!</b> Category Has Been Deleted Successfully.
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
                    <li>All Category</li>
                </ul>

            </div>
        </section>

        <section class="is-hero-bar">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
                <h1 class="title">
                    All Category
                </h1>
                <a href="allCategory.php">
                    <button class="button blue">Refresh</button>
                </a>
            </div>
        </section>
        <section class="section main-section">

            <div class="card has-table">
                <div class="card-content">
                    <table id="myTable">
                        <thead>

                            <tr>
                                <th>Id</th>
                                <th>Category Name</th>
                                <th>Category Description</th>
                                <th>Image</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            $result = $conn->query("SELECT * FROM category");
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $counter ?></td>
                                    <td data-label="category_name"><?= $row['cate_name'] ?></td>
                                    <td data-label="category_desc"><?= $row['cate_description'] ?></td>
                                    <td class="image-cell ">
                                        <div class="image pro_image">
                                            <img src="../assets/images/cate_image/<?= $row['cate_image'] ?>"
                                                alt="Category Image" />
                                        </div>
                                    </td>

                                    <td class="actions-cell">
                                        <div class="buttons   nowrap">
                                            <button class="button small blue --jb-modal" type="button"
                                                data-target="View-modal"
                                                onclick="openViewModal('<?= $row['cate_name'] ?>', '<?= $row['cate_description'] ?>', '<?= $row['cate_image'] ?>')">
                                                <span class="icon"><i class="mdi mdi-eye"></i></span>
                                            </button>
                                            <button class="button small green --jb-modal" data-target="Edit-modal"
                                                onclick="openEditModal(<?= $row['cate_id'] ?>, '<?= $row['cate_name'] ?>', '<?= $row['cate_description'] ?>' , '<?= $row['cate_image'] ?>')"
                                                type="button">
                                                <span class="icon"><i class="mdi mdi-square-edit-outline"></i></span>
                                            </button>
                                            <button class="button small red --jb-modal" onclick="openDeleteModal(this)"
                                                data-target="delete-modal" data-userid="<?= $row['cate_id'] ?>"
                                                type="button">
                                                <span class="icon"><i class="mdi mdi-trash-can-outline"></i></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr><?php
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


        <!-- Edit Modal -->
        <div id="Edit-modal" class="modal">
            <div class="modal-background --jb-modal-close"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Edit Category</p>
                    <button class="delete --jb-modal-close" aria-label="close"></button>
                </header>
                <form id="editCategoryForm" method="POST" enctype="multipart/form-data" action="allcategory.php">
                    <section class="modal-card-body">
                        <input type="hidden" id="editCateId" name="cate_id">
                        <div class="field">
                            <label class="label">Category Name</label>
                            <div class="control">
                                <input type="text" id="editCateName" name="cate_name" placeholder="Enter Category Name"
                                    required
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Category Description</label>
                            <div class="control">
                                <textarea id="editCateDesc" placeholder="Enter Category Description" rows="1"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6"
                                    rows="4" type="text" name="cate_description" required> </textarea>
                            </div>
                        </div>
                        <div>
                            <label for="cover-photo" class="block text-basefont-medium text-gray-800">Category
                                Photo</label>
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
                                        <label for="file-upload"
                                            class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-blue-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="cate_image" type="file" class="sr-only"
                                                id="editCateImage">
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


        <!-- View Modal -->
        <div id="View-modal" class="modal">
            <div class="modal-background --jb-modal-close"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">View Category</p>
                    <button class="delete --jb-modal-close" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                    <div class="field">
                        <label class="label">Category Name</label>
                        <div class="control">
                            <p id="viewCateName"> </p>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Category Description</label>
                        <div class="control">
                            <p id="viewCateDesc"></p>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Category Image</label>
                        <div class="control">
                            <img width="200px" id="viewCateImage" src="">
                        </div>
                    </div>

                </section>
                <footer class="modal-card-foot">
                    <button class="button --jb-modal-close">Close</button>
                </footer>
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

    // Delete Modal
    function openDeleteModal(button) {
        // User ID lein button se
        const cate_id = button.getAttribute('data-userid');

        // Modal ka Confirm Button
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        // Set Delete Link Dynamically
        confirmDeleteBtn.href = "?delete=" + cate_id;

        // Modal ko Show Karein
        document.getElementById('deleteModal').classList.add('is-active');
    }

    // Modal Close Karein
    document.querySelectorAll('.--jb-modal-close').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('deleteModal').classList.remove('is-active');
        });
    });


    // Open Edit Modal
    function openEditModal(cate_id, cate_name, cate_description) {
        document.getElementById('editCateId').value = cate_id;
        document.getElementById('editCateName').value = cate_name;
        document.getElementById('editCateDesc').value = cate_description;
        document.getElementById('Edit-modal').classList.add('is-active');

    }

    document.querySelectorAll('.--jb-modal-close').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('Edit-modal').classList.remove('is-active');
        });
    });


    // View Modal
    function openViewModal(cate_name, cate_description, cate_image) {
        // Fill the modal input fields with the selected user's data
        document.getElementById('viewCateName').innerText = cate_name;
        document.getElementById('viewCateDesc').innerText = cate_description;
        document.getElementById('viewCateImage').src = `../assets/images/cate_image/${cate_image}`;

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