<?php
function connection(){
    $lien = mysqli_connect('localhost','root','admin','shop')
        or die('DB Connect Error: ' . mysqli_connect_error());
    return $lien;
}
?>