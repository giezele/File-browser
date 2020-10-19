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

    //login logic
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

    if($_SESSION['logged_in'] == true){
        print('<h2>You are logged in!</h2>');
        //nuo cia
        $path = "." . $_GET['path'];

        echo('<h2>Directory contents: ' . ($path) . '</h2>');
        // making new directory on user input
        if (isset($_POST['newDir'])) {
            if (!(is_dir($path . "/" . ($_POST['newDir'])))) {
                mkdir($path . "/" . ($_POST['newDir']));
            }
        }

        // upload file logic 
        if(isset($_POST['upload'])) {
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file_store = ($path . "/") . $file_name;
            move_uploaded_file($file_tmp, $file_store);  
        }
    
        // deleting and downloading file
       
        if (array_key_exists('action', $_GET)) {    
            if (array_key_exists('file', $_GET)) {
                    $file = $_GET['path'] . "/" . $_GET['file'];
                if ($_GET['action'] == 'delete') {
                    unlink($path . "/" . $_GET['file']);
                } elseif ($_GET['action'] == 'download') {     
                    $fileDown = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
                    print_r($fileDown);
                    print_r($file);
                    ob_clean();
                    ob_flush();
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/png');
                    header('Content-Disposition: attachment; filename=' . basename($fileDown));
                    header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($fileDown));
                    ob_end_flush();
                    readfile($fileDown);
                }
            }
        }
    
        // printing table
        $dir_contents = scandir($path);
        echo ('<table class="redTable"><thead><tr>
                <th>Type</th>
                <th>Name</th>
                <th>Actions</th>
                </tr></thead>');
        echo ('<tbody><tr>');
        foreach ($dir_contents as $cont) {
            // print("<pre>" . $path ."/". $cont . "</pre>");
    
            //filtering out . and .. 
            if ($cont == "." || $cont == "..") {
                continue;
            }
            //printing types (Dir or file)
            echo ('<tr><td>' . (is_dir($path . "/" . $cont) ? 'Dir' : 'file') . '</td>');
            
            // printing names
            if (is_dir($path . "/" . $cont)) {
                echo ('<td>' . "<a href='./?path=" . $_GET['path'] . "/" . $cont . "'>" . $cont .  '</a></td>');
                
            } else {
                echo ('<td>' . $cont . '</td>');
            }
    
            // printing actions
            if (is_file($path . "/" . $cont)) {
                if ($cont != 'index.php' && $cont != 'style.css' && $cont != 'helpers.php' && $cont != 'login.php') {
                    echo ("<td><button><a href='./?path=" . $_GET['path'] . "&file=" . $cont . "&action=delete" ."'>" . "Delete</a></button>
                        <button><a href='./?path=" . $_GET['path'] . "&file=" . $cont . "&action=download". "'>" . "Download</a></button>");
                } else {
                    echo ('<td></td>');
                }
            } else {
                echo ('<td></td>');
            }
        }
        echo ('</tbody>');
        echo('<tfoot>
                <tr>
                <td colspan="3">
                <div class="links">' . "<a href='./?path=" . "#" . "'>" . "&laquo; BACK to da root" . "</a>" . '</div>
                </td>
                </tr>
                </tfoot>');
        echo ('</table>');
    ?> 
    
    <!-- new Dir creating form -->
    <div class="newDirDiv">
        <form action="<?php $path ?>" method="POST">
            <label for="newDir">Name of new directory: </label>
            <input type="text" id="newDir" name="newDir" placeholder="Enter name">
            <input type="submit" value="Create new directory" id="create_btn" class="create_btn">
            
        </form>
    </div>
    <div>

    <div class="uploadDiv">
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" class="create_btn">
        <br>
        <button type="submit" name="upload" class="create_btn">Upload file</button>
    </form>
    </div>
    <?php
           //iki cia

        //logout div
    echo('<h4 class="log_out">Click here to <a href = "index.php?action=logout"> logout.</h4>');     
    } else {
        //login div //pataisyti action kad siustu i index.php
        echo('
            <div class="log_div">
                <h1>Enter Username and Password</h1>
        
                <form action="./index.php" method="post"> 
                <h4>'.$msg.'</h4>
                <div class="log_input">
                    <input type="text" name="username" placeholder="username = Giedre" required autofocus></br>
                    <input type="password" name="password" placeholder="password = 1234" required>
                    <button class = "btn_login" type="submit" name="login">Login</button>
                </div>
                    </form> 
            </div>   ');
    }
?>
<div>
    <!-- //pataisyti logout ahrefa kaip is komentaro -->
    <!-- <p class="log_out">Click here to <a href = "index.php?action=logout"> logout.</p> -->

</div> 
</body>
</html>
