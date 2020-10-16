<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG IN to File Browser</title>
    <link rel="stylesheet" type="text/css" href="./css/normalize.css>"/>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>
<body>
<?php 
    session_start();
    // logout logic
    if(isset($_GET['action']) and $_GET['action'] == 'logout'){
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['logged_in']);
        print('Logged out!');
    }
?>
<h1>Enter Username and Password</h1> 
<div>
    <?php
    $msg = '';
    if (isset($_POST['login']) 
        && !empty($_POST['username']) 
        && !empty($_POST['password'])
    ) {	
        if ($_POST['username'] == 'Giedre' && 
            $_POST['password'] == '1234'
        ) {
            $_SESSION['logged_in'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = 'Giedre';
            echo 'You have entered valid user name and password';
        } else {
            $msg = 'Wrong username or password';
        }
    }
    ?>
</div>
<div>
    <?php 
        if($_SESSION['logged_in'] == true){
            print('<h1>You can only see this if you are logged in!</h1>');
            
        }
    ?>
</div>
<!-- // cia siuncia i indexa -->
<form action="./login.php" method="post"> 
<h4><?php echo $msg; ?></h4>
<div class="log_div">
    <input type="text" name="username" placeholder="username = Giedre" required autofocus></br>
    <input type="password" name="password" placeholder="password = 1234" required>
    <button class = "btn_login" type="submit" name="login">Login</button>
</div>
</form>
<div>
    <!-- //pataisyti ahrefa kaip is komentaro -->
    <!-- <p class="log_out">Click here to <a href = "index.php?action=logout"> logout.</p> -->

<p class="log_out">Click here to <a href = "login.php?action=logout"> logout.</p>


</div> 
</body>
</html>
