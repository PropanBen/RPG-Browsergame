<?php

$token = openssl_random_pseudo_bytes(16);


echo $token;
//Convert the binary data into hexadecimal representation.
$token = bin2hex($token);

//Print it out for example purposes.
echo $token;
