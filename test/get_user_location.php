<?php
header("Content-Type: application/json");
require('connection.php'); // Adjust the path to your connection file

$user_id = $_GET['user_id']; // or any other identifier for the user

// Validate input
if (!is_numeric($user_id)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user ID']);
    exit();
}

// Prepare and execute query
$stmt = $conn->prepare("SELECT latitude, longitude FROM user_locations WHERE user_id = ? ORDER BY timestamp DESC LIMIT 1");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $location = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'location' => $location]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No location found for this user']);
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get User Location</title>
    <script>
        function getLocation() {
            const userId = document.getElementById('user_id').value;

            if (!userId) {
                alert('Please enter a user ID.');
                return;
            }

            fetch(`get_user_location.php?user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(`User's Location: Latitude: ${data.location.latitude}, Longitude: ${data.location.longitude}`);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>
    <h1>Get User Location</h1>
    <form onsubmit="event.preventDefault(); getLocation();">
        <label for="user_id">User ID:</label>
        <input type="number" id="user_id" name="user_id" required><br>
        <button type="submit">Get Location</button>
    </form>
</body>
</html>

