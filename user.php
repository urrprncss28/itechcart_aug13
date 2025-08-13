<?php
session_start();
include("includes/db.connection.php");

// Initialize user data in session if not set
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [
        'profile' => '',
        'username' => '',
        'phone' => '',
        'email' => '',
        'password' => ''
    ];
}

$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $_SESSION['user']['profile'] = htmlspecialchars($_POST['profile']);
    $_SESSION['user']['username'] = htmlspecialchars($_POST['username']);
    $_SESSION['user']['phone'] = htmlspecialchars($_POST['phone']);
    $_SESSION['user']['email'] = htmlspecialchars($_POST['email']);
    if (!empty($_POST['password'])) {
        $_SESSION['user']['password'] = htmlspecialchars($_POST['password']);
    }
    $success = true;

    // Clear form fields (optional)
    $profile = $username = $phone = $email = $password = '';
} else {
    $profile = $_SESSION['user']['profile'];
    $username = $_SESSION['user']['username'];
    $phone = $_SESSION['user']['phone'];
    $email = $_SESSION['user']['email'];
    $password = $_SESSION['user']['password'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap CSS offline -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- FontAwesome offline -->
    <link rel="stylesheet" href="css/fontawesome.min.css" />
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .account-container {
            max-width: 600px;
            margin: 70px auto;
            background: #fff;
            border-radius: 14px;
            box-shadow:
                0 10px 20px rgba(242, 101, 34, 0.15),
                0 6px 6px rgba(0, 0, 0, 0.07);
            border: 1px solid #eee;
            overflow: hidden;
        }
        .header {
            padding: 18px 25px;
            background-color: #fff;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            border-radius: 14px 14px 0 0;
        }
        .back-arrow {
            font-size: 22px;
            color: #f26522;
            text-decoration: none;
            margin-right: 14px;
            user-select: none;
            transition: color 0.3s ease;
        }
        .back-arrow:hover {
            color: #d35400;
        }
        .title {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.03em;
        }
        .success-message {
            color: #2e7d32;
            background: #e6f4ea;
            border: 1px solid #a6d8a8;
            border-radius: 8px;
            padding: 15px 20px;
            margin: 20px 30px 10px;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 0 10px rgba(46, 125, 50, 0.2);
        }
        form {
            padding: 30px 40px 40px;
        }
        label.form-label {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 6px;
            color: #444;
        }
        .form-control {
            border-radius: 8px !important;
            border: 1.5px solid #ddd !important;
            background: #fcfcfc !important;
            padding: 14px 18px !important;
            font-size: 1rem !important;
            transition: border-color 0.3s ease, box-shadow 0.3s ease !important;
            box-shadow: none !important;
        }
        .form-control:focus {
            border-color: #f26522 !important;
            box-shadow: 0 0 8px rgba(242, 101, 34, 0.4) !important;
            outline: none !important;
            background: #fff !important;
        }
        .password-wrapper {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 16px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #bbb;
            transition: color 0.3s ease;
            user-select: none;
        }
        .toggle-password:hover {
            color: #f26522;
        }
        .btn-save {
            background-color: #f26522;
            border-color: #f26522;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 14px 0;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(242, 101, 34, 0.3);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }
        .btn-save:hover,
        .btn-save:focus {
            background-color: #d35400;
            border-color: #d35400;
            box-shadow: 0 8px 20px rgba(211, 84, 0, 0.4);
            color: white;
        }
        .btn-logout {
            margin-top: 15px;
            width: 100%;
            font-weight: 700;
            font-size: 1.05rem;
            border-radius: 10px;
            padding: 12px 0;
        }
        /* Responsive tweaks */
        @media (max-width: 576px) {
            .account-container {
                margin: 40px 15px;
                padding: 0;
            }
            form {
                padding: 25px 20px 30px;
            }
            .btn-save {
                font-size: 1rem;
                padding: 12px 0;
            }
            .btn-logout {
                font-size: 1rem;
                padding: 10px 0;
            }
            .title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<div class="account-container shadow-sm">
    <div class="header">
        <a href="home.php" class="back-arrow" aria-label="Go back">&#8592;</a>
        <div class="title">Account</div>
    </div>

    <?php if ($success): ?>
        <div class="success-message">Your information has been updated successfully.</div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="profile" class="form-label">Full Name</label>
            <input type="text" id="profile" name="profile" class="form-control" value="<?= htmlspecialchars($profile) ?>" placeholder="Enter Full name" required autocomplete="name" />
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>" placeholder="Enter Username" required autocomplete="username" />
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>" placeholder="Enter Phone number" pattern="[0-9\-\+\s]{7,15}" autocomplete="tel" />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" placeholder="Enter Email address" required autocomplete="email" />
        </div>

        <div class="mb-4 password-wrapper">
            <label for="password" class="form-label">Change Password</label>
            <input type="password" id="password" name="password" class="form-control pe-5" placeholder="Enter new password (leave blank to keep current)" autocomplete="new-password" />
            <span id="togglePassword" class="toggle-password" aria-label="Toggle password visibility" role="button" tabindex="0">
                <i class="fa fa-eye-slash" aria-hidden="true"></i>
            </span>
        </div>

        <form method="POST" action="" class="px-4 pt-0 pb-4"><button type="submit" name="save" class="btn btn-save w-100">Save Changes</button>
</form>

<form method="POST" action="logout.php" class="px-4 pt-0 pb-4">
    <button type="submit" class="btn btn-lg w-100 fs-6"style="background-color: #5e2df2ff; color: white; border: none;">Logout</a>
</form>


<script src="js/fontawesome.min.js"></script>
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePassword.innerHTML = type === 'password' 
                ? '<i class="fa fa-eye-slash" aria-hidden="true"></i>'
                : '<i class="fa fa-eye" aria-hidden="true"></i>';
        });
    }
</script>

</body>
</html>
