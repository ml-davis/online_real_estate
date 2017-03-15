<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="../CSS/ORE_Style.css">
    <script type="text/javascript" src="../JavaScript/ORE_Functions2.js"></script>
    <title>Matches</title>
    <?php
        session_start();
        if(!isset($_SESSION['user_id'])) { 
            header('Location: LoginPage.php?msg=3');
        }
    ?>
</head>
<body onload="buildTemplate()">
    <header id="header" class="banner"> </header>
    <div id="content">
        <div id="leftPanel" class="sideBanner"> </div>
        <div id="mainPanel">
            <nav id="navPanel"><script>buildNavPanel()</script></nav>
            <?php
                require 'Database.php';

                $query = "SELECT address
                    FROM user_prefs, properties
                    WHERE user_prefs.user_id=".$_SESSION['user_id']."
                    AND properties.city=user_prefs.city
                    AND properties.cost>=user_prefs.min_cost
                    AND (properties.cost<=user_prefs.max_cost OR user_prefs.max_cost='5000+')
                    AND (properties.num_bedrooms=user_prefs.num_bedrooms OR user_prefs.num_bedrooms='Any')
                    AND (properties.num_bathrooms=user_prefs.num_bathrooms OR user_prefs.num_bathrooms='Any')
                    AND properties.sq_ft>=user_prefs.min_sq_ft
                    AND (properties.sq_ft<=user_prefs.max_sq_ft OR user_prefs.max_sq_ft='5000+')
                    AND (properties.has_balcony=user_prefs.has_balcony OR user_prefs.has_balcony='Any')
                    AND (properties.is_furnished=user_prefs.is_furnished OR user_prefs.is_furnished='Any')
                    AND (properties.allows_pets=user_prefs.allows_pets OR user_prefs.allows_pets='Any')
                    AND (properties.allows_smoking=user_prefs.allows_smoking OR user_prefs.allows_smoking='Any')";
                $result = mysqli_query($con, $query) or die('Unable to access matches');

                while ($properties = mysqli_fetch_assoc($result)) {
                    echo '<div class="strip"><h3>' . $properties['address'] . '</h3></div>';
                }
            ?>
        </div>
        <div id="rightPanel" class="sideBanner"> </div>
    </div>
    <footer id="footer" class="banner"> </footer>
</body>
</html>
