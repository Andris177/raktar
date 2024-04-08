<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raktárkezelő</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <h1>Raktárkezelő</h1>

    <div id="output"></div>

    <button onclick="loadData()">Adatok betöltése</button>
    <button onclick="showAddProductForm()">Termék hozzáadása</button>
    <button onclick="listProducts()">Termékek listázása</button>

    <script>

    function loadData() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "load_data.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("output").innerHTML = xhr.responseText;
                // Ha az adatok sikeresen betöltődtek, megjelenítjük a többi gombot és űrlapot
                document.getElementById("addProductForm").style.display = "block";
                document.getElementById("listProductsForm").style.display = "block";
            }
        };
        xhr.send();
    }
    
    function showAddProductForm() {
        var formHtml = `
            <h2>Termék hozzáadása</h2>
            <form id="addProductForm">
                Sorszám: <input type="number" name="id" min="1"><br><br>
                Név: <input type="text" name="name" required><br><br>
                Ár: <input type="number" name="price" min="0" step="100"><br><br>
                Mennyiség: <input type="number" name="quantity" min="1"><br><br>
                Minimum mennyiség: <input type="number" name="min_quantity" min="1"><br><br>
                Raktár azonosító: <input type="number" name="id_store" min="1"><br><br>
                Sor azonosító: <input type="number" name="id_row" min="1"><br><br>
                Oszlop azonosító: <input type="number" name="id_column" min="1"><br><br>
                Polc azonosító: <input type="number" name="id_shelf" min="1"><br><br>
                <button type="button" onclick="addProduct()">Hozzáadás</button>
            </form>
        `;
        document.getElementById("output").innerHTML = formHtml;
    }

    function addProduct() {
        var formData = new FormData(document.getElementById("addProductForm"));
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add_products.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("output").innerHTML = xhr.responseText;
            }
        };
        xhr.send(formData);
    }

    function listProducts() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "list_products.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("output").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

    function editProduct(id) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_product.php?id=" + id, true); // Szerver oldali fájl a termék adatok lekérdezésére
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var productData = JSON.parse(xhr.responseText);
                var formHtml = `
                    <h2>Termék módosítása</h2>
                    <form id="editProductForm">
                        Sorszám: <input type="number" name="id" min="1" value="${productData.id}" disabled><br><br>
                        Név: <input type="text" name="name" value="${productData.name}" required><br><br>
                        Ár: <input type="number" name="price" min="0" step="100" value="${productData.price}"><br><br>
                        Mennyiség: <input type="number" name="quantity" min="1" value="${productData.quantity}"><br><br>
                        Minimum mennyiség: <input type="number" name="min_quantity" min="1" value="${productData.min_quantity}"><br><br>
                        Raktár azonosító: <input type="number" name="id_store" min="1" value="${productData.id_store}"><br><br>
                        Sor azonosító: <input type="number" name="id_row" min="1" value="${productData.id_row}"><br><br>
                        Oszlop azonosító: <input type="number" name="id_column" min="1" value="${productData.id_column}"><br><br>
                        Polc azonosító: <input type="number" name="id_shelf" min="1" value="${productData.id_shelf}"><br><br>
                        <button type="button" onclick="saveEditedProduct(${productData.id})">Mentés</button>
                    </form>
                `;
                document.getElementById("output").innerHTML = formHtml;
            }
        };
        xhr.send();
    }

    function saveEditedProduct(productId) {
        var formData = new FormData(document.getElementById("editProductForm"));
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "edit_product.php?id=" + productId, true); // Szerver oldali fájl a termék adatok módosítására
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                listProducts(); // Frissítsük a termékek listáját a módosítás után
            }
        };
        xhr.send(formData);
    }

    function deleteProduct(productId) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "delete_product.php?id=" + productId, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                listProducts(); // Frissítsük a termékek listáját a törlés után
            }
        };
        xhr.send();
    }
    </script>

</body>

</html>