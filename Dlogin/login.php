<?php
session_start();

$message = '';

if (isset($_POST['login'])) {
    $user = 'admin';
    $pass = '1234';

    if ($_POST['username'] == $user && $_POST['password'] == $pass) {
        $_SESSION['username'] = $user;
        header("Location: home.php");
        exit;
    } else {
        $message = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit" name="login">Login</button>
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>