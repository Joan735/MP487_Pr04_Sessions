<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Act 2</title>
</head>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["position"] = $_POST["position"];
    $_SESSION["number"] = $_POST["number"];
    if ($_POST["action"] == "Modify") {
        switch ($_SESSION["position"]) {
            case '0':
                $_SESSION["number1"] = $_SESSION["number"];
                break;
            case '1':
                $_SESSION["number2"] = $_SESSION["number"];
                break;
            case '2':
                $_SESSION["number3"] = $_SESSION["number"];
                break;
        }
    }
    if ($_POST["action"] == "Average") {
        $average = (($_SESSION["number1"] + $_SESSION["number2"] + $_SESSION["number3"]) / 3);
        echo "Average: " . $average;
    }
}
?>

<body>
    <h1>Modify array saved in session</h1>
    <form action="Act2.php" method="post">
        <label for="position">Position to modify</label>
        <select name="position" required>
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
        <br><br>
        <label for="value">New value:</label>
        <input type="number" name="number" value="0" required>
        <br><br>
        <input type="submit" name="action" value="Modify">
        <input type="submit" name="action" value="Average">
        <input type="reset" value="Reset">
        <br><br>
    </form>
    <?php
    if (!isset($_SESSION["number1"]) && !isset($_SESSION["number2"]) && !isset($_SESSION["number3"])) {
        $_SESSION["number1"] = 10;
        $_SESSION["number2"] = 20;
        $_SESSION["number3"] = 30;
    }
    echo "Current array: " . $_SESSION["number1"] . ", " . $_SESSION["number2"] . ", " . $_SESSION["number3"];
    ?>
</body>

</html>