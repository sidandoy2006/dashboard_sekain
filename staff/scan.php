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
    "
    SELECT *
    FROM produk
    WHERE kode_barang='$kode'
    ");

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

<h2>Picking Barang</h2>

<form method="POST" id="scanForm">

<input
type="text"
name="kode_barang"
id="barcode"
class="form-control"
placeholder="Scan barcode..."
autofocus>

</form>

<script>

document
.getElementById('barcode')
.addEventListener('change',function(){

    document
    .getElementById('scanForm')
    .submit();

});

</script>

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

<h4>

<?= $produk['nama_barang']; ?>

</h4>

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
action="proses_scan.php"
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

<label>Jenis Transaksi</label>

<select
name="jenis"
class="form-control mb-2">

<option value="keluar">
Barang Keluar
</option>

<option value="reject">
Barang Reject
</option>

</select>

<select
name="alasan"
class="form-control mb-2">

<option value="">
Pilih Alasan
</option>

<option value="Noda">
Noda
</option>

<option value="Bolong">
Bolong
</option>

<option value="Jahitan Lepas">
Jahitan Lepas
</option>

<option value="Sablon Rusak">
Sablon Rusak
</option>

</select>

<textarea
name="keterangan"
class="form-control mb-2"
placeholder="Catatan"></textarea>

<button
class="btn btn-success">

Simpan

</button>

</form>

</div>

</div>

<?php } ?>

</div>

</body>
</html>