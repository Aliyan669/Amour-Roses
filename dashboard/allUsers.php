<?php
include "../includes/db.php";
require '../includes/auth.php';

$insert = false;
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

    $sql = "DELETE from users WHERE user_id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // echo "Successfully Data Deleted";
        $delete = true;
        header("Location: allUsers.php");

    } else {
        echo "failed Data Deleted " . mysqli_error($conn);
    }
}



// Update
if (isset($_POST['update'])) {
    $id = (int) $_POST['user_id'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "UPDATE users SET email='$email', password = '$password' WHERE user_id = $id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // echo "Successfully Data Updated";
        $update = true;
        // echo " Data Updated ";

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
                    <a class="navbar-item has-divider desktop-icon-only">
                        <span class="icon"><i class="mdi mdi-help-circle-outline"></i></span>
                        <span>About</span>
                    </a>
                    <a href="https://github.com/Aliyan669/Amour-Roses"
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
                            <li class="--set-active-tables-html">
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

                    <li class="active">
                        <a class="dropdown">
                            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
                            <span class="menu-item-label">Users</span>
                            <span class="icon seticon"><i class="mdi mdi-chevron-down"></i></span>
                        </a>
                        <ul>
                            <li class="active">
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
              <b> Success!</b> User Has Been Updated Successfully.
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
              <b> Success!</b> User Has Been Deleted Successfully.
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
                    <li>All Users</li>
                </ul>

            </div>
        </section>

        <section class="is-hero-bar">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
                <h1 class="title">
                    All Users
                </h1>
                <a href="allusers.php">
                    <button class="button large blue">Refresh</button>
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
                                <th>Username</th>
                                <th>Password</th>
                                <th>Date</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            $result = $conn->query("SELECT * FROM users");
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $counter ?></td>
                                    <td data-label="Email"><?= $row['email'] ?></td>
                                    <td data-label="Password"> <?= $row['password'] ?></td>
                                    <td data-label="Created">
                                        <small class="text-600" title="Jan 8, 2021"> <?= $row['datetime'] ?></small>
                                    </td>

                                    <td class="actions-cell">
                                        <div class="buttons  nowrap">
                                            <button class="button small blue --jb-modal" type="button"
                                                data-target="View-modal"
                                                onclick="openViewModal('<?= $row['email'] ?>', '<?= $row['password'] ?>')">
                                                <span class="icon"><i class="mdi mdi-eye"></i></span>
                                            </button>
                                            <button class="button small green --jb-modal" data-target="Edit-modal"
                                                onclick="openEditModal(<?= $row['user_id'] ?>, '<?= $row['email'] ?>', '<?= $row['password'] ?>')"
                                                type="button">
                                                <span class="icon"><i class=" mdi mdi-square-edit-outline"></i></span>
                                            </button>

                                            <button class="button small red --jb-modal" onclick="openDeleteModal(this)"
                                                data-target="delete-modal" data-userid="<?= $row['user_id'] ?>"
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
                    <p class="modal-card-title">Edit User</p>
                    <button class="delete --jb-modal-close" aria-label="close"></button>
                </header>
                <form id="editForm" method="POST" action="">
                    <section class="modal-card-body">
                        <input type="hidden" id="editUserId" name="user_id">
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input class="input" type="email" id="editEmail" name="email" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input class="input" type="text" id="editPassword" name="password" required>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button type="button" class="button --jb-modal-close">Cancel</button>
                        <button type="submit" name="update" class="button blue">Update</button>
                    </footer>
                </form>
            </div>
        </div>

        <!-- View Modal -->
        <div id="View-modal" class="modal">
            <div class="modal-background --jb-modal-close"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">View User</p>
                    <button class="delete --jb-modal-close" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <p id="viewEmail"> </p>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <p id="viewPassword"></p>
                        </div>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button class="button --jb-modal-close">Close</button>
                </footer>
            </div>
        </div>

    </div>
    <script
        src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script>
        let table = new DataTable('#myTable');

    </script>

    <!-- Scripts below are for demo only -->
    <script type="text/javascript" src="../assets/js/main.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script type="text/javascript" src=""></script>

    <!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

</body>

<script>

    // Delete Modal
    function openDeleteModal(button) {
        // User ID lein button se
        const userId = button.getAttribute('data-userid');

        // Modal ka Confirm Button
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        // Set Delete Link Dynamically
        confirmDeleteBtn.href = "?delete=" + userId;

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
    function openEditModal(userId, email, password) {
        // Fill the modal input fields
        document.getElementById('editUserId').value = userId;
        document.getElementById('editEmail').value = email;
        document.getElementById('editPassword').value = password;

        // Show the modal
        document.getElementById('Edit-modal').classList.add('is-active');
    }

    // Close modal functionality
    document.querySelectorAll('.--jb-modal-close').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('Edit-modal').classList.remove('is-active');
        });
    });

    // View Modal
    function openViewModal(email, password) {
        // Fill the modal input fields with the selected user's data
        document.getElementById('viewEmail').innerText = email;
        document.getElementById('viewPassword').innerText = password;

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