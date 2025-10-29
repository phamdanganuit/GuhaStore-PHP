<?php
    $mysqli = new mysqli("localhost","guha","030204","dbperfume_new");
    // Check connection
    if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
