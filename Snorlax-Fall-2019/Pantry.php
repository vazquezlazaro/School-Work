<?php
	
	session_start();
	
	#redirect to login page if not logged in
	if(!isset($_SESSION['email'])){
		$_SESSION['redirect'] = 'http://localhost/snorlax-fall-2019/Pantry.php';
		header("Location: http://localhost/snorlax-fall-2019/LoginPage.php");
	}
	
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="stylePantry.css">
	 <link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    #pantry {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 40%;
    }

    #pantry td, #pantry th {
    border: 1px solid white;
    padding: 2px;
    }

    #pantry tr:nth-child(even){background-color: white;}

    #pantry tr:hover {background-color: white;}

    #pantry th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
    }
    </style>

	<title>Pantry</title>

</head>
<body>
	<h1 style="color:green; font-family: 'Cinzel',serif;">
<center >MealPrep's Pantry</center>
</h1>

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
<pre>
<table id="pantry">
  <tr>
    <th>Ingredient</th>
    <th>Measure</th>
    <th>Amount</th>
  </tr>
</table>

<?php 
// connect to database
$mysqli = new mysqli('127.0.0.1', 'root', '', 'mealprep');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$user_email = $_SESSION['email'];;

$sql = "select ingredient, measure, amount from pantry, user_account where pantry.email = user_account.email and user_account.email= '$user_email'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) { ?>
		<table id="pantry">
		<tr>
			<th> <?php echo $row["ingredient"]; ?> </th> 
			<th> <?php echo $row["measure"]; ?></th> 
			<th> <?php echo $row["amount"]; ?> </th> 
		</tr>
		</table>
   <?php } 
} else {
    echo "Pantry is empty! Go Prep some Meals!";
    }
?>
<p> "I have used or out of...</p>
<form action="Pantry.php" method="POST">
<p>Ingredient: <input type="text" name="ingredient" id="ingredient" value=""></p>
<p>Amount: <input type="text" name="amount" id="amount" value=""></p>
<input type="submit" name="submit" "value="submit">
</form>

<?php
if(isset($_POST['submit'])){
	$ing =$_POST['ingredient'];
	$amount = $_POST['amount'];
    $sql = "Update pantry Set amount = amount - '$amount' where email= '$user_email' and ingredient = '$ing' ";
    echo "<meta http-equiv='refresh' content=' 0; url=Pantry.php'>";
    if ($mysqli->query($sql)>0) {
        $sql = "SELECT amount FROM pantry WHERE ingredient='$ing'";
        $result = $mysqli->query($sql);
        while($row = $result->fetch_assoc()){
            if($row["amount"]<=0 ){
                $sql = "Delete from pantry where ingredient = '$ing' and email= '$user_email'";
                $mysqli->query($sql);
            }
        }
    }
}
?>

<?php
//close connection
$mysqli->close();
?>
<pre>
</body>
</html>
