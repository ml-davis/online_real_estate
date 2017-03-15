<!DOCTYPE html>
<head lang="en">
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="../CSS/ORE_Style.css">
    <script type="text/javascript" src="../JavaScript/ORE_Functions2.js"></script>
    <title>Registration</title>
</head>
<body onload="buildTemplate()">

    <?php
        $valid_form = true;
        $fail_message = '';

        if (isset($_POST['submit'])) {

            require 'Validator.php';

            $valid_form = true;

            // validate first name
            $first_name = $_POST['firstName'];
            if (!valid_name($first_name)) {
                $fail_message .= 'You must enter a valid first name under ' . MAX_NAME_SIZE . ' 
                    characters<br/>';
                $valid_form = false;
            }

            // validate last name
            $last_name = $_POST['lastName'];
            if (!valid_name($first_name)) {
                $fail_message .= 'You must enter a valid last name under ' . MAX_NAME_SIZE . ' 
                    characters<br/>';
                $valid_form = false;
            }

            // validate phone number
            $phone_number = '(' . $_POST['areaCode'] . ')' . $_POST['phonePrefix'] . '-' . 
                $_POST['phoneLineNumber'];
            if (!valid_phone($phone_number)) {
                $fail_message .= 'You must enter a valid phone number<br/>';
                $valid_form = false;
            }

            // validate email
            $email = $_POST['email'];
            if (!valid_email($email)) {
                $fail_message .= 'You must enter a valid email address<br/>';
                $valid_form = false;
            }

            // validate password
            $password = $_POST['password'];
            if (!validate_password($password)) {
                $fail_message .= 'Password must be between ' .  MIN_PASSWORD_SIZE . ' and ' . 
                    MAX_PASSWORD_SIZE .
                    ' characters<br/>';
                $valid_form = false;
            }

            // make sure passwords match
            $confirmation = $_POST['confirmation'];
            if (strcmp($password, $confirmation) != 0) {
                $fail_message .= 'Your passwords do not match<br/>';
                $valid_form = false;
            }

            if ($valid_form) {
                require 'Database.php';

                // check if email exists in database
                $query = "SELECT email FROM users WHERE email='$email'";
                $result = mysqli_query($con, $query) or die('Unable to execute query 0');

                if (mysqli_num_rows($result) > 0) { // if user is already in db
                    $fail_message .= 'A user with that email already exists in our records';
                    $valid_form = false;
                } else { // if email isn't in records, add user to db
                    // ucfirst(strtolower($bar))
                    $first_name = ucfirst(strtolower(secure($first_name)));
                    $first_name = mysqli_real_escape_string($con, $first_name);
                    $last_name = ucfirst(strtolower(secure($last_name)));
                    $last_name = mysqli_real_escape_string($con, $last_name);
                    $phone_number = secure($phone_number);
                    $email = strtolower(secure($email));
                    $password = mysqli_escape_string($con, $password);

                    $query = 'INSERT INTO users ' .
                        '(first_name, last_name, phone_number, email, password, reg_date) VALUES ' .
                        "('$first_name', '$last_name', '$phone_number', '$email', '$password', now())";
                    $result = mysqli_query($con, $query) 
                        or die('Unable to insert user into db <br/>' . $query);
                    
                    // retrieve new user's user_id
                    $query = "SELECT user_id FROM users WHERE email='$email' AND password='$password'";
                    $result = mysqli_query($con, $query) or die('Unable to execute query 4');
                    $arr = mysqli_fetch_assoc($result);

                    // set user's default search preferences
                    $query = "INSERT INTO user_prefs VALUES(".
                        $arr['user_id'].",".    // user_id
                        "'',".                  // city
                        "'100',".               // min_cost
                        "'5000+',".             // max_cost
                        "'Any',".               // num_bedrooms
                        "'Any',".               // num_bathrooms
                        "'100',".               // min_sq_ft
                        "'5000+',".             // max_sq_ft
                        "'Any',".               // has_balcony
                        "'Any',".               // has_dishwasher
                        "'Any',".               // is_furnished
                        "'Any',".               // allows_pets
                        "'Any',".               // allows_smoking
                        "''".                   // extra_info
                    ")";
                    $result = mysqli_query($con, $query) or die('Unable to execute query 2: '. $query);

                    // user added, now log him into his profile


                    mysqli_close($con);

                    session_start();
                    $_SESSION['user_id']    = $arr['user_id'];
                    $_SESSION['first_name'] = $first_name;
                    $_SESSION['last_name']  = $last_name;

                    header('Location: UserProfile.php');
                }
            }
        }
    ?>

<header id="header" class="banner"> </header>

<div id="content">
    <div id="leftPanel" class="sideBanner"> </div>

    <div id="mainPanel">
        <div id="details">
            <h1>Please enter your personal information.</h1>
            <hr>

            <form id="registrationForm" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                <label for="firstName">First Name: </label>
                <input type="text" id="firstName" name="firstName" class="registrationField" maxlength="45"
                    value="<?php if (isset($first_name)) echo $first_name ?>"/><br/><br/>

                <label for="lastName">Last Name: </label>
                <input type="text" id="lastName" name="lastName" maxlength="45"
                    value="<?php if (isset($last_name)) echo $last_name ?>"/><br/><br/>

                <label for="areaCode">Phone Number:</label>
                <input type="text" id="areaCode" name="areaCode" class="threeDigits" placeholder="XXX" 
                    maxlength="3" value="<?php if (isset($areaCode)) echo $_POST['areaCode'] ?>"/>
                <input type="text" id="phonePrefix" name="phonePrefix" class="threeDigits" placeHolder="XXX"
                       maxlength="3" value="<?php if (isset($phonePrefix)) echo $_POST['phonePrefix'] ?>"/>
                <input type="text" id="phoneLineNumber" name="phoneLineNumber" class="fourDigits" 
                        placeHolder="XXXX" maxlength="4" 
                        value="<?php if (isset($phoneLineNumber)) echo $_POST['phoneLineNumber'] ?>"/><br/><br/>

                <label for="email">Email: </label>
                <input type="text" id="email" name="email" class="registrationField" maxlength="60"
                    value="<?php if (isset($email)) echo $email ?>"/><br/><br/>

                <label for="password">Password: </label>
                <input type="password" id="password" name="password" class="registrationField" maxlength="20"
                    value="<?php if (isset($password)) echo $password ?>"/><br/><br/>

                <label for="confirmation">Confirm Password: </label>
                <input type="password" id="confirmation" name="confirmation" class="registrationField" 
                    maxlength="20"
                    value="<?php if (isset($confirmation)) echo $confirmation ?>"/><br/><br/><br/>

                <input type="submit" name="submit" value="Submit"/>
            </form>
            <div id="errorMessage">
                <?php
                    if (!$valid_form) {
                        echo "<h4>$fail_message<h4/>";
                    }
                ?>
            </div>
        </div>
    </div>

    <div id="rightPanel" class="sideBanner"> </div>
</div>

<footer id="footer" class="banner"> </footer>

</body>
</html>
