<?php

include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT * FROM produk
WHERE id='$id'"
));

?>

<!DOCTYPE html>
<html>
<head>

<title>Barcode</title>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode/dist/JsBarcode.all.min.js"></script>

</head>

<body>

<center>

<h3>

<?= $data['nama_barang']; ?>

</h3>

<svg id="barcode"></svg>

<p>

<?= $data['kode_barang']; ?>

</p>

<script>

JsBarcode(
"#barcode",
"<?= $data['kode_barang']; ?>",
{
format:"CODE128",
width:2,
height:80,
displayValue:true
}
);

window.print();

</script>

</center>

</body>
</html>