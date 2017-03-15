<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="../CSS/ORE_Style.css">
    <script type="text/javascript" src="../JavaScript/ORE_Functions2.js"></script>
    <title>Login Page</title>
    <?php
    if (isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        switch($msg) {
            case 3: echo '<script>alert("Session has expired. Please log-in")</script>'; break;
        }
    }
    ?>
</head>
<body onload="buildTemplate()">

    <?php
        if (isset($_POST['submit'])) {

            require 'Database.php';

            $email = $_POST['email'];
            $password = $_POST['password'];

            $query = "SELECT user_id, first_name, last_name " .
                     "FROM users " .
                     "WHERE email='$email' AND password='$password'";
            $result = mysqli_query($con, $query) or die("Unable to execute query : $query");
            if (mysqli_num_rows($result) == 0) {
                $error_msg = 'Invalid username or password';
                $invalid_input = true;
            } else {
                $user = mysqli_fetch_assoc($result);
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];

                header('Location: UserProfile.php');
            }
        }
    ?>

<header id="header" class="banner"> </header>
<div id="content">
    <div id="leftPanel" class="sideBanner"> </div>

    <div id="mainPanel">
        <div id="details">
            <h1>Welcome! Please login</h1>

            <div id="errorMessage">
                <?php if (isset($error_msg)) echo "<h4>$error_msg</h4>" ?>
            </div>

            <form id="loginForm" method="post" action="<?php echo 'LoginPage.php' ?>">
                <label for="email">Email: </label>
                <input type="text" id="email" name="email" value="<?php if (isset($email)) echo $email ?>"/><br/><br/>

                <label for="password">Password: </label>
                <input type="password" id="password" name="password" value="<?php if (isset($password)) echo $password ?>"/><br/><br/><br/>

                <input type="submit" name="submit"/>
            </form><br/><br/>

            <a href='RegistrationPage.php' class="divButton">
                <p>Are you a new user? If so, please click here to make a new account.</p>
            </a>
        </div>
    </div>

    <div id="rightPanel" class="sideBanner"> </div>
</div>

<footer id="footer" class="banner">  </footer>

</body>
</html>
