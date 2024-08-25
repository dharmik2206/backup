<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example authentication (replace with your logic)
    if ($username == 'ab' && $password == '12') {
        $_SESSION['username'] = $username;
        
        if (isset($_POST['remember'])) {
            setcookie('username', $username, time() + (86400 * 30), "/");
        }
        header("Location: logout.php");
    } else {
        echo "Invalid credentials!";
    }
}
if (isset($_SESSION['username']) ) {
    header("Location: welcome.php");
    exit();
}
?>

<form method="post" action="">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    Remember Me: <input type="checkbox" name="remember"><br>
    <input type="submit" value="Login">
</form>
