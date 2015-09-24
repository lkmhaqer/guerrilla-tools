<?php

include('php/phpqrcode/qrlib.php');

QRcode::png('otpauth://totp/guerrillaTools?username=Bob&secret=' . $_GET['key']);

?>
