<?php

session_start();

include '../config/koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
}

$total_produk = mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total FROM produk"
));

$total_stok = mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT IFNULL(SUM(stok),0) total FROM produk"
));

$stok_tipis = mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total
FROM produk
WHERE stok <= stok_minimum"
));

$keluar = mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT IFNULL(SUM(jumlah),0) total
FROM stok_keluar
WHERE DATE(tanggal)=CURDATE()
"
));

$reject = mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT IFNULL(SUM(jumlah),0) total
FROM barang_reject
WHERE DATE(tanggal)=CURDATE()
"
));

?>
<!DOCTYPE html>
<html>
<head>

<title>Dashboard Admin</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="../assets/css/style.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<div class="banner mb-4">

<div class="banner-content">

</div>

</div>

<h2 class="mb-4">
Dashboard
</h2>

<div class="row text-center mb-4">

<div class="col">

<a
href="produk.php"
class="card p-3 menu-card shadow-sm">

📦
<br>
Produk

</a>

</div>

<div class="col">

<a
href="produk_masuk.php"
class="card p-3 menu-card shadow-sm">

📥
<br>
Stok Masuk

</a>

</div>

<div class="col">

<a
href="riwayat_keluar.php"
class="card p-3 menu-card shadow-sm">

📤
<br>
Keluar

</a>

</div>

<div class="col">

<a
href="barang_reject.php"
class="card p-3 menu-card shadow-sm">

❌
<br>
Reject

</a>

</div>

<div class="col">

<a
href="barcode.php"
class="card p-3 menu-card shadow-sm">

🏷️
<br>
Barcode

</a>

</div>

<div class="col">

<a
href="export_excel.php"
class="card p-3 menu-card shadow-sm">

📊
<br>
Excel

</a>

</div>

</div>

<div class="row mb-4">

<div class="col-md-3">

<div class="card stat-card shadow-sm">

<div class="card-body">

<h6>Total Produk</h6>

<h2>

<?= $total_produk['total']; ?>

</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card stat-card shadow-sm">

<div class="card-body">

<h6>Total Stok</h6>

<h2>

<?= $total_stok['total']; ?>

</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card stat-card shadow-sm">

<div class="card-body">

<h6>Keluar Hari Ini</h6>

<h2>

<?= $keluar['total']; ?>

</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card stat-card shadow-sm">

<div class="card-body">

<h6>Reject Hari Ini</h6>

<h2>

<?= $reject['total']; ?>

</h2>

</div>

</div>

</div>

</div>

<?php

$keluar_hari_ini = mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT IFNULL(SUM(jumlah),0) total
FROM stok_keluar
WHERE DATE(tanggal)=CURDATE()
"
));

$reject_hari_ini = mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT IFNULL(SUM(jumlah),0) total
FROM barang_reject
WHERE DATE(tanggal)=CURDATE()
"
));

?>

<div class="alert alert-info">

<b>Ringkasan Hari Ini</b>

<br><br>

Barang Keluar :
<?= $keluar_hari_ini['total']; ?>

pcs

<br>

Barang Reject :
<?= $reject_hari_ini['total']; ?>

pcs

</div>

<div class="card activity-card shadow-sm">

<div class="card-header">

<div class="card shadow-sm mt-3">

<div class="card-header bg-warning">

⚠️ Stok Menipis

</div>

<div class="card-body">

<table class="table">

<tr>
<th>Kode</th>
<th>Produk</th>
<th>Stok</th>
</tr>

<?php

$tipis = mysqli_query(
$conn,
"
SELECT *
FROM produk
WHERE stok <= stok_minimum
ORDER BY stok ASC
"
);

while($t=mysqli_fetch_assoc($tipis)){

?>

<tr>

<td><?= $t['kode_barang']; ?></td>

<td><?= $t['nama_barang']; ?></td>

<td class="text-danger fw-bold">

<?= $t['stok']; ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>


Aktivitas Hari Ini

</div>

<div class="card-body">

<table class="table">

<tr>

<th>Jam</th>
<th>Produk</th>
<th>Status</th>

</tr>

<?php

$aktivitas = mysqli_query(
$conn,
"
(
SELECT
p.nama_barang,
sk.tanggal,
'Keluar' as status

FROM stok_keluar sk

JOIN produk p
ON p.id=sk.produk_id

WHERE DATE(sk.tanggal)=CURDATE()
)

UNION ALL

(
SELECT
p.nama_barang,
br.tanggal,
'Reject' as status

FROM barang_reject br

JOIN produk p
ON p.id=br.produk_id

WHERE DATE(br.tanggal)=CURDATE()
)

ORDER BY tanggal DESC
LIMIT 20
"
);

while($a=mysqli_fetch_assoc($aktivitas)){

?>

<tr>

<td>

<?= date(
'H:i',
strtotime($a['tanggal'])
); ?>

</td>

<td>

<?= $a['nama_barang']; ?>

</td>

<td>

<?= $a['status']; ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

<div class="mt-3">

<a
href="logout.php"
class="btn btn-danger">

Logout

</a>

</div>

</div>

</body>
</html>