<?php
session_start();
$localhost = 'localhost';
$username = 'root';
$password = '';
$databasename = 'carinfo';

$conn = new mysqli($localhost, $username, $password, $databasename);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['btnsubmit'])) {

    $fileUploaded = isset($_FILES['upload']) && $_FILES['upload']['error'] == UPLOAD_ERR_OK;
    $cyear = $_POST['cyear'] ?? '';
    $companyname = $_POST['companyname'] ?? '';
    $cname = $_POST['cname'] ?? '';
    $cspeed = $_POST['cspeed'] ?? '';
    $speedminutes = $_POST['speedminutes'] ?? '';
    $fileUploaded = $_POST['upload'] ?? '';

    if (empty($cyear) || empty($companyname) || empty($cname) || empty($cspeed) || empty($speedminutes)) {
        echo "<script>alert('Please fill all required fields.');</script>";
    } else {
        if ($fileUploaded) {
            $file = $_FILES['csv_file']['tmp_name'];
            $handle = fopen($file, "r");

            $lines = file($file, FILE_IGNORE_NEW_LINES);

            foreach ($lines as $line) {
                $data = explode(",", $line);

                if ($data[0] == 'item_code') {
                    continue;
                }

                if (count($data) < 5) {
                    continue;
                }

                $item_code = $data[0];
                $name = $data[1];
                $type = $data[2];
                $price = $data[3];
                $description = $data[4];

                $sql = "INSERT INTO carinfo (car_year, car_company, car_name, car_speed, car_speedtime) VALUES (?, ?, ?, ?, ?)";
                $qu = $conn->query($sql);

                if (!$qu) {
                    echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
                }
            }

            fclose($handle);
            header("Location: index.php");
            exit();
        }

        $sql = "INSERT INTO carinfo (car_year, car_company, car_name, car_speed, car_speedtime) VALUES ('$cyear', '$companyname', '$cname', '$cspeed', '$speedminutes')";
        $insert = $conn->query($sql);
        if ($insert) {
            echo "<script>alert('Data added successfully');</script>";
            header('location: index.php');
            exit();
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
        $conn->close();
    }
}

if (isset($_POST['btndelete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM carinfo WHERE id = $id";
    $conn->query($sql);
    if ($sql === false) {
        die("Error preparing statement: " . $conn->error);
    }

    if ($sql) {
        echo "<script>alert('Record deleted successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

if (isset($_POST['btnEdit'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("SELECT * FROM carinfo WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $cyear = $row['car_year'];
        $companyname = $row['car_company'];
        $cname = $row['car_name'];
        $cspeed = $row['car_speed'];
        $speedminutes = $row['car_speedtime'];
        $editId = $row['id'];
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

if (isset($_POST['btnUpdate'])) {
    $id = $_POST['id'];
    $cyear = $_POST['cyear'];
    $companyname = $_POST['companyname'];
    $cname = $_POST['cname'];
    $cspeed = $_POST['cspeed'];
    $speedminutes = $_POST['speedminutes'];

    $sql = "UPDATE carinfo SET car_year = '$cyear', car_company = '$companyname', car_name = '$cname', car_speed = '$cspeed', car_speedtime = '$speedminutes' WHERE id = $id";
    $update = $conn->query($sql);
    if ($update) {
        echo "<script>alert('Record updated successfully');</script>";
        header('location: index.php');
        exit();
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
}

//bulk insert

if (isset($_POST['bulk_insert'])) {
    $file = $_FILES['csv_file']['tmp_name'];
    if (empty($file)) {

        echo '<script>alert("Please select the file")</script>';
        header('location: index.php');
        exit();
    }
    $handle = fopen($file, "r");
    
    $lines = file($file, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $line) {
        $data = explode(",", $line);

        if ($data[0] == 'id') {
            continue;
        }

        if (count($data) < 5) {
            continue;
        }

        $cyear = $data[0];
        $companyname = $data[1];
        $cname = $data[2];
        $cspeed = $data[3];
        $speedminutes = $data[4];

        $sql = "INSERT INTO carinfo (car_year, car_company, car_name, car_speed, car_speedtime) VALUES('$cyear', '$companyname', '$cname', '$cspeed', '$speedminutes')";
        $qu = $conn->query($sql);

        if (!$qu) {
            echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
        }
    }

    fclose($handle);
    header("Location: index.php");
    exit();
}
//end  bulk




$result = $conn->query("SELECT * FROM carinfo");
if ($result === false) {
    die("Error fetching data: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Car Information Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .form-container {
            background: #fff;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .table-container {
            max-width: 100%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table-container .button {
            padding: 5px 20px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
        }

        .button.delete {
            background-color: #dc3545;
        }

        .button.delete:hover {
            background-color: #c82333;
        }

        .button.edit {
            background-color: #28a745;
        }

        .button.edit:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Car Information Form</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($editId ?? ''); ?>">

            <div class="form-group">
                <label for="cyear">Car Model Year:</label>
                <input type="text" id="cyear" name="cyear" value="<?php echo htmlspecialchars($cyear ?? ''); ?>"
                    pattern="[0-9]{4}">
            </div>
            <div class="form-group">
                <label for="companyname">Car Company Name:</label>
                <input type="text" id="companyname" name="companyname"
                    value="<?php echo htmlspecialchars($companyname ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="cname">Car Name:</label>
                <input type="text" id="cname" name="cname" value="<?php echo htmlspecialchars($cname ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="cspeed">Car Speed:</label>
                <input type="text" id="cspeed" name="cspeed" value="<?php echo htmlspecialchars($cspeed ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="speedminutes">Car Speed Minutes:</label>
                <input type="text" id="speedminutes" name="speedminutes"
                    value="<?php echo htmlspecialchars($speedminutes ?? ''); ?>">
            </div>
            <div class="form-group">
                <?php if (isset($editId)): ?>
                    <input type="submit" name="btnUpdate" value="Update">
                <?php else: ?>
                    <input type="submit" name="btnsubmit" value="Submit">
                <?php endif; ?>
            </div>
            <h2>Upload CSV</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="file" name="csv_file">
                    <input type="submit" name="bulk_insert" value="Bulk Insert">
                </div>
            </form>

        </form>
    </div>

    <div class="table-container">
        <h2>All Car Information</h2>
        <table>
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Company Name</th>
                    <th>Car Name</th>
                    <th>Speed</th>
                    <th>Speed Minutes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id']; 
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['car_year']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['car_company']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['car_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['car_speed']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['car_speedtime']) . "</td>";
                    echo "<td>";
                    echo "<form method='post' style='display:inline;'>";
                    echo "<input type='hidden' name='id' value='$id'>";
                    echo "<input type='submit' name='btndelete' value='Delete' class='button delete'>";
                    echo "<input type='submit' name='btnEdit' value='Edit' class='button edit'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>