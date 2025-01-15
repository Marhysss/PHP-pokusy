<?php
$connection = mysqli_connect("localhost", "root", "", "loginapp");

if (!$connection) {
    die("Připojení k databázi selhalo: " . mysqli_connect_error());
} else {
    echo "Připojení k databázi bylo úspěšné!";
}
?>
