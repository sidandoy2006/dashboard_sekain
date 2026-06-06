<?php

session_start();

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
}

$database = "gudang_sekain";

$filename =
"backup_".
date("Y-m-d_H-i-s").
".sql";

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$filename.'"');

passthru(
'"C:\xampp\mysql\bin\mysqldump.exe" --user=root '.$database
);