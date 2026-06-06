<?php

session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
}

$produk = null;

if(isset($_POST['cari'])){

    $kode = $_POST['kode_barang'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM produk
        WHERE kode_barang='$kode'"
    );

    $produk = mysqli_fetch_assoc($query);
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Picking Barang</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<a
href="dashboard.php"
class="btn btn-secondary mb-3">

← Dashboard

</a>

<h2>📦 Picking Barang</h2>

<form method="POST">

<input
type="text"
name="kode_barang"
class="form-control mb-2"
placeholder="Scan Barcode">

<button
name="cari"
class="btn btn-primary">

Cari

</button>

</form>

<?php if($produk){ ?>

<hr>

<div class="card">

<div class="card-body">

<h4><?= $produk['nama_barang']; ?></h4>

<p>

Kode :
<?= $produk['kode_barang']; ?>

<br>

Warna :
<?= $produk['warna']; ?>

<br>

Ukuran :
<?= $produk['ukuran']; ?>

<br>

Stok :
<?= $produk['stok']; ?>

</p>

<form
action="proses_keluar.php"
method="POST">

<input
type="hidden"
name="produk_id"
value="<?= $produk['id']; ?>">

<input
type="number"
name="jumlah"
value="1"
class="form-control mb-2">

<button
class="btn btn-success">

Simpan Barang Keluar

</button>

</form>

</div>

</div>

<?php } ?>

</div>

</body>
</html>