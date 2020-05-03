<?php
// @codingStandardsIgnoreLine

$firstname = $lastname = $email = $password1 = $password2 = "";

$error = array('firstname'=>'', 'lastname'=>'', 'email'=>'', 'password1'=>'',
               'password2'=>'');

$failure = false;

if (isset($_POST['submit'])) {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $password1 = htmlspecialchars($_POST['password1']);
    $password2 = htmlspecialchars($_POST['password2']);
    
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'mealprep');
    if (!$conn) {
        echo 'Connection error: '.mysqli_connect_error();
        $failure = true;
    }
    
    if (empty($firstname)) {
        $error['firstname'] = "this field is required<br>";
        $failure = true;
    }
    
    if (empty($lastname)) {
        $error['lastname'] = "this field is required<br>";
        $failure = true;
    }
    
    if (empty($email)) {
        $error['email'] = "this field is required<br>";
        $failure = true;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "please enter a valid email<br>";
        $failure = true;
    }
    
    if (empty($password1)) {
        $error['password1'] = "this field is required<br>";
        $error['password2'] = "this field is required<br>";
        $failure = true;
    }
    
    if (empty($password2)) {
        $error['password1'] = "this field is required<br>";
        $error['password2'] = "this field is required<br>";
        $failure = true;
    }
    
    if (!$failure) {
        if ($password1 == $password2) {
            $sqlcheck = "select * from user_account where email like '$email'";
            $result = mysqli_query($conn, $sqlcheck);
            $result_check = mysqli_fetch_array($result);
            if (empty($result_check)) {
                $sqlinsert = "insert into user_account(firstname, lastname,
                email, password) values ('$firstname', '$lastname', '$email',
                '$password1')";
                mysqli_query($conn, $sqlinsert);
                $error['password2'] = 'Account Created!';
            } else {
                $error['email'] = 'email already in use<br>';
            }
        } else {
            $error['password2'] = 'password mismatch<br>';
        }
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create an account</title>
        <link rel="stylesheet" type="text/css" href="CreateAccountStyle.css">
    </head>
    <body>
        <h1>MealPrep</h1>
        </br>
        <div class="container">
            <h2>Putting a PREP in your step for better MEALS!</h2>
         </div>
        </br>
            
        <form id="createAccount" action="CreateAnAccount.php" method="POST">
            <a class = "green"><h3>Create an account:</h3></a>
            <a class="green">First name:</a><br>
            <input type="text" name="firstname"
            value="<?php echo htmlspecialchars($firstname); ?>"><br>
            <a class="red"><?php echo $error['firstname']; ?></a>
            <a class="green">Last name:</a><br>
            <input type="text" name="lastname"
            value="<?php echo htmlspecialchars($lastname); ?>"><br>
            <a class="red"><?php echo $error['lastname']; ?></a>
            <a class="green">E-mail:</a><br>
            <input type="text" name="email"
            value="<?php echo htmlspecialchars($email); ?>"><br>
            <a class="red"><?php echo $error['email']; ?></a>
            <a class="green">Password:</a><br>
            <input type="password" name="password1"><br>
            <a class="red"><?php echo $error['password1']; ?></a>
            <a class="green">Confirm-Password:</a><br>
            <input type="password" name="password2"><br>
            <a class="red"><?php echo $error['password2']; ?></a>
            <br>
            <input type="submit" name="submit" value="submit">
        </form>
    </body>
</html>
