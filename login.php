<?php
define('Emember',true);
include('includes/dbconnect.php');

if (!empty($_SESSION['email'])) {
  header("Location: index.php");
}

$error_message = "";

 if (isset($_POST['submit_login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if(password_verify($password, $row['password'])){
            sleep(2);
            $_SESSION['user_id']   = $row['user_id'];
            $_SESSION['email']     = $email;
            $_SESSION['name']      = $row['name'];
            $_SESSION['type']      = $row['type'];
            
            header("Location: index.php");
        }
        else {
            $error_message = "Error: Incorrect password";
        }
    } else {
        $error_message = "Error: Email Not Found";
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
<body style="background-color: #F8F8F7;">
<div class="container">
    <div class="row">
    <div class="col-md-6 offset-md-3">

    <br> <br>
        <?php if (!empty($error_message)): ?>
            <!-- <div class="alert alert-danger text-center"><?php echo $error_message; ?></div> -->
        <?php endif; ?>
    <form method="post" class="form">
        <div class="flex-column">
            <label>Email? </label>
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
        
        <button type="submit" name="submit_login" class="button-submit">Sign In</button>

        <p class="p">Don't have an account? <span class="span"><a href="signin.php">Sign Up</a></span>
    </form>
    </div>
  </div>
</div>

</body>
</html>