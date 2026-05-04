<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$user' AND password='$pass'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $_SESSION['admin'] = $user;
        header("Location: admin_dashboard.php");
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f0f2f5;
        }

        /* Top Blue Bar */
        .topbar {
            background: #1877f2;
            color: white;
            padding: 15px;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
        }

        /* Center Box */
        .login-box {
            width: 350px;
            background: white;
            padding: 30px;
            margin: 80px auto;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #1877f2;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input:focus {
            border-color: #1877f2;
            outline: none;
            box-shadow: 0 0 5px rgba(24,119,242,0.3);
        }

        button {
            width: 100%;
            padding: 12px;
            background: #1877f2;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #0d65d9;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: gray;
        }
    </style>
</head>

<body>

<div class="topbar">
    🍽️ Halal Bites Admin Panel
</div>

<div class="login-box">
    <h2>Admin Login</h2>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="login">Login</button>
    </form>

    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

    <div class="footer">
        © 2026 Halal Bites Restaurant System
    </div>
</div>

</body>
</html>