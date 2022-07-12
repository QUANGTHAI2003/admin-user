<?php
    @include_once 'config.php';

    session_start();

    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = md5($_POST['password']);

        $select = "SELECT * FROM user_form WHERE email = '$email' AND password = '$pass' ";

        $result = mysqli_query($conn, $select) or die(mysqli_error($conn));

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                header("Location:admin_page.php");
            } elseif ($row['user_type'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                header("Location:user_page.php");
            }
        } else {
            $error[] = 'Incorrect email or password';
        }
    }

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="form-container">
        <form action="" method="POST">
            <h3>Login Now</h3>
            <?php
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<span class="error-msg">'.$error.'</span>';
                    }
                }
    ?>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <input type="submit" name="submit" value="Login Now" class="form-btn">
            <p>Don't have an account? <a href="register.php">Register Now</a></p>
        </form>
    </div>
</body>

</html>