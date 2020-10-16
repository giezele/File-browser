<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP file browser</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />


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

// deleting file
if (array_key_exists('file', $_GET)) {
    unlink($path . "/" . $_GET['file']);
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
        if ($cont != 'index.php' && $cont != 'style.css' && $cont != 'helpers.php') {
            echo ("<td><button><a href='./?path=" . $_GET['path'] . "&file=" . $cont . "'>" . "Delete</a></button></td>");
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

<script src="main.js"></script>
</body>
</html>