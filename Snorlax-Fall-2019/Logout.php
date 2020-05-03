<?php
// @codingStandardsIgnoreLine

session_start();
session_unset();
session_destroy();
header("Location: http://localhost/snorlax-fall-2019/MealPrep_HomePage.html");

?>