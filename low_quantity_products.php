<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "raktar";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products WHERE quantity < 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>10 alatti mennyiségű termékek</h2><ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li class='product-info'>
                <div>
                    <strong>Név:</strong> " . $row["name"] . "<br>
                    <strong>ID:</strong> " . $row["id"] . "<br>
                    <strong>Ár:</strong> " . $row["price"] . "<br>
                    <strong>Mennyiség:</strong> " . $row["quantity"] . "<br>
                    <strong>Minimum mennyiség:</strong> " . $row["min_quantity"] . "<br>
                    <strong>Raktár azonosító:</strong> " . $row["id_store"] . "<br>
                    <strong>Sor:</strong> " . $row["id_row"] . "<br>
                    <strong>Oszlop:</strong> " . $row["id_column"] . "<br>
                    <strong>Polc:</strong> " . $row["id_shelf"] . "
                </div>
              </li>";
    }
    echo "</ul>";
} else {
    echo "Kifogyóban lévő termékek.";
}
$conn->close();
?>