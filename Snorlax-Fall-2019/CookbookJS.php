<?php
	
	session_start();
	
	#redirect to login page if not logged in
	if(!isset($_SESSION['email'])){
		$_SESSION['redirect'] = 'http://localhost/snorlax-fall-2019/Cookbook.php';
		header("Location: http://localhost/snorlax-fall-2019/LoginPage.php");
	}
	
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<title>MealPrep by Snorlax</title>
</head>
<body>
<h1>
<center>Cookbook</center>
</h1>

<nav class=navbar navbar-nav>
<ul class=nav nav-pills>
  <li><a href="mealplan.html">Home</a></li>
  <li><a href= "Pantry.php">Pantry</a></li>
</ul>
</nav>

<form action="mealSubmit.php">
    <button type="submit">Submit Meal</button>
</form>
<script src="turn.js"></script>

<style type="text/css">
  #flipbook.page{
    background: url(paper.png)
  }
</style>
<div class="container1">
<center>
<div id="flipbook">

<?php

// connect to database
$mysqli = new mysqli('127.0.0.1', 'root', '', 'mealprep');
if ($mysqli->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// sql query for meals
$sql = "SELECT meal\n". "FROM recipe\n". "GROUP BY meal";
$result = $mysqli->query($sql);
if(empty($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	// print meal name
        $meal = $row['meal'];
        echo "<div><li>Meal:\t". $meal."\n";
        echo "</li>Ingredients:<br>";

    	// fetch ingredients for this meal
	    $ingredients = "SELECT ingredient, amount, measure FROM `recipe` WHERE meal= '". $meal ."' ";
    	$list = $mysqli->query($ingredients);

	    if ($list->num_rows > 0) {
	        // output data of each row
	        while($row = $list->fetch_assoc()) {

	            //print ingredient
	            echo "\t" . $row["ingredient"]." " . $row["amount"]." " . $row["measure"]. " ";
                echo "<br>";
            }echo "<br>";?>

            <input type="button" onclick="<?php  array_push($_SESSION['cart'], $meal) ;?>" value="Add to Cart">

            <?php echo "</div>";
	    } else {
	        echo "No ingredients for this meal.";}
    }
    } else {
        echo "No meal by this name.";}

//close connection
$mysqli->close();
?>


<div class="hard"></div>
<div class="hard"></div>
</div>
</div>


<script type="text/javascript">
$("#flipbook").turn({
  width: 900,
  height: 650,
  autoCenter: true
});
</script>
</center>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrit></script>
</body>
<footer>
    <?php var_dump($_SESSION['cart']);
    unset($_SESSION['cart']);?>
</footer>
</html>
