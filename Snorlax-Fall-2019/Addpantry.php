<?php
// Connect to database
$mysqli = new mysqli('127.0.0.1', 'root', '', 'mealprep');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
//Creating Arrays
$ingredient =array();
$measure =array();
$amount =array();

//filling out ingredient,measure,amount arrays from cart/recipe tables sql
$sql = "SELECT ingredient, measure, amount from cart, recipe where cart.meal=recipe.meal and USER = 'phillipsjosh18@students.ecu.edu'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $ingredient[] = $row["ingredient"];
        $measure[] = $row['measure'];
        $amount[] = $row['amount'];
    }
}

//Gets the length of the array for for loop
$rows1= mysqli_num_rows ( $result );
/* Adding/Updating to pantry
 * First php trys to insert the recipe into the pantry, if there recipe is not in the pantry then the insert is add
 * if there is an error then the recipe ingredients are already in the pantry so php update is set.
 */
for($i = 0; $i < $rows1; $i++) {
    $sql = "INSERT INTO pantry (email, ingredient, amount, measure)
            VALUES ('phillipsjosh18@students.ecu.edu', '$ingredient[$i]', '$amount[$i]', '$measure[$i]')";
                 if ($mysqli->query($sql) === TRUE) {
                  echo "added successfully"."'$ingredient[$i]', '$amount[$i]', '$measure[$i] ' "."<br>";
                 }
                  else {
                     $sql = "UPDATE pantry SET amount = amount + '$amount[$i]' WHERE email ='phillipsjosh18@students.ecu.edu' and ingredient ='$ingredient[$i]'
                             and measure= '$measure[$i]'";
                     if ($mysqli->query($sql) === TRUE) {
                         echo "Updated successfully, '$amount[$i]', '$ingredient[$i]','$measure[$i]'" . "<br>";
                     } else{
                        echo "Error: " . $sql . "<br>" . $mysqli->error;
                      }
                   }

}
//close connection
$mysqli->close();


