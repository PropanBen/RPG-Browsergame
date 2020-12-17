<?php

$test = "Passwort&$";

if (preg_match("^(?=(.*\d){1})(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}^", $test)) {
    echo "trifft zu";
} else {
    echo "trifft nicht zu";
};
