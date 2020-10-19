<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FSB 02</title>
    <link rel="stylesheet" type="text/css" href="./css/normalize.css>"/>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>
<body>
   
    <?php
    require_once 'helpers.php';

    $path = "." . $_GET['path'];

    echo('<h2>Directory contents: ' . ($path) . '</h2>');
    // making new directory on user input
    if (isset($_POST['newDir'])) {
        if (!(is_dir($path . "/" . ($_POST['newDir'])))) {
            mkdir($path . "/" . ($_POST['newDir']));
        }
    }
    
    // file download logic
    if(isset($_POST['download'])){
        print('Path to download: ' . './' . $_GET["path"] . $_POST['download']);
        $file='./' . $_GET["path"] . $_POST['download'];
        // a&nbsp;b.txt
        // a b.txt
        $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
        ob_clean();
        ob_start();
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf'); // mime type → ši forma turėtų veikti daugumai failų, su šiuo mime type. Jei neveiktų reiktų daryti sudėtingesnę logiką
        header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileToDownloadEscaped)); // kiek baitų browseriui laukti, jei 0 - failas neveiks nors bus sukurtas
        ob_end_flush();
        readfile($fileToDownloadEscaped);
        exit;
    }

   
    // deleting file
    // if (array_key_exists('file', $_GET)) {
    //     unlink($path . "/" . $_GET['file']);
    // }

    if(isset($_GET['delete'])){
        $delurl=($path . "/" . $_GET['delete']);
        unlink($delurl);
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
                echo ("<td><button><a href='./?delete=" . $_GET['delete'] . "&delete=" . $cont . "'>" . "Delete</a></button>
                        <button><a href='./?path=" . $_GET['path'] . "&file=" . $cont . "'>" . "Download</a></button>
                        <button><a href='./?path=" . $_GET['path'] . "&file=" . $cont . "' download>" . "Down</a></button></td>");
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


    <div class="newDirDiv">
        <form action="<?php $path ?>" method="POST">
            <label for="newDir">Name of new directory: </label>
            <input type="text" id="newDir" name="newDir" placeholder="Enter name">
            <input type="submit" value="Create new directory" id="create_btn" class="create_btn">
            
        </form>
    </div>
    <div>
    <p class="log_out">Click here to <a href = "index.php?action=logout"> logout.</p>

    </div> 

    <script src="main.js"></script>
</body>
</html>