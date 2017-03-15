<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="../CSS/ORE_Style.css"/>
    <script type="text/javascript" src="../JavaScript/ORE_Functions2.js"></script>
    <title>Properties</title>
    <?php
        session_start();
        // if user is not logged in, return him to login page with expiration message
        if(!isset($_SESSION['user_id'])) { 
            header('Location: LoginPage.php?msg=3');
        }
        function createPropertyMessage($message) {
            echo '<div id="propertyMessage" class="strip">';
            echo '<h3>'.$message.'</h3>';
            echo '</div>';
        }
        function createDeleteButton($id) {
            echo '<a onclick="" class="divButton" id="deleteProperty" 
                href='.$_SERVER['PHP_SELF'].'?del='.$id.'>';
            echo '<img src="../ORE_Images/Icons/delete2.png" alt="delete">';
            echo '</a>';
        }
        if (isset($_GET['confirm'])) {
            require 'Database.php';
            $query = 'DELETE FROM properties WHERE property_id='.$_GET['del'];
            $result = mysqli_query($con, $query);
            header("Location: EditProperties.php");
        }
        else if (isset($_GET['del'])) {
            ?>
            <script>;
                var t = confirm("This will permanently delete your property. Are you sure?");
                if (t) {
                    var url = window.location.href;
                    url += '&confirm=true';
                    window.location.href = url;
                }
            </script>
            <?php
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
                $query = 'SELECT property_id, address FROM properties WHERE user_id='.$_SESSION['user_id'];
                $result = mysqli_query($con, $query) or die('Unable to execute query 0: '.$query);
                if (mysqli_num_rows($result) == 0) {
                    // user has no properties saved. Nothing to load. Give default message
                    createPropertyMessage('You currently have no properties saved. 
                        Click below to add a listing.');
                } else {
                    // user has properties saved. Load his property buttons
                    createPropertyMessage('Feel free to add or edit your listings.');
                    while($property = mysqli_fetch_assoc($result)) {
                        echo '<a href=Property.php?id='.$property['property_id'].' class="divButton" 
                            id="editPropertyButton" style="float:left">';
                        echo '<h3>'.$property['address'].'</h3>';
                        echo '</a>';
                        createDeleteButton($property['property_id']);
                    }
                }

                $query = "SELECT * FROM properties;";
                $result = mysqli_query($con, $query) or die ('Unable to access properties');
                $num_rows = mysqli_num_rows($result);

                echo '<a href="Property.php?id='.$num_rows.'" class="divButton" id="addPropertyButton">';
                echo '<h3>Click here to add a new property</h3>';
                echo '</a>';
            ?>
        </div>
        <div id="rightPanel" class="sideBanner"> </div>
    </div>

    <footer id="footer" class="banner">  </footer>
</body>
</html>
