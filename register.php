<?php
    @include_once 'config.php';

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = md5($_POST['password']);
        $cpass = md5($_POST['cpassword']);
        $user_type = $_POST['user_type'];

        $select = "SELECT * FROM user_form WHERE email = '$email' AND password = '$pass' ";

        $result = mysqli_query($conn, $select) or die(mysqli_error($conn));

        if (mysqli_num_rows($result) > 0) {
            $error[] = 'User already exists';
        } else {
            if ($pass !== $cpass) {
                $error[] = 'Password not match';
            } else {
                $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES ('$name', '$email', '$pass', '$user_type')";
                mysqli_query($conn, $insert) or die(mysqli_query($conn, $insert));
                header("Location:login.php");
            }
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="form-container">
        <form action="" method="POST">
            <h3>Register Now</h3>
            <?php
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<span class="error-msg">'.$error.'</span>';
                    }
                }
    ?>
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <input type="password" name="cpassword" placeholder="Enter your cpassword" required>
            <select name="user_type">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" name="submit" value="Register Now" class="form-btn">
            <p>Already have an account? <a href="login.php">Login Now</a></p>
        </form>
    </div>
</body>

</html>