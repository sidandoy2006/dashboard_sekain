<?php

session_start();

include '../config/koneksi.php';

$id = $_POST['produk_id'];

$jumlah = $_POST['jumlah'];

$jenis = $_POST['jenis'];

$alasan = $_POST['alasan'];

$keterangan = $_POST['keterangan'];

if($jenis=="keluar"){

    mysqli_query(
    $conn,
    "
    UPDATE produk
    SET stok=stok-$jumlah
    WHERE id='$id'
    ");

    mysqli_query(
    $conn,
    "
    INSERT INTO stok_keluar
    (
    produk_id,
    jumlah
    )
    VALUES
    (
    '$id',
    '$jumlah'
    )
    ");

}

elseif($jenis=="reject"){

    mysqli_query(
    $conn,
    "
    UPDATE produk
    SET stok=stok-$jumlah
    WHERE id='$id'
    ");

    mysqli_query(
    $conn,
    "
    INSERT INTO barang_reject
    (
    produk_id,
    jumlah,
    alasan,
    keterangan
    )
    VALUES
    (
    '$id',
    '$jumlah',
    '$alasan',
    '$keterangan'
    )
    ");

}

header("Location: scan.php");