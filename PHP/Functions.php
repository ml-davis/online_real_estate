<?php
    function camelToText($var) {
        $response = preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', $var);
        $response = strToLower($response);
        $response = preg_replace('/^[i] /', 'I ', $response);

        return $response;
    }

    function startsWithVowel($var) {
        return preg_match('/^[aeiou]/', $var);
    }
