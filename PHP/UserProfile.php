<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="../CSS/ORE_Style.css"/>
    <script type="text/javascript" src="../JavaScript/ORE_Functions2.js"></script>
    <title>Profile</title>
    <?php
        session_start();
        // if user is not logged in, return him to login page with expiration message
        if(!isset($_SESSION['user_id'])) { 
            header('Location: LoginPage.php?msg=3');
        }
        function set_default_select($name, $stored_value, $default_value) {
            $write_value = (empty($stored_value)) ? $default_value : $stored_value;
            echo '<script>selectDefault("'.$name.'", "'.$write_value.'")</script>';
        }
    ?>
</head>
<body onload="buildTemplate()">

    <?php
        require 'Database.php';

        if (isset($_POST['submit'])) {
            require 'Validator.php';

            $city = secure($_POST['city']);
            $min_cost = $_POST['min_cost'];
            $max_cost = $_POST['max_cost'];
            $num_bedrooms = $_POST['num_bedrooms'];
            $num_bathrooms = $_POST['num_bathrooms'];
            $min_sq_ft = $_POST['min_sq_ft'];
            $max_sq_ft = $_POST['max_sq_ft'];
            $has_balcony = $_POST['has_balcony'];
            $has_dishwasher = $_POST['has_dishwasher'];
            $is_furnished = $_POST['is_furnished'];
            $allows_pets = $_POST['allows_pets'];
            $allows_smoking = $_POST['allows_smoking'];
            $extra_info = $_POST['extra_info'];

            $query = "UPDATE user_prefs
                SET city='$city',
                    min_cost='$min_cost',
                    max_cost='$max_cost',
                    num_bedrooms='$num_bedrooms',
                    num_bathrooms='$num_bathrooms',
                    min_sq_ft='$min_sq_ft',
                    max_sq_ft='$max_sq_ft',
                    has_balcony='$has_balcony',
                    has_dishwasher='$has_dishwasher',
                    is_furnished='$is_furnished',
                    allows_pets='$allows_pets',
                    allows_smoking='$allows_smoking',
                    extra_info='$extra_info'
                WHERE user_id='".$_SESSION['user_id']."'";
            $result = mysqli_query($con, $query) or die("Unable to execute query 0");
        }

        $query = 'SELECT * FROM user_prefs WHERE user_id='.$_SESSION['user_id'];
        $result = mysqli_query($con, $query) or die('Unable to execute query 1');
        $prefs = mysqli_fetch_assoc($result);

        mysqli_close($con);
    ?>

    <header id="header" class="banner"> </header>

    <div id="content">
        <div id="leftPanel" class="sideBanner"> </div>

        <div id="mainPanel">
            <nav id="navPanel"><script>buildNavPanel()</script></nav>

            <form id="profileForm" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">

                <?php
                    echo '<h2>'.stripslashes($_SESSION['first_name']).'
                        '.stripslashes($_SESSION['last_name']).'</h2>';
                ?>
                <div id="profilePictureContainer">
                    <img width="225px" height="225px" src="../ORE_Images/profilePic.png" 
                        alt="profile picture"><br/>
                    <label for="submit_profile_pic"></label>
                    <input type="file" id="submit_profile_pic" name="submit_profile_pic" accept="image/*"/>
                </div>

                <div id="profileRight">
                    <h4>Feel free to select desired criteria to filter your results</h4>

                    <label for="city">City: </label>
                    <input id="city" name="city" type="text"
                        value="<?php echo $prefs['city'] ?>"/><br/><br/>

                    <label for="min_cost">Cost per month, from: </label>
                    <select id="min_cost" name="min_cost">
                        <script>populateSelect(100, 4000, 100)</script>
                        <?php set_default_select('min_cost', $prefs['min_cost'], '100'); ?>
                    </select>
                    <label for="max_cost"> to: </label>
                    <select id="max_cost" name="max_cost">
                        <script>populateSelect(200, 4900, 100)</script>
                        <option value="5000+">5000+</option>
                        <?php set_default_select('max_cost', $prefs['max_cost'], '5000+'); ?>
                    </select><br/><br/>

                    <label for="num_bedrooms">Number of bedrooms: </label>
                    <select id="num_bedrooms" name="num_bedrooms">
                        <option value="Any">Any</option>
                        <script>populateSelect(1, 8, 1)</script>
                        <?php set_default_select('num_bedrooms', $prefs['num_bedrooms'], 'Any'); ?>
                    </select><br/><br/>

                    <label for="num_bathrooms">Number of bathrooms: </label>
                    <select id="num_bathrooms" name="num_bathrooms">
                        <option value="Any">Any</option>
                        <script>populateSelect(1, 8, 1)</script>
                        <?php set_default_select('num_bathrooms', $prefs['num_bathrooms'], 'Any'); ?>
                    </select><br/><br/>

                    <label for="min_sq_ft">Amount of square feet, from: </label>
                    <select id="min_sq_ft" name="min_sq_ft">
                        <script>populateSelect(100, 5000, 100)</script>
                        <?php set_default_select('min_sq_ft', $prefs['min_sq_ft'], 'Any'); ?>
                    </select>
                    <label for="max_sq_ft"> to: </label>
                    <select id="max_sq_ft" name="max_sq_ft">
                        <script>populateSelect(300, 4900, 100)</script>
                        <option value="5000+">5000+</option>
                        <?php set_default_select('max_sq_ft', $prefs['max_sq_ft'], 'Any'); ?>
                    </select><br/><br/>

                    <label for="has_balcony">Apartment has balcony: </label>
                    <select id="has_balcony" name="has_balcony">
                        <script>selectYesOrNo()</script>
                        <?php set_default_select('has_balcony', $prefs['has_balcony'], 'Any'); ?>
                    </select><br/><br/>

                    <label for="has_dishwasher">Apartment has dishwasher: </label>
                    <select id="has_dishwasher" name="has_dishwasher">
                        <script>selectYesOrNo()</script>
                        <?php set_default_select('has_dishwasher', $prefs['has_dishwasher'], 'Any'); ?>
                    </select><br/><br/>

                    <label for="is_furnished">Apartment is furnished: </label>
                    <select id="is_furnished" name="is_furnished">
                        <script>selectYesOrNo()</script>
                        <?php set_default_select('is_furnished', $prefs['is_furnished'], 'Any'); ?>
                    </select><br/><br/>

                    <label for="allows_pets">Apartment allows pets: </label>
                    <select id="allows_pets" name="allows_pets">
                        <script>selectYesOrNo()</script>
                        <?php set_default_select('allows_pets', $prefs['allows_pets'], 'Any'); ?>
                    </select><br/><br/>

                    <label for="allows_smoking">Apartment allows smoking: </label>
                    <select id="allows_smoking" name="allows_smoking">
                        <script>selectYesOrNo()</script>
                        <?php set_default_select('allows_smoking', $prefs['allows_smoking'], 'Any'); ?>
                    </select><br/><br/>
                </div>

                <div id="profileAboutMe">
                    <label for="extra_info">Feel free to add additional info if you want.</label>
                    <textarea id="extra_info" name="extra_info" cols="50" rows="15"
                      placeholder="This is for you to provide any additional information to your potential landlord."
                    ><?php echo $prefs['extra_info'] ?></textarea>
                </div>
                <input id="submit" class="bigButton" type="submit" name="submit" value="Update Preferences"/>
            </form>
        </div>

        <div id="rightPanel" class="sideBanner"> </div>
    </div>

    <footer id="footer" class="banner">  </footer>
</body>
</html>
