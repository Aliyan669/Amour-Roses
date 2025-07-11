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



// Check if the form is submitted
if (isset($_POST['addCategory'])) {
  $category_name = $_POST['category_name'];
  $category_desc = $_POST['category_desc'];
  $upload_dir = '../assets/images/cate_image/';
  $image_name = '';

  // Handle file upload
  if (isset($_FILES['file-upload']) && $_FILES['file-upload']['error'] == UPLOAD_ERR_OK) {
    $image_name = basename($_FILES['file-upload']['name']);
    $target_file = $upload_dir . $image_name;

    // Validate file type (only allow PNG, JPG, JPEG, GIF)
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (in_array($file_type, ['png', 'jpg', 'jpeg', 'gif'])) {
      if (move_uploaded_file($_FILES['file-upload']['tmp_name'], $target_file)) {
        // echo "Image uploaded successfully!";
      } else {
        // die("Error uploading image.");
      }
    } else {
      // die("Invalid file type. Only PNG, JPG, JPEG, and GIF are allowed.");
    }
  } else {
    die("No file uploaded or error in upload.");
  }

  // Insert data into database
  $sql = "INSERT INTO `category` ( `cate_name`, `cate_description`, `cate_image`) VALUES ( '$category_name', '$category_desc', '$image_name')";

  $result = mysqli_query($conn, $sql);
  if ($result) {
    // echo "Category added successfully!";

    $insert = true;
    // header("Location: allCategory.php"); // Redirect to the category list page
    // exit;
  } else {
    echo "failed Data Inserted " . mysqli_error($conn);
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
                <img
                  src="https://img.freepik.com/premium-vector/man-avatar-profile-picture-isolated-background-avatar-profile-picture-man_1293239-4866.jpg?semt=ais_hybrid"
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
          <a href="https://github.com/Aliyan669/Amour-Roses" class="navbar-item has-divider desktop-icon-only">
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
              <li class="--set-active-tables-html">
                <a href="allCategory.php">
                  <span class="icon"><i class="mdi mdi-check-all"></i></span>
                  <span class="menu-item-label">All Category</span>
                </a>
              </li>
              <li class="active">
                <a href="addCategory.php">
                  <span class="icon"><i class="mdi mdi-plus"></i></span>
                  <span class="menu-item-label">Add Category</span>
                </a>
              </li>
            </ul>
          </li>

          <li>
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
    if ($insert) {
      echo "<div id='alert-border-1'
            class='flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800'
            role='alert'>
            <div class='ms-3 text-sm font-medium'>
              <b> Success!</b> Category Has Been Added Successfully.
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
          <li>Add Category</li>
        </ul>

      </div>
    </section>

    <section class="is-hero-bar">
      <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
        <h1 class="title">
          Add Category
        </h1>
      </div>
    </section>

    <section class="section main-section">

      <form method="POST" action="addCategory.php" enctype="multipart/form-data">
        <div class="space-y-12">

          <div class="border-b border-gray-900/10 pb-12">

            <div class="grid grid-cols-1 gap-x-4 gap-y-8 ">

              <div>
                <label for="username" class="block text-base font-medium text-gray-800">Category Name</label>
                <div class="mt-2">
                  <div
                    class="flex items-center rounded-md bg-white pl-3  outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-blue-600">
                    <input type="text" name="category_name" id="category_name" required
                      class="block min-w-0 grow py-2.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6"
                      placeholder="Enter Category Name">
                  </div>
                </div>
              </div>

              <div>
                <label for="about" class="block text-base font-medium text-gray-800">Category Description</label>
                <div class="mt-2">
                  <textarea required name="category_desc" id="category_desc" rows="4"
                    placeholder="Enter Category Description"
                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6"></textarea>
                </div>
              </div>

              <div>
                <label for="cover-photo" class="block text-basefont-medium text-gray-800">Category Photo</label>
                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 py-10">
                  <div class="text-center">
                    <svg class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                      aria-hidden="true" data-slot="icon">
                      <path fill-rule="evenodd"
                        d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                        clip-rule="evenodd" />
                    </svg>
                    <div class="mt-4 flex text-sm/6 text-gray-600">
                      <label for="file-upload"
                        class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-blue-500">
                        <span>Upload a file</span>
                        <input id="file-upload" name="file-upload" required name="file-upload" type="file"
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
          <button name="addCategory"
            class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
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

</html>