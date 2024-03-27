<?php
define('Emember',true);
include('../includes/dbconnect.php');

if (empty($_SESSION['user_id'])) {
  header("Location: ../signin.php");
}

$success_message = "";


$post_id = $_GET['PID'];

$sql = "SELECT 
            b.post_id,
            b.title,
            b.description,
            b.post_type,
            b.content,
            u.fullname
        FROM 
            blogpost AS b
        JOIN
            users AS u ON b.user_id = u.user_id
        WHERE
            b.post_id = $post_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
     $row         = $result->fetch_assoc();
     $title       = $row['title'];
     $post_id     = $row['post_id'];
     $description = $row['description'];
     $fullname    = $row['fullname'];
     $post_type   = $row['post_type'];
     $content     = $row['content'];

     if($post_type =='iframe') {
        $content = htmlspecialchars($content);
     }

     $sql_comments = "SELECT 
                        c.comment_id,
                        c.comment_text,
                        c.created_at,
                        u.fullname AS commenter
                    FROM 
                        comments AS c
                    JOIN
                        users AS u ON c.user_id = u.user_id
                    WHERE
                        c.post_id = $post_id
                    ORDER BY
                        c.created_at DESC";

    $result_comments = $conn->query($sql_comments);

} else {
    echo "Post not found.";
}


    if (isset($_POST['edit_post'])) {
        $user_id     = $_SESSION['user_id'];
        $title       = $_POST['title'];
        $description = $_POST['description'];

        switch ($post_type) {
            case 'text':
                $content = $_POST['content'];
                break;
                
            case 'image':
                // Check if file was uploaded successfully
                    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $tempname = $_FILES["image"]["tmp_name"];
                        $folder = "img/post/";
                        // $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        // $content = uniqid('image_') . '.' . $file_extension;
                        // $destination = $folder . $content;

                        $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        $content = uniqid('image_') . '.' . $file_extension;
                        $destination = $folder . $content;

                        // Move the uploaded file to the destination folder
                        if (move_uploaded_file($tempname, $destination)) {
                            // File uploaded successfully
                            echo "<script>alert('Image uploaded successfully!');</script>";
                        } else {
                            // Failed to move the file
                            echo "<script>alert('Failed to upload image!');</script>";
                        }
                    } else {
                        // File upload error
                        echo "<script>alert('Error uploading image!');</script>";
                    }
                break;
                
            case 'iframe':
                $content = $_POST['link'];
                break;
                
            default:
                break;
        }

        // $content     = $_POST['content'];

        $update_date = date("Y-m-d");

        $sql = "UPDATE blogpost SET 
            title = '$title',
            description = '$description',
            content = '$content',
            update_date = '$update_date'
        WHERE post_id = $post_id";
        
        if ($conn->query($sql) === TRUE) {
            // Registration successful
            sleep(1);
            header('location: home.php');
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acme Inc.'s</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../style.css" rel="stylesheet">

</head>
<body>

<div class="container">
    <?php include "navigation_header.php"; ?>

    <br> <br> <br>
    <div class="card">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" value="<?=$title?>" placeholder="Enter your Title">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input type="text" class="form-control" name="description" value="<?=$description?>" placeholder="Enter your Description">
                </div>
                <div class="mb-3">
                    <label class="form-label">Content</label>

                    <?php if($post_type == 'text') {?>
                        <input type="text" name="content" value="<?=$content?>" class="form-control" placeholder="Enter your Content">
                    <?php }?>

                    <?php if($post_type == 'image') {?>
                        <input type="file" name="image" class="form-control-file">
                    <?php }?>

                    <?php if($post_type == 'iframe') {?>
                        <input type="text" name="link" value="<?=$content?>" class="form-control" placeholder="Enter your Content">
                    <?php }?>

                     <div id="emailHelp" class="form-text">Select what kind of post do you want</div>
                </div>
                <button type="submit" name="edit_post" class="btn btn-outline-primary">Submit</button>
                </form>
        </div>
    </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<script>
    // Get references to the input elements
    var textInput = document.getElementById("text-content");
    var imageInput = document.getElementById("image-content");
    var linkInput = document.getElementById("link-content");

    // Add event listener to the select dropdown
    document.getElementById("post-select").addEventListener("change", function() {
        // Hide all input elements initially
        textInput.style.display = "none";
        imageInput.style.display = "none";
        linkInput.style.display = "none";

        // Show the input element based on the selected option
        var selectedOption = this.value;
        if (selectedOption === "text") {
            textInput.style.display = "block";
        } else if (selectedOption === "image") {
            imageInput.style.display = "block";
        } else if (selectedOption === "iframe") {
            linkInput.style.display = "block";
        }
    });
</script>