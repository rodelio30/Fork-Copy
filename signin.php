<?php

define('Emember', true);
require('includes/dbconnect.php'); // Connect to the database

// Ensure that the user is not logged in

if (!empty($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["submit_admin"])) {
    // Retrieve the user input
    $email = $_POST['email'];
    $password = $_POST["password"];

    // Query the database for the user
    $query = "SELECT * FROM users WHERE email = ?"; // Use a prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email); // Bind the user input to the prepared statement as a string
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the user exists and the password is correct
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Set the session variables and redirect to the admin index
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["fullname"] = $row["fullname"];
            // header("Location: index.php");
            header("Location: dashboard/home.php");
            exit;
        } else {
            echo "<script> alert('Wrong Password'); </script>";
        }
    } else {
        echo "<script> alert('User Not Registered'); </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acme Inc.'s</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">

</head>
<body>
<div class="container">
    <div class="row">
    <div class="col-md-6 offset-md-3">

    <br> <br>
        <?php if (!empty($error_message)): ?>
            <!-- <div class="alert alert-danger text-center"><?php echo $error_message; ?></div> -->
        <?php endif; ?>
    <form method="post" class="form">
        <div class="flex-column">
            <label>Email </label>
        </div>
        <div class="inputForm">
            <input type="email" name="email" class="input" placeholder="Enter your Email">
        </div>
        
        <div class="flex-column">
            <label>Password </label>
        </div>
        <div class="inputForm">
            <input type="password" name="password" class="input" placeholder="Enter your Password">
        </div>
        
        <button type="submit" name="submit_admin" class="button-submit">Sign in</button>

        <p class="p">Don't have an account? <span class="span"><a href="register.php">Sign Up</a></span>
    </form>
    </div>
  </div>
</div>

</body>
</html>