<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "gudang_sekain"
);

if(!$conn){
    die("Koneksi database gagal");
}