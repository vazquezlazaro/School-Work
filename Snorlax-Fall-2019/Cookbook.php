<?php
    
    session_start();

    #redirect to login page if not logged in
if (!isset($_SESSION['email'])) {
    $_SESSION['redirect'] = 'http://localhost/snorlax-fall-2019/Cookbook.php';
    header("Location: http://localhost/snorlax-fall-2019/LoginPage.php");
} else {
    $mysqli = new mysqli('127.0.0.1', 'root', '', 'mealprep');
    if ($mysqli->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user = $_SESSION['email'];
    $sql = "SELECT `firstname`, `lastname`  FROM `user_account` WHERE `email` LIKE '$user'";
    $name = $mysqli->query($sql)->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<title>MealPrep by Snorlax</title>
</head>
<body>
<center><h1>Cookbook</h1></center>

<?php echo "<br> Welcome ".$name['firstname']. " " .$name['lastname']."!"?>

<nav class=navbar navbar-nav>
<ul class=nav nav-pills>
    <li><a href="mealplan.php">Home</a></li>
    <li><a href= "Pantry.php">Pantry</a></li>
    <li><a href= "Cookbook.php">Cookbook</a></li>
    <li><a href= "WeeklyCalendarRep.php">Cart</a></li>
    <li><a href= "GroceryListGenerator.php">GroceryList</a></li>
    <li><a href= "Logout.php">Logout</a></li>
</ul>
</nav>

<form action="mealSubmit.html">
    <button type="submit">Submit Meal</button>
</form>
<pre>

<?php
$sql = "SELECT meal\n". "FROM recipe\n". "GROUP BY meal";
$result = $mysqli->query($sql);

if (isset($_POST['addMeal'])) {
    if (isset($_SESSION["cart"])) {
        $meal_id = array_column($_SESSION["cart"], "meal");
        if (!in_array($_GET["meal"], $meal_id)) {
            $count = count($_SESSION["cart"]);
            $item = array(
                'meal' => $_GET["meal"]
            );
            $_SESSION["cart"][$count] = $item;
        } else {
            echo '<script>alert("Meal Already Added")</script>';
            echo'<script>window.location="Cookbook.php"</script>';
        }
    } else {
        $item = array(
            'meal' => $_GET["meal"]
        );
        $_SESSION["cart"][0] = $item;
    }
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $meal = $row['meal'];
        echo "Meal:" . $meal . "<br>";
        echo "Ingredients: <br>";


        $ingredients = "SELECT ingredient, amount, measure FROM `recipe` WHERE meal= '" . $meal . "' ";
        $list = $mysqli->query($ingredients);

        if ($list->num_rows > 0) {
            while ($row = $list->fetch_assoc()) {
                echo "\t" . $row["ingredient"] . " " . $row["amount"] . " " . $row["measure"] . " ";
                echo "<br>";
            } ?>

                <form method="post" action="Cookbook.php?action=add&meal=<?php echo $meal ?>">
                    <input type="submit" name="addMeal" style="margin-top" class="btn btn-success" value="Add to MealPlan"/>
                </form>

        <?php }
    }
} ?>

</pre>
</body>
<footer>
    <?php
    echo "<h3>Meals Selected</h3>";
    if (!empty($_SESSION["cart"])) {
        $meal_array = array();
        foreach ($_SESSION["cart"] as $items => $values) {
            echo $values["meal"]. " | ";
            array_push($meal_array, $values["meal"]);
        }
        $arrayLength = count($meal_array);?>

        <form method="post">
            <input type="submit" name="confirm" value="Confirm"/>
        </form>

        <?php
    }


    if (isset($_POST['confirm'])) {
        for ($i = 0; $i < $arrayLength; $i++) {
            $sql = "INSERT INTO `cart` (`user`, `meal`)
        VALUES ('$user', '$meal_array[$i]')";

            if ($mysqli->query($sql) === true) {
            }
        }
        $mysqli->close();
    }
    ?>
</footer>
</html>
