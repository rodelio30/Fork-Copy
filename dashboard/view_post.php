<?php
define('Emember',true);
include('../includes/dbconnect.php');

if (empty($_SESSION['user_id'])) {
  header("Location: ../signin.php");
}

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
     $description = $row['description'];
     $fullname    = $row['fullname'];
     $post_type   = $row['post_type'];
     $content     = $row['content'];

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

if (isset($_POST['submit_comment'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];
    $comment_text = $_POST['comment_text'];

    // Insert comment into database
    $sql = "INSERT INTO comments (post_id, user_id, comment_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $post_id, $user_id, $comment_text);
    
    if ($stmt->execute()) {
        // Comment added successfully
        header("Location: view_post.php?PID=$post_id");
        exit;
    } else {
        // Handle error
        echo "Error: " . $conn->error;
    }

    // Close database connection
    $conn->close();
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

    <br> 
    <a href="edit_post.php?PID=<?= $post_id ?>" class="btn btn-outline-warning" style="width: 20%;">EDIT</a>
    <br>

    <?php if($post_type == 'text'){ ?>
        <div class="card">
            <h4 class="text-center"><?= $content ?></h4>
            <div class="card-body">
                <h2 class="card-title">Title: <?= $title ?></h2>
                <p class="card-text">Description: <?= $description ?></p>
                <p class="card-text">Posted By: <?= $fullname ?></p>
                <?php
                if ($result_comments->num_rows > 0) {
                        echo '<h2>Comments</h2>';
                        // Output comments
                        while ($row_comment = $result_comments->fetch_assoc()) {
                            echo '<div> <hr>';
                            echo '<p><strong>' . $row_comment['commenter'] . '</strong> - ' . $row_comment['created_at'] . '</p>';
                            echo '<p>' . $row_comment['comment_text'] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No comments yet.</p>';
                    }
                ?>
            </div>
        </div>
    <?php } ?>

    <?php if($post_type == 'image'){ ?>
    <div class="card">
        <img src="img/post/<?= $content?>" class="card-img-top img-fluid">
        <div class="card-body">
                <h2 class="card-title">Title: <?= $title ?></h2>
                <p class="card-text">Description: <?= $description ?></p>
                <p class="card-text">Posted By:<?= $fullname ?></p>
                <?php
                if ($result_comments->num_rows > 0) {
                        echo '<h2>Comments</h2>';
                        // Output comments
                        while ($row_comment = $result_comments->fetch_assoc()) {
                            echo '<div> <hr>';
                            echo '<p><strong>' . $row_comment['commenter'] . '</strong> - ' . $row_comment['created_at'] . '</p>';
                            echo '<p>' . $row_comment['comment_text'] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No comments yet.</p>';
                    }
                ?>
        </div>
    </div>

    <?php } ?>

    <?php if($post_type == 'iframe'){ ?>
        <div class="card">
            <div class="iframe-container">
                <?= $content ?>
            </div>
            <div class="card-body">
                <h2 class="card-title">Title: <?= $title ?></h2>
                <p class="card-text">Description: <?= $description ?></p>
                <p class="card-text">Posted By: <?= $fullname ?></p>
                <?php
                if ($result_comments->num_rows > 0) {
                        echo '<h2>Comments</h2>';
                        // Output comments
                        while ($row_comment = $result_comments->fetch_assoc()) {
                            echo '<div> <hr>';
                            echo '<p><strong>' . $row_comment['commenter'] . '</strong> - ' . $row_comment['created_at'] . '</p>';
                            echo '<p>' . $row_comment['comment_text'] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No comments yet.</p>';
                    }
                ?>
            </div>
        </div>
    <?php } ?>

    <div class="card">
        <div class="card-body">
                <form method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                    <textarea name="comment_text"  class="form-control"placeholder="Enter your comment"></textarea>
                    <button type="submit" class="btn btn-outline-primary float-end" name="submit_comment" style="width: 10%;">Submit</button>
                </form>
        </div>
    </div>

<br> <br> <br>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>