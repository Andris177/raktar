<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "raktar";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$csvFile = "adatok.csv";

$file = fopen($csvFile, "r");
if ($file !== false) {
    $header = fgetcsv($file, 1000, ";");
    while (($data = fgetcsv($file, 1000, ";")) !== false) {
        $sql = "INSERT INTO products (id, id_store, id_row, id_column, id_shelf, name, price, quantity, min_quantity)
                VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]')";
        if ($conn->query($sql) === TRUE) {
            echo "Az adatok sikeresen feltöltve az adatbázisba!";
        } else {
            echo "Hiba történt az adatok feltöltése közben: " . $conn->error;
        }

        $sql = "INSERT INTO columns (id, name)
                VALUES ('$data[3]', 'valami')";
        if ($conn->query($sql) === TRUE) {
            echo "Az adatok sikeresen feltöltve az adatbázisba!";
        } else {
            echo "Hiba történt az adatok feltöltése közben: " . $conn->error;
        }
        $sql = "INSERT INTO `rows` (id, name)
        VALUES ('$data[2]', 'valami')";
        if ($conn->query($sql) === TRUE) {
            echo "Az adatok sikeresen feltöltve az adatbázisba!";
        } else {
            echo "Hiba történt az adatok feltöltése közben: " . $conn->error;
        }
        $sql = "INSERT INTO shelves (id, name)
        VALUES ('$data[4]', 'valami')";


        if ($conn->query($sql) === TRUE) {
            echo "Az adatok sikeresen feltöltve az adatbázisba!";
        } else {
            echo "Hiba történt az adatok feltöltése közben: " . $conn->error;
        }
    }
    fclose($file);
} else {
    echo "Hiba történt a CSV fájl megnyitásakor.";
}

$conn->close();