<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
</head>
<body>
    <h1>Upload Image</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="caption">Caption:</label>
        <input type="text" id="caption" name="caption" required>
        <br>
        <label for="image">Select Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        <br>
        <input type="submit" value="Upload Image">
    </form>
</body>
</html>

<?php
// Database connection
$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "supreme_solns"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $caption = $_POST['caption'];
    
    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $filePath = "uploads/" . $fileName; // Assuming you have an 'uploads' directory

        // Move the file to the uploads directory
        if (move_uploaded_file($fileTmpPath, $filePath)) {
            // Insert the image path and caption into the database
            $sql = "INSERT INTO gallery (image_path, caption) VALUES ('$filePath', '$caption')";
            if ($conn->query($sql) === TRUE) {
                echo "Image uploaded successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error moving the uploaded file.";
        }
    } else {
        echo "Error uploading the image.";
    }
}

$conn->close();
?>