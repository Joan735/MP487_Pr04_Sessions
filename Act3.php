<?php
session_start();
if (isset($_POST["borrar_datos"])) {
    echo "Datos borrados";
    session_unset();
}
if (!isset($_SESSION["list"])) {
    $_SESSION["list"] = [];
}
if (!isset($_SESSION["updName"]) && !isset($_SESSION["updIndex"])) {
    $_SESSION["updName"] = "";
    $_SESSION["updIndex"] = "";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Shopping list</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
        }

        input[type=submit] {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <?php
    $name = "";
    $quantity = "";
    $price = "";
    $error = "";
    $message = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // If the button "add" is pressed, the product will be added to the inventory. But if it already exists, it won't be added. 
        // Also it is mandatory to add an amount greater than 0.
        if (isset($_POST["add"])) {
            $found = false;
            foreach ($_SESSION["list"] as $index1 => $item1) {
                if ($item1["name"] == $_POST["name"]) {
                    $found = true;
                    $error = "This product already exists.";
                }
            }
            if ($_POST["name"] == "" || $_POST["quantity"] == "" || $_POST["price"] == "") {
                $found = true;
                $error = "The product must have a name and the quantity and price can't be 0 or nothing.";
            }
            if ($found != true) {
                $productos = array("name" => $_POST["name"], "quantity" => $_POST["quantity"], "price" => $_POST["price"]);
                $_SESSION["list"][] = $productos;
                $message = "Item addded properly.";
            }
        }
        // A button that deletes the product when pressed.
        if (isset($_POST["delete"])) {
            unset($_SESSION["list"][$_POST["index"]]);
            $message = "Item deleted properly.";
        }
        // A button that will send the information to the inputs, to be updated.
        if (isset($_POST["edit"])) {
            $name = $_POST["name"];
            $quantity = $_POST["quantity"];
            $price = $_POST["price"];
            $index = $_POST["index"];
            $_SESSION["updName"] = $name;
            $_SESSION["updIndex"] = $index;
        }
        // A button that works after the "edit" button is pressed and it will update the product if it exists, with the new information. 
        if (isset($_POST["update"])) {
            if ($_POST["name"] == "" || $_POST["quantity"] == "" || $_POST["price"] == "") {
                $error = "You must fill all the fields to update a product.";
            } else {
                $found = false;
                foreach ($_SESSION["list"] as $index1 => $item1) {
                    if ($item1["name"] == $_SESSION["updName"]) {
                        $_SESSION["list"][$_SESSION["updIndex"]] = ["name" => $_SESSION["updName"], "quantity" => $_POST["quantity"], "price" => $_POST["price"]];
                        $message = "Item updated properly.";
                        $found = true;
                        $_SESSION["updName"] = "";
                        $_SESSION["updIndex"] = "";
                    }    
                }
                if ($found == false) {
                    $error = "Item not found or you haven't add any item or you didn't click edit.";
                }    
            }
        }
    }  
    ?>
    <h1>Shopping list</h1>
    <form method="post">
        <label for="name">name:</label>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>">
        <br>
        <label for="quantity">quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo $quantity; ?>" min="1">
        <br>
        <label for="price">price:</label>
        <input type="number" name="price" id="price" value="<?php echo $price; ?>" min="1">
        <br>
        <input type="hidden" name="index" value="<?php echo $index; ?>">
        <input type="submit" name="add" value="Add">
        <input type="submit" name="update" value="Update">
        <input type="submit" name="reset" value="Reset">
        <input type="submit" name="borrar_datos" value="Borrar datos">
    </form>
    <p style="color:red;"><?php echo $error; ?></p>
    <p style="color:green;"><?php echo $message; ?></p>
    <table>
        <thead>
            <tr>
                <th>name</th>
                <th>quantity</th>
                <th>price</th>
                <th>cost</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $_SESSION["value"] = 0;
                foreach ($_SESSION["list"] as $index => $item) { ?>
                    <tr>
                        <td><?php echo $item["name"]; ?></td>
                        <td><?php echo $item["quantity"]; ?></td>
                        <td><?php echo $item["price"]; ?></td>
                        <td><?php echo ($item["quantity"] * $item["price"]); ?></td>
                        <?php
                        // Save the total value to "value"
                        $_SESSION["value"] += ($item["quantity"] * $item["price"]);
                        ?>
                        <td>
                            <form method="post">
                                <input type="hidden" name="name" value="<?php echo $item["name"]; ?>">
                                <input type="hidden" name="quantity" value="<?php echo $item["quantity"]; ?>">
                                <input type="hidden" name="price" value="<?php echo $item["price"]; ?>">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <input type="submit" name="edit" value="Edit">
                                <input type="submit" name="delete" value="Delete">
                            </form>
                        </td>
                    </tr>
            <?php }
            } ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <?php
                // Assign a value to "totalValue"
                if (!isset($totalValue)) {
                    $totalValue = 0;
                }
                // Save the total value of the product to "totalValue" that will be displayed.
                if (isset($_POST['total'])) {
                    $totalValue = $_SESSION["value"];
                }
                ?>
                <td><?php echo $totalValue; ?></td>
                <td>
                    <form method="post">
                        <input type="submit" name="total" value="Calculate total">
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</body>