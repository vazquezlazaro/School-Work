<?php
// @codingStandardsIgnoreLine

session_start();

// redirect to login page if not logged in
if (!isset($_SESSION['email'])) {
    // @codingStandardsIgnoreLine
    $_SESSION['redirect'] = 'http://localhost/snorlax-fall-2019/WeeklyCalendarRep.php';
    header("Location: http://localhost/snorlax-fall-2019/LoginPage.php");
}

$user_email = $_SESSION['email'];

$conn = mysqli_connect('127.0.0.1', 'root', '', 'mealprep');
if (!$conn) {
    echo 'Connection error: '.mysqli_connect_error();
    $failure = true;
}

if (isset($_POST['submit'])) {
    if ($_POST['submit']=='recipe') {
        $meal = htmlspecialchars($_POST['task']);
        $day = htmlspecialchars($_POST['day']);
        $sql = "select distinct meal from recipe where meal = '$meal'";
        $result = mysqli_query($conn, $sql);
        $result_check = mysqli_fetch_array($result);
        if ($meal!="" && $meal==$result_check[0]) {
            $result_check = "1";
            while (!empty($result_check[0])) {
                $new_id = uniqid();
                $sql = "select id from cart where id = '$new_id'";
                $result = mysqli_query($conn, $sql);
                $result_check = mysqli_fetch_array($result);
            }
            // @codingStandardsIgnoreLine
            $sql = "INSERT INTO cart(user, meal, day, id) VALUES ('$user_email','$meal','$day','$new_id')";
            mysqli_query($conn, $sql);
        }
    } else if ($_POST['submit']=='calendar') {
        if (isset($_POST['selected'])) {
            foreach ($_POST['selected'] as $temp_id) {
                $sql = "delete from cart where id = '$temp_id'";
                mysqli_query($conn, $sql);
            }
        }
    } else if ($_POST['submit']=='reset') {
        $sql = "delete from cart where user='$user_email'";
        mysqli_query($conn, $sql);
    }
}

$sql = "select meal, day, id from cart where user = '{$_SESSION['email']}'";
$result = mysqli_query($conn, $sql);
$cart = array();
while ($row = mysqli_fetch_array($result)) {
    $cart[] = $row;
}
    
// @codingStandardsIgnoreStart
?>


<html>
<head>
    <title> Weekly Recipes </title>
    <link rel="stylesheet" type="text/css" href="weeklyCalendarRepstyles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>

  <div class="heading">
    <h2>Weekly Recipes</h2>
  </div>

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
  
  <div class="recipe-form">
    <form id="recipe-form" action="weeklyCalendarRep.php" method="POST">
        <input type="text" name="task" id="task" class="task_input">
        <select id="day" name="day">
        <option value="0">Sunday</option>
        <option value="1">Monday</option>
        <option value="2">Tuesday</option>
        <option value="3">Wednesday</option>
        <option value="4">Thursday</option>
        <option value="5">Friday</option>
        <option value="6">Saturday</option>
        </select>
        <button type="submit" class="task_btn" name="submit" value="recipe">Add Recipe</button>
    </form>
  </div>

  <div class="cart-form">
    <form action="weeklyCalendarRep.php" method="POST" >
        <table id="t01">
          <tr>
            <th>Sunday</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
          </tr>
          <tr>
            <td><?php foreach($cart as $row){if($row['day']==0){$temp_id = $row['id']; $temp_meal = $row['meal']; echo "<input type=\"checkbox\" name=\"selected[]\" value=\"$temp_id\" />$temp_meal<br />";}} ?></td>
            <td><?php foreach($cart as $row){if($row['day']==1){$temp_id = $row['id']; $temp_meal = $row['meal']; echo "<input type=\"checkbox\" name=\"selected[]\" value=\"$temp_id\" />$temp_meal<br />";}} ?></td>
            <td><?php foreach($cart as $row){if($row['day']==2){$temp_id = $row['id']; $temp_meal = $row['meal']; echo "<input type=\"checkbox\" name=\"selected[]\" value=\"$temp_id\" />$temp_meal<br />";}} ?></td>
            <td><?php foreach($cart as $row){if($row['day']==3){$temp_id = $row['id']; $temp_meal = $row['meal']; echo "<input type=\"checkbox\" name=\"selected[]\" value=\"$temp_id\" />$temp_meal<br />";}} ?></td>
            <td><?php foreach($cart as $row){if($row['day']==4){$temp_id = $row['id']; $temp_meal = $row['meal']; echo "<input type=\"checkbox\" name=\"selected[]\" value=\"$temp_id\" />$temp_meal<br />";}} ?></td>
            <td><?php foreach($cart as $row){if($row['day']==5){$temp_id = $row['id']; $temp_meal = $row['meal']; echo "<input type=\"checkbox\" name=\"selected[]\" value=\"$temp_id\" />$temp_meal<br />";}} ?></td>
            <td><?php foreach($cart as $row){if($row['day']==6){$temp_id = $row['id']; $temp_meal = $row['meal']; echo "<input type=\"checkbox\" name=\"selected[]\" value=\"$temp_id\" />$temp_meal<br />";}} ?></td>
          </tr>
        </table>
        <br>
        <center><button type="submit" class="task_button" name="submit" value="calendar">Delete</button></center>
        <br>
        <center><button type="submit" class="task_button" name="submit" value="reset">Reset</button></center>
    </form>
  </div>


</body>


</html>