<?php
define('Emember',true);
include('../includes/dbconnect.php');

if (empty($_SESSION['user_id'])) {
  header("Location: ../signin.php");
}

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

<br> 
<a href="add_post.php" class="btn btn-outline-success" style="width: 20%;">Add New Blog</a>
<br> 
  <h1>Hello World</h1>


  <div class="row row-cols-2">
  <?php
    $sql = "SELECT 
            b.post_id,
            b.title,
            b.description,
            b.post_type,
            b.content,
            b.update_date,
            u.fullname,
            COUNT(c.comment_id) AS comment_count
        FROM 
            blogpost AS b
        JOIN
            users AS u ON b.user_id = u.user_id
        LEFT JOIN
            comments AS c ON b.post_id = c.post_id
        GROUP BY
            b.post_id
        ORDER BY
            b.post_id DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
          $timestamp = strtotime($row['update_date']);
          $formattedDate = date("F j, Y", $timestamp);
          
          switch ($row['post_type']) {
            case 'text':
              echo '<div class="col-12 col-lg-6 col-md-12 col-sm-12">';
                echo '<div class="card mb-3">';
                  echo '<div class="card-body">';
                  echo '<h5 class="card-title">' . $row['title'] . '</h5>';
                  echo '<p class="card-text">' . $row['description'] . '</p>';
                  echo '<p class="card-text">' . $row['content'] . '</p>';
                  echo '<p class="card-text">Posted By: ' . $row['fullname'] . '</p>';
                  echo '<p class="card-text">Date Posted: ' . $formattedDate . '</p>';
                  echo '<p>Comment count: ' . $row['comment_count'] . '</p>';
                  echo '<a href="view_post.php?PID='.$row['post_id'].'" class="btn btn-outline-primary" style="width: 25%;">View</a>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';
                break;
                
            case 'image':
              echo '<div class="col-12 col-lg-6 col-md-12 col-sm-12">';
              echo '<div class="card mb-3">';
                echo '<div class="card-body">';
                echo '<img src="img/post/' . $row['content'] . '" alt="' . $row['title'] . '" class="img-fluid">';
                echo '<h5 class="card-title">' . $row['title'] . '</h5>';
                echo '<p class="card-text">' . $row['description'] . '</p>';
                echo '<p class="card-text">Posted By: ' . $row['fullname'] . '</p>';
                  echo '<p class="card-text">Date Posted: ' . $formattedDate . '</p>';
                  echo '<p>Comment count: ' . $row['comment_count'] . '</p>';
                  echo '<a href="view_post.php?PID='.$row['post_id'].'" class="btn btn-outline-primary" style="width: 25%;">View</a>';
                echo '</div>';
              echo '</div>';
              echo '</div>';
                break;
                
            case 'iframe':
              echo '<div class="col-12 col-lg-6 col-md-12 col-sm-12">';
              echo '<div class="card mb-3">';
                echo '<div class="card-body">';
                echo '<div class="iframe-container">';
                echo '' . $row['content'] . '';
                echo '</div>';
                echo '<h5 class="card-title">' . $row['title'] . '</h5>';
                echo '<p class="card-text">' . $row['description'] . '</p>';
                echo '<p class="card-text">Posted By: ' . $row['fullname'] . '</p>';
                  echo '<p class="card-text">Date Posted: ' . $formattedDate . '</p>';
                  echo '<p>Comment count: ' . $row['comment_count'] . '</p>';
                  echo '<a href="view_post.php?PID='.$row['post_id'].'" class="btn btn-outline-primary" style="width: 25%;">View</a>';
                echo '</div>';
              echo '</div>';
              echo '</div>';
                break;
                
            default:
                // Handle unsupported post type
                break;
        }
        
    }
    echo '</div>';
    } else {
        echo "No cards found.";
    }
  
  ?>

</div>
  
<br> <br> <br>
  
  
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
