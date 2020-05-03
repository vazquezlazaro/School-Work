<?php
// @codingStandardsIgnoreLine

session_start();

// redirect to login page if not logged in
if (!isset($_SESSION['email'])) {
    $_SESSION['redirect'] = 'http://localhost/snorlax-fall-2019/mealplan.php';
    header("Location: http://localhost/snorlax-fall-2019/LoginPage.php");
}

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet"
href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
crossorigin="anonymous">

<title>MealPrep by Snorlax</title>
</head>
<body>
<h1 style="color:green; font-family: 'Cinzel',serif;">
<center>MealPrep</center>
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

<div class="container">
<div class = "slideshow-container">
  <div class="mySlides fade">
     <div class="numbertext">1 / 3</div>
     <img src="sandwich.png" style="width:100%">
     <div class="text">This Week's Spotlight: Sandwich</div>
   </div>


   <div class="mySlides fade">
     <div class="numbertext">2 / 3</div>
     <img src="porkchop.png" style="width:100%">
     <div class="text">This Week's Spotlight: Porkchop</div>
   </div>

   <div class="mySlides fade">
     <div class="numbertext">3 / 3</div>
     <img src="oatmeal.png" style="width:100%">
     <div class="text">This Week's Spotlight: Oatmeal</div>
   </div>
<script src = "slideshow.js"></script>
   <!-- Next and previous buttons -->
   <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
   <a class="next" onclick="plusSlides(1)">&#10095;</a>
 </div>
 <br>

 <!-- The dots/circles -->
 <div style="text-align:center">
   <span class="dot" onclick="currentSlide(1)"></span>
   <span class="dot" onclick="currentSlide(2)"></span>
   <span class="dot" onclick="currentSlide(3)"></span>
</div>
</div>
<script
src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
integrit>
</script>
<script
src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
crossorigin="anonymous"></script>
</body>
</html>
