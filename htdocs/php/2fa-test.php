<?php

include('google2factor.php');

$InitalizationKey = "TQBADNVNFWZXD6VC";                                                 // Set the inital key

$TimeStamp        = Google2FA::get_timestamp();
$secretkey        = Google2FA::base32_decode($InitalizationKey);        // Decode it into binary
$otp              = Google2FA::oath_hotp($secretkey, $TimeStamp);       // Get current token

// Use this to verify a key as it allows for some time drift.

$randoKey = Google2FA::generate_secret_key();

echo("<img src=\"/qrpng.php?key=$randoKey\"><br>$randoKey<br>");

?>
