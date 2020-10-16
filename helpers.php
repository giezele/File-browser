<?php
function pl() {
    print('<br>');
} 

function getFiles() {
    $dir = getDir();
    return scandir($dir);
}

?>