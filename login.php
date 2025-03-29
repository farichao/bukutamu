<?php
session_start();

$valid_user = "admin";
$valid_pass = "12345";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $valid_user && $password === $valid_pass) {
        $_SESSION['username'] = $username;
        $_SESSION['welcome_message'] = "Selamat datang " . $username . "!";
        header("Location: newdashboard.php");
        exit();
    } else {
        header("Location: login.php?error=Username atau password salah!");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Login</h2>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">

    </form>

    <?php
    if (isset($_GET['error'])) {
        echo "<p class='message'>".$_GET['error']."</p>";
    }
    ?>
    
</div>

</body>
</html>
