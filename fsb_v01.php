<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP file browser</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />


<?php
require_once 'helpers.php';


print("Server Request URI -- " . $_SERVER['REQUEST_URI']);
pl();
print("GET path --" . $_GET['path']);



$path = "./" . $_GET['path'];
$dir_contents = scandir($path);
pl();
print("pathas--" . $path);
pl();
echo('<h2>Directory contents: ' . ($path) . '</h2>');
echo ('<table class="redTable">
        <thead><tr><th>Type</th><th>Name</th><th>Actions</th></tr></thead>');
echo('<tbody>');

if (isset($_POST['newDir'])) {
    if (!is_dir($path . ($_POST['newDir']))) {
        mkdir($path . ($_POST['newDir']));
    }
    // mkdir($path . ($_POST['newDir']));
    // print($_POST['newDir']);
}
foreach ($dir_contents as $cont){
    print("<pre>" . $path . $cont . "</pre>");
    
    //filtering out . and .. 
    if ($cont == "." || $cont == "..") {
        continue;
    }
    //printing types (Dir or file)
    if(is_dir($path . $cont)){
        print ('<tr name="trow">
        <td>' .'Dir' . '</td>');
        
    } else {
        print ('<tr><td>' .'file' . '</td>');
    }

    // printing names
    print('<td><a href=?path=' . $_GET['path'] . $cont .'/>' . $cont . '</a> </td>');
    
    // printing actions
    if(is_file($path . $cont)){
        if ($cont != "index.php"){
            print ('<td><input type="submit" class="btn_delete" name="btn_delete" value="Delete"/></td></tr>');
        } else print ('<td></td></tr>');
    } else {
        print ('<td></td></tr>');
    }
    
}
echo('<tfoot>
        <tr>
        <td colspan="3">
        <div class="links"><a href="' . dirname($path) .'">&laquo; BACK (under construction)</a></div>
        </td>
        </tr>
        </tfoot>');
echo ('</table>');

 


 // file download logic
 if(isset($_POST['download'])){
    // print('Path to download: ' . './' . $_GET["path"] . $_POST['download']);
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

    
    ?>
<div class="newDirDiv">
    <form action="<?php $path ?>" method="POST">
        <label for="newDir">Name of new directory: </label>
        <input type="text" id="newDir" name="newDir" placeholder="Enter name">
        <input type="submit" value="Create new directory" id="create_btn">
        
    </form>

</div>
 

    <script src="main.js"></script>
</body>
</html>