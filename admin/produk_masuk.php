<?php

session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
}

if(isset($_POST['simpan'])){

    $produk_id = $_POST['produk_id'];
    $jumlah = $_POST['jumlah'];

    mysqli_query(
    $conn,
    "
    INSERT INTO stok_masuk
    (
    produk_id,
    jumlah
    )
    VALUES
    (
    '$produk_id',
    '$jumlah'
    )
    ");

    mysqli_query(
    $conn,
    "
    UPDATE produk
    SET stok = stok + $jumlah
    WHERE id='$produk_id'
    ");

    echo "
    <script>
    alert('Stok berhasil ditambahkan');
    location='produk_masuk.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Stok Masuk</title>

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

<h2>Stok Masuk</h2>

<form method="POST">

<label>Produk</label>

<select
name="produk_id"
class="form-control mb-3"
required>

<option value="">
Pilih Produk
</option>

<?php

$produk = mysqli_query(
$conn,
"SELECT * FROM produk
ORDER BY nama_barang ASC"
);

while($p=mysqli_fetch_assoc($produk)){

?>

<option value="<?= $p['id']; ?>">

<?= $p['kode_barang']; ?>

-

<?= $p['nama_barang']; ?>

(

Stok:
<?= $p['stok']; ?>

)

</option>

<?php } ?>

</select>

<label>Jumlah Masuk</label>

<input
type="number"
name="jumlah"
class="form-control mb-3"
required>

<button
name="simpan"
class="btn btn-success">

Simpan Stok Masuk

</button>

</form>

<hr>

<h4>Riwayat Stok Masuk</h4>

<table class="table table-bordered">

<tr>

<th>Tanggal</th>
<th>Kode</th>
<th>Produk</th>
<th>Jumlah</th>

</tr>

<?php

$data = mysqli_query(
$conn,
"
SELECT
sm.*,
p.kode_barang,
p.nama_barang

FROM stok_masuk sm

JOIN produk p
ON p.id = sm.produk_id

ORDER BY sm.id DESC
"
);

while($d=mysqli_fetch_assoc($data)){

?>

<tr>

<td>

<?= date(
'd-m-Y H:i',
strtotime($d['tanggal'])
); ?>

</td>

<td>

<?= $d['kode_barang']; ?>

</td>

<td>

<?= $d['nama_barang']; ?>

</td>

<td>

<?= $d['jumlah']; ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>