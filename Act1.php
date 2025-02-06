<?php
session_start();
if(isset($_POST["accion"]) && $_POST["accion"] == "borrar datos"){
    echo "Datos borrados";
    session_unset();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Act 1</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION["worker_name"] = $_POST["worker_name"];
        $_SESSION["product"] = $_POST["product"];
        $_SESSION["product_number"] = $_POST["product_number"];

        if ($_SESSION["product"] == "Milk") {
            switch ($_POST["accion"]) {
                case 'add':
                    $_SESSION["milk"] += $_SESSION["product_number"];
                    break;
                case 'remove':
                    if ($_SESSION["milk"] >= $_SESSION["product_number"]) {
                        $_SESSION["milk"] -= $_SESSION["product_number"];
                    }else{
                        echo "No se puede retirar mas productos ". $_SESSION["product"]. " de los que hay.";
                    }
                    break;
            }
        }
        if ($_SESSION["product"] == "Soft Drink") {
            switch ($_POST["accion"]) {
                case 'add':
                    $_SESSION["soft_drink"] += $_SESSION["product_number"];
                    break;
                case 'remove':
                    if ($_SESSION["soft_drink"] >= $_SESSION["product_number"]) {
                        $_SESSION["soft_drink"] -= $_SESSION["product_number"];
                    }else{
                        echo "<p style='color: red;'> No se puede retirar mas productos ". $_SESSION["product"]. " de los que hay.</p>";
                    }
                    break;
            }
        }
    }

    ?>

    <h1>Supermarket management</h1>

    <form method="post" action="Act1.php">
        <label for="worker">Worker name:</label>
        <input type="text" name="worker_name" required>
        <br>
        <p style="font-size: 25px;"><b>Choose product:</b></p>
        <select name="product" id="product" required>
            <option value="" disabled selected>Select a product</option>
            <option value="Milk">Milk</option>
            <option value="Soft Drink">Soft Drink</option>
        </select>
        <br>
        <p style="font-size: 25px;"><b>Product quantity:</b></p>
        <input type="number" name="product_number" value="0" min="0">
        <br><br>
        <input type="submit" value="add" name="accion">
        <input type="submit" value="remove" name="accion">
        <input type="reset" value="reset" name="accion">
        <input type="submit" value="borrar datos" name="accion">
    </form>
    <?php
    if (!isset($_SESSION["woker_name"]) && !isset($_SESSION["milk"]) && !isset($_SESSION["soft_drink"])) {
        $_SESSION["worker_name"] = "";
        $_SESSION["milk"] = 0;
        $_SESSION["soft_drink"] = 0;
    }
    echo "<p style='font-size: 25px;'><b>Inventory:</b></p>";
    echo "worker: ", $_SESSION["worker_name"], "<br>";
    echo "units milk: ", $_SESSION["milk"], "<br>";
    echo "units soft drink: ", $_SESSION["soft_drink"], "<br>";

    ?>

</body>

</html>