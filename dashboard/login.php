<?php

session_start();
include "../includes/db.php";
$error = false;

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Email aur password check karne ka query
    $result = $conn->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Session set karein
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['email'] = $row['email'];

        // Dashboard pe redirect karein
        header("Location: index.php");
        echo "Valid";
        exit();

    } else {
        // echo "InValid";
        $error = true;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Amour Roses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
</head>

<body>
    <?php
    //  Alert Error Popup
    if ($error) {
        echo "<div id='alert-border-1'
            class='flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800'
            role='alert'>
            <div class='ms-3 text-sm font-medium'>
              <b> Error! </b>Email and Password Invalid.
            </div>
            <button type='button'
                class='ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700'
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
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-20 mt-4 w-auto" src="../assets/images/logo_bw.png" alt="Your Company">
            <h2 class="mt-8 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Login to your Account</h2>
        </div>

        <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" method="POST">
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input type="email" placeholder="Enter Your Email" name="email" id="email" autocomplete="email"
                            required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6">
                    </div>
                </div>

                <div>

                    <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>

                    <div class="mt-2">
                        <input type="password" name="password" placeholder="Enter Your Password" id="password"
                            autocomplete="current-password" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <button type="submit" name="login"
                        class=" mt-8 flex w-full justify-center rounded-md bg-gray-950 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-zinc-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-600">Login</button>
                </div>
            </form>
        </div>
    </div>

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