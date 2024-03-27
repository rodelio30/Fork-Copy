<?php
define('Emember',true);
include('includes/dbconnect.php');

if (!empty($_SESSION['email'])) {
  header("Location: index.php");
}

 $error_message = "";

    if (isset($_POST['submit-register'])) {
        $name             = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
        $email            = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password         = $_POST['password'];
        $employee_id      = $_POST['employee_id'];

        $date_of_birth    = $_POST['dob'];

            $check_email_sql = "SELECT * FROM users WHERE email='$email'";
            $check_email_result = $conn->query($check_email_sql);
            if ($check_email_result->num_rows > 0) {
                $error_message = "Error: Email already exists";
            } else {
                    $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                    $date_of_records = date("Y-m-d");

                    $sql = "INSERT INTO users (fullname, email, password, employee_id, date_of_birth, date_of_record_update) VALUES ('$name', '$email', '$hash_pass', '$employee_id', '$date_of_birth', '$date_of_records')";
                    
                    if ($conn->query($sql) === TRUE) {
                        // Registration successful
                        sleep(2);
                        header('location: signin.php');
                        die();
                    } else {
                        $error_message = "Error: " . $sql . "<br>" . $conn->error;
                }
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
    <form action="" method="post" class="form">
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="flex-column">
        <label>Full Name</label></div>
        <div class="inputForm">
            <input type="text" class="input" name="fullname" placeholder="Enter your FullName">
        </div>

        <div class="flex-column">
        <label>Email</label></div>
        <div class="inputForm">
            <input type="email" class="input" name="email" placeholder="Enter your Email">
        </div>

        <div class="flex-column">
        <label>Password </label></div>
        <div class="inputForm">
            <input type="password" class="input" name="password" placeholder="Enter your Password">
        </div>

        <div class="flex-column">
        <label>Employer ID</label></div>
        <div class="inputForm">
            <input type="number" class="input" name="employee_id" placeholder="Enter your Employee ID">
        </div>
        
        <div class="flex-column">
        <label>Date of Birth</label></div>
        <div class="inputForm">
            <input type="date" class="input" name="dob">
        </div>
        
        <button type="submit" name="submit-register" class="button-submit">Register</button>

        <p class="p">Already have an account? <span class="span"><a href="signin.php">Sign in now</a></span>

            
    </button></div></form>
    </div>
  </div>
</div>

<!-- Bootstrap JS and dependencies (not required for layout) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
</body>
</html>
