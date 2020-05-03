<?php
// @codingStandardsIgnoreLine

session_start();

// redirect to login page if not logged in
if (!isset($_SESSION['email'])) {
    // @codingStandardsIgnoreLine
    $_SESSION['redirect'] = 'http://localhost/snorlax-fall-2019/GroceryListGenerator.php';
    header("Location: http://localhost/snorlax-fall-2019/LoginPage.php");
}

//connect to mysql database
$conn = mysqli_connect('127.0.0.1', 'root', '', 'mealprep');
if (!$conn) {
    echo 'Connection error: '.mysqli_connect_error();
    $failure = true;
}

//create and execute sql query to get meals from cart for the current user
$user_email = $_SESSION['email'];
$sql_retrieve_meals = "select meal from cart where user = '$user_email'";
$result = mysqli_query($conn, $sql_retrieve_meals);

//check if user has meals in the cart
if ($result==false) {
    echo 'user: '.$user_email.' has no meals';
} else {
    //puts user's meals into an array
    $meal_array = array();
    while ($row = mysqli_fetch_array($result)) {
        $meal_array[] = $row;
    }
    
    $grocery_list = array();
    
    //loop puts ingredients from meals into grocery list
    foreach ($meal_array as $row) {
        //create sql query
        $curr_meal = "'{$row['meal']}'";
        $sql_retrieve_ingredients = "select * from recipe where meal = $curr_meal";
        
        //execute query and put resulting meal ingredients into an array
        $meal_result = mysqli_query($conn, $sql_retrieve_ingredients);
        $array_curr_meal = array();
        while ($row = mysqli_fetch_array($meal_result)) {
            $array_curr_meal[] = $row;
        }
        
        //populate grocery list with meal ingredients
        foreach ($array_curr_meal as $meal_row) {
            $meal = $meal_row['meal'];
            $ingredient =  $meal_row['ingredient'];
            $measure =  $meal_row['measure'];
            $amount = $meal_row['amount'];
            $item = "$measure $ingredient";
            if (isset($grocery_list[$item])) {
                $grocery_list[$item]['amount'] += $meal_row['amount'];
            } else {
                // @codingStandardsIgnoreLine
                $new_row = array('ingredient'=>$ingredient, 'measure'=>$measure,
                'amount'=>$meal_row['amount']);
                $grocery_list[$item] = $new_row;
            }
        }
    }

    //take items out of the grocery list that are already in the pantry
    foreach ($grocery_list as $grocery) {
        $ingredient = $grocery['ingredient'];
        $measure = $grocery['measure'];
        $amount = $grocery['amount'];
        $item = "$measure $ingredient";
        $sql_pantry_check = "select * from pantry where 
        email='$user_email' and (ingredient='$ingredient' and measure='$measure')";
        $result = mysqli_query($conn, $sql_pantry_check);
        if (!empty($result)) {
            $pantry_item = mysqli_fetch_array($result);
            $diff = $amount - $pantry_item['amount'];
            if ($diff > 0) {
                $grocery_list[$item]['amount'] = $diff;
            } else {
                unset($grocery_list[$item]);
            }
        }
    }

    // Put groceries in pantry if "Add to pantry" botton was pressed
    if (isset($_POST['pantry-submit'])) {
        // Put groceries in pantry
        foreach ($grocery_list as $grocery) {
            $sql_pantry_check = "select * from pantry where 
            (ingredient='{$grocery['ingredient']}' and 
            measure='{$grocery['measure']}') and email = '$user_email'";
            $pantry_result = mysqli_query($conn, $sql_pantry_check);
            $pantry_result_check = mysqli_fetch_array($pantry_result);
            if (!empty($pantry_result_check)) {
                $sql_update_grocery = "UPDATE `pantry` SET `amount` = 
                {$pantry_result_check['amount']} + {$grocery['amount']} 
                WHERE email = '{$_SESSION['email']}' AND (ingredient = 
                '{$grocery['ingredient']}' AND measure = '{$grocery['measure']}')";
                mysqli_query($conn, $sql_update_grocery);
            } else {
                $sql_insert_grocery = "INSERT INTO `pantry`(`email`, `ingredient`, 
                `amount`, `measure`) VALUES ('{$_SESSION['email']}', 
                '{$grocery['ingredient']}', '{$grocery['amount']}', 
                '{$grocery['measure']}')";
                mysqli_query($conn, $sql_insert_grocery);
            }
        }
    }
}
    
    
?>

<?php // @codingStandardsIgnoreStart ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylePantry.css">
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <title>Grocery List Generator</title>
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

        <HR></HR>

        <ul style="list-style-type:disc;">
            <?php foreach ($grocery_list as $grocery) { ?>
                <li><?php echo $grocery['amount'].' '.$grocery['measure'].' '.$grocery['ingredient']; ?></li>
            <?php } ?>
        </ul>

        <form action="GroceryListGenerator.php" method="POST">
            <button type="submit" name="pantry-submit" value="pantry-submit">Add to pantry</button>
        </form>
    </body>
</html>