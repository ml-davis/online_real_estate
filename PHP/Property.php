<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="../CSS/ORE_Style.css"/>
    <script type="text/javascript" src="../JavaScript/ORE_Functions2.js"></script>
    <title>Add Property</title>
    <?php
        session_start();
        // warning, not same as function on userprofile. This does not select a default value
        function set_default_select($name, $stored_value) {
            if (!empty($stored_value)) {
                echo '<script>selectDefault("'.$name.'", "'.$stored_value.'")</script>';
            }
        }
        function get_numeric($val) { 
            if (is_numeric($val)) { 
                return $val + 0; 
            }
            return -1;    
        } 
    ?>
</head>
<body onload="buildTemplate()">

    <?php
        require 'Database.php';

        if (isset($_POST['submit'])) {
            require 'Validator.php';

//            if (strcmp($_GET['id'], '') !== 0) {
//                $property_id = $_GET['id'];
//            } else {
//                $property_id = 0;
//            }

            $property_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
            $user_id = $_SESSION['user_id'];
            $address = secure($_POST['address']);
            $apartment_number = secure($_POST['apartment_number']);
            $city = secure($_POST['city']);
            $cost = secure($_POST['cost']);
            if (get_numeric($cost) < 0) {
                $error_msg = 'Cost must be a valid number.';
            }
            $num_bedrooms = $_POST['num_bedrooms'];
            $num_bathrooms = $_POST['num_bathrooms'];
            $sq_ft = secure($_POST['sq_ft']);
            if (get_numeric($sq_ft) < 0) {
                $error_msg = 'Square feet must be a valid number';
            }
            $has_balcony = $_POST['has_balcony'];
            $has_dishwasher = $_POST['has_dishwasher'];
            $is_furnished = $_POST['is_furnished'];
            $allows_pets = $_POST['allows_pets'];
            $allows_smoking = $_POST['allows_smoking'];
            $extra_info = secure($_POST['extra_info']);

            if (!isset($error_msg)) {
                $query = "REPLACE INTO properties VALUES(
                    $property_id, $user_id, '$address', '$apartment_number', '$city', '$cost',
                    '$num_bedrooms', '$num_bathrooms', '$sq_ft', '$has_balcony', '$has_dishwasher',
                    '$is_furnished', '$allows_pets', '$allows_smoking', '$extra_info'
                )";
                $result = mysqli_query($con, $query) or die('Unable to update property. ' . mysqli_error($con));
                header('Location: EditProperties.php');
            }
        }
        if (isset($_GET['id'])) {
            $query = "SELECT address,apartment_number,city,cost,num_bedrooms,num_bathrooms,
                sq_ft,has_balcony,has_dishwasher,is_furnished,allows_pets,allows_smoking,
                extra_info 
                FROM properties WHERE property_id=".$_GET['id'];
            $result = mysqli_query($con, $query); //or die('Unable to execute query 1');
            if ($result) {
                $options = mysqli_fetch_assoc($result);
            }
        }
        mysqli_close($con);
    ?>

    <header id="header" class="banner"> </header>

    <div id="content">
        <div id="leftPanel" class="sideBanner"> </div>
        <div id="mainPanel">
            <nav id="navPanel"><script>buildNavPanel()</script></nav>
            <?php
                $url = $_SERVER['PHP_SELF'];
                //if (!isset($_GET['id'])) { $url .= '?id=0'; }
                //echo $url;
            ?>
            <form id="profileForm" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                <?php if (isset($error_msg)) { echo '<h3 id="errorMessage">' . $error_msg . '</h3>'; } ?>

                <div id="profilePictureContainer" style="padding-left:30px; padding-top:30px">
                    <img width="310px" height="205px" src="../ORE_Images/Houses/default_home.png" 
                        alt="profile picture"><br/>
                    <label for="submit_profile_pic"></label>
                    <input type="file" name="submit_profile_pic" accept="image/*"/>
                </div><br/>

                <div id="profileRight">
                    <h4>Please add the details of your property</h4>

                    <label for="address">Address: </label>
                    <input type="text" name="address" id="address" style="width:300px"
                        value="<?php if (isset($options)) echo $options['address'] ?>"/><br/><br/>

                    <label for="apartment_number">Apartment Number: </label>
                    <input type="text" name="apartment_number" id="apartment_number" class="sixDigits"
                        maxlength="6" value="<?php if (isset($options['apartment_number'])) echo $options['apartment_number'] ?>"/><br/><br/>

                    <label for="city">City: </label>
                    <input id="city" name="city" type="text"
                        value="<?php if (isset($options['city'])) echo $options['city'] ?>"/><br/><br/>

                    <label for="cost">Cost per month: </label>
                    <input type="text" name="cost" id="cost" class="sixDigits" maxlength="6"
                        value="<?php if (isset($options['cost'])) echo $options['cost'] ?>"/><br/><br/>

                    <label for="num_bedrooms">Number of bedrooms: </label>
                    <select id="num_bedrooms" name="num_bedrooms">
                        <option disabled selected> Select Option </option>
                        <option value="Studio">Studio</option>
                        <script>populateSelect(1, 8, 1)</script>
                        <?php set_default_select('num_bedrooms', $options['num_bedrooms']); ?>
                    </select><br/><br/>

                    <label for="num_bathrooms">Number of bathrooms: </label>
                    <select id="num_bathrooms" name="num_bathrooms">
                        <option disabled selected> Select Option </option>
                        <script>populateSelect(1, 8, 1)</script>
                        <?php if (isset($options['num_bathrooms'])) set_default_select('num_bathrooms', $options['num_bathrooms']); ?>
                    </select><br/><br/>

                    <label for="sq_ft">Amount of square feet: </label>
                    <input type="text" name="sq_ft" id="sq_ft" class="sixDigits" maxlength="6"
                        value="<?php if (isset($options['sq_ft'])) echo $options['sq_ft'] ?>"/><br/><br/>

                    <label for="has_balcony">Property has balcony: </label>
                    <select id="has_balcony" name="has_balcony">
                        <option disabled selected> Select Option </option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <?php set_default_select('has_balcony', $options['has_balcony']); ?>
                    </select><br/><br/>

                    <label for="has_dishwasher">Property has dishwasher: </label>
                    <select id="has_dishwasher" name="has_dishwasher">
                        <option disabled selected> Select Option </option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <?php set_default_select('has_dishwasher', $options['has_dishwasher']); ?>
                    </select><br/><br/>

                    <label for="is_furnished">Property is furnished: </label>
                    <select id="is_furnished" name="is_furnished">
                        <option disabled selected> Select Option </option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <?php set_default_select('is_furnished', $options['is_furnished']); ?>
                    </select><br/><br/>

                    <label for="allows_pets">Property allows pets: </label>
                    <select id="allows_pets" name="allows_pets">
                        <option disabled selected> Select Option </option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <?php set_default_select('allows_pets', $options['allows_pets']); ?>
                    </select><br/><br/>

                    <label for="allows_smoking">Property allows smoking: </label>
                    <select id="allows_smoking" name="allows_smoking">
                        <option disabled selected> Select Option </option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <?php set_default_select('allows_smoking', $options['allows_smoking']); ?>
                    </select><br/><br/>
                </div>

                <div id="profileAboutMe">
                    <label for="extra_info">Feel free to add additional info if you want.</label>
                    <textarea id="extra_info" name="extra_info" cols="50" rows="15"
                      placeholder="this is for you to provide any additional information to a potential tenant."
                    ><?php if (isset($options['extra_info'])) echo $options['extra_info'] ?></textarea>
                </div>
                
                <input type="submit" name="submit" id="submit" class="bigButton" value="Save Property"/>
            </form>
        </div>
        <div id="rightPanel" class="sideBanner"> </div>
    </div>

    <footer id="footer" class="banner"> </footer>
</body>
</html>
