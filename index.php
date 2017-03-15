<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="CSS/ORE_Style.css">
    <script src="JavaScript/ORE_Functions2.js"></script>
    <title>Home Page</title>
</head>
<body>
<header id="header" class="banner">
    <script>fillHeader("index.php", "ORE_Images/Icons/home_icon.png");</script>
</header>

<div id="content">
    <div id="leftPanel" class="sideBanner">
        <script>getHouseImages("ORE_Images/Houses/", "leftPanel", 1, 6);</script>
    </div>

    <div id="mainPanel">
        <div id="details">
            <h1>Welcome to Davis Online Real Estate!</h1>
            <a href='PHP/LoginPage.php' class="divButton">
                <h3>Click here to login</h3>
            </a>

            <div id="indexDescription">
                <p>
                    This site has been created to help owners sell their property and to help buyers find their perfect
                    home.
                </p><hr>

                <p>
                    If you are a new user you can create a new page buy clicking the "Register New User" button on the
                    upper right hand-side of the page. If not, please login by selecting the "Login" button.
                </p><hr>

                <h4>Tenants:</h4>
                <p>
                    Select "Edit Profile" to tell us a little bit about yourself. This information will be used in order
                    to find you a match with a suitable landlord.
                </p>
                <p>
                    Select "Edit Preferences" to tell us the criteria of the property that you are interested in. Only
                    properties with your selected preferences will be shown when you make your search.
                </p><hr>

                <h4>Owners: </h4>
                <p>
                    Select "Edit Profile" to tell us a little bit about yourself and to add listings for the properties
                    that you wish to sell.
                </p>
                <p>
                    Select "Edit Preferences" to limit your possible tenants to your specified criteria. Just select
                    qualities that you seek in a tenant and we will only show you tenants who fit your wishes.
                </p>
            </div>
        </div>
    </div>

    <div id="rightPanel" class="sideBanner">
        <script>getHouseImages("ORE_Images/Houses/", "rightPanel", 7, 12);</script>
    </div>
</div>

<footer id="footer" class="banner">
    <script>fillFooter()</script>
</footer>
</body>
</html>
