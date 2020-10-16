<?php
$path = "./" . $_GET['path'];
    $dir_contents = scandir($path);
    foreach($dir_contents as $cont){
    print("<a href='./?path=" . $_GET['path'] . "/" . $cont . "'>" . $cont . "</a><br>");
}

?>