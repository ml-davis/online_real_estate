<?php

    define('DB_HOST', 'localhost');
    define('DB_USER', 'Matthew');
    define('DB_PASSWORD', 'iWbtBpo@t1');
    define('DB_NAME', 'onlinerealestate');

    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Unable to connect to database<br/><br/>' . mysqli_error($con));
