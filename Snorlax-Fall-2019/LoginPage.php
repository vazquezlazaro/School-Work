<?php
// @codingStandardsIgnoreLine

$email = '';

$error = array('email'=>'','password'=>'');

$failure = false;

if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'mealprep');
    if (!$conn) {
        echo 'Connection error: '.mysqli_connect_error();
        $failure = true;
    }
    
    if (empty($email)) {
        $error['email'] = 'username is required<br>';
        $failure = true;
    }
    
    if (empty($password)) {
        $error['password'] = 'password is required<br>';
        $failure = true;
    }
    
    if (!$failure) {
        $sql = "select * from user_account where email like '$email'";
        $result = mysqli_query($conn, $sql);
        $account = mysqli_fetch_array($result);
        if (empty($account)) {
            $error['email'] = 'account does not exist<br>';
            $email='';
        } else if ($account['password'] == $password) {
            $error['password'] = 'login successful!<br>';
            session_start();
            $_SESSION['email'] = $email;
            if (isset($_SESSION['redirect'])) {
                header("Location: ".$_SESSION['redirect']);
            } else {
                header("Location: http://localhost/snorlax-fall-2019/mealplan.php");
            }
        } else {
            $error['password'] = 'password incorrect<br>';
        }
    }
    
    mysqli_close($conn);

}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login:</title>
        <link rel="stylesheet" type="text/css" href="LoginPageStyle.css">
    </head>
    <body>
        <h1>MealPrep</h1><br>
        <div class="container">
            <h2>Putting a PREP in your step for better MEALS!</h2>
        </div><br>
             
        <form id="LoginBox" action="LoginPage.php" method="POST">
            <a class="green"><h3>Login</h3></a>
            <a class="green">Username (email):</a><br>
            <input type="text" name="email"
            value="<?php echo htmlspecialchars($email); ?>"><br>
            <a class="red"><?php echo $error['email']; ?></a>
            <a class="green">Password:</a><br>
            <input type="password" name="password"><br>
            <a class="red"><?php echo $error['password']; ?></a>
            <br>
            <input type="submit" name="submit" value="submit">
        </form>
    </body>
</html>