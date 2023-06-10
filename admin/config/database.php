<?php
require 'config/constrants.php';

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($conn)
    echo "Database Connected";
else{
    echo "something wrong!!!";
}
?>