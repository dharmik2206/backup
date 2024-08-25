<!DOCTYPE html>
<html>
<head>
    <title>Python Code Executor</title>
</head>
<body>
    <h1>Python Code Executor</h1>
    <form method="post" action="">
        <textarea name="code" rows="10" cols="50" placeholder="Enter Python code here..."></textarea><br>
        <input type="submit" value="Execute Code">
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['code'])) {
        $code = $_POST['code'];
        $tempFile = tempnam(sys_get_temp_dir(), 'python_code_');
        file_put_contents($tempFile, $code);

        // Debugging information
        echo "<h2>Debugging Info:</h2>";
        echo "<p>Temp File Path: " . htmlspecialchars($tempFile) . "</p>";

        $command = escapeshellcmd("python3 " . escapeshellarg($tempFile));
        $output = shell_exec($command);

        if ($output === null) {
            echo "<p>Error executing command. Check server logs for more details.</p>";
        } else {
            echo "<h2>Output:</h2>";
            echo "<pre>" . htmlspecialchars($output) . "</pre>";
        }

        unlink($tempFile); // Clean up the temp file
    }
    ?>
</body>
</html>
uuuu