<?php

session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
}

$id = $_GET['id'];

mysqli_query(
$conn,
"DELETE FROM produk
WHERE id='$id'"
);

header("Location: produk.php");