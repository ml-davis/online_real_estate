<?php

    define('MAX_NAME_SIZE', 45);
    define('MAX_EMAIL_SIZE', 60);
    define('MIN_PASSWORD_SIZE', 6);
    define('MAX_PASSWORD_SIZE', 20);

    function secure($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function valid_name($name) {
        return strlen($name) > 0 && strlen($name) < MAX_NAME_SIZE; // 0 < name < max_name_size
    }

    function valid_phone($number) {
        return preg_match('/\(\d{3}\)\d{3}\-\d{4}/', $number); // (123)456-7890
    }

    function valid_email($email) {
        return strlen($email) < MAX_EMAIL_SIZE && filter_var($email, FILTER_VALIDATE_EMAIL); // john_doe@gmail.com
    }

    function validate_password($password) {
        return strlen($password) > MIN_PASSWORD_SIZE && strlen($password) < MAX_PASSWORD_SIZE;
    }

    function validate_user_type($type) {
        return strcmp($type, 'Tenant') == 0 || strcmp($type, 'Owner') == 0;
    }

