<?php
    
    session_start();
    
    #redirect to login page if not logged in
if (!isset($_SESSION['email'])) {
    $_SESSION['redirect'] = 'http://localhost/snorlax-fall-2019/mealSubmit.php';
    header("Location: http://localhost/snorlax-fall-2019/LoginPage.php");
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
<h1>
<center>Lets Submit a Meal!</center>
</h1>

<nav class=navbar navbar-nav>
<ul class=nav nav-pills>
  <li><a href="mealplan.html">Home</a></li>
  <li><a href= "Pantry.php">Pantry</a></li>
  <li><a href= "Cookbook.php">Cookbook</a></li>
</ul>
</nav>

<?php
    $meal = htmlspecialchars($_GET['meal']);
    $number = htmlspecialchars($_GET['number']);

if (!isset($_POST['insert'])) {
    echo "<h2><center>Submitting " . $number . " ingredients for " . $meal . "</center></h2><br><br>";
    ?>
    <form method="post">
        <?php while ($number > 0) { ?>
            <center>
                Ingredient: <input autocomplete="off" type="text" name="ingredient[]">
                Measurement: <input autocomplete="off" type="text" name="measure[]">
                Amount: <input autocomplete="off" type="text" name="amount[]">
                <br><br>
            </center>

            <?php $number--;
        } ?>

        <input type="submit" name="insert" value="Insert">
    </form>
    <form action="mealSubmit.html">
        <input type="submit" name="submit" value="Restart">
    </form>

    <?php
} else {
    $mysqli = new mysqli('127.0.0.1', 'root', '', 'mealprep');
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $ingredient = $_POST['ingredient'];
    $measure = $_POST['measure'];
    $amount = $_POST['amount'];
    $arrayLength = count($ingredient);

    echo "<h1>".$meal." Recipe</h1><br>";

    for ($i = 0; $i < $arrayLength; $i++) {
        echo  "Ingredient: ".$ingredient[$i] ." Measure: ".$measure[$i] ." Amount: ".$amount[$i];
        $sql = "INSERT INTO `recipe` (`meal`, `ingredient`, `measure`, `amount`)
        VALUES ('$meal', '$ingredient[$i]', '$measure[$i]', '$amount[$i]')";

        if ($mysqli->query($sql) === true) {
            echo " added successfully"."<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    }
    $mysqli->close();
    echo "<br>";?>
    <form action="Cookbook.php">
        <input type="submit" name="submit" value="Return">
    </form><?php
}
?>
</body>
</html>
