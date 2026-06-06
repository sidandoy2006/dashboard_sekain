<?php

session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
}

function generateKode($nama,$warna,$ukuran){

    $nama = strtoupper(trim($nama));

    $kata = explode(" ",$nama);

    if(count($kata)==1){

        $kodeNama = preg_replace('/[^A-Z0-9]/','',$kata[0]);

    }elseif(count($kata)==2){

        $kodeNama =
        substr($kata[0],0,1).
        substr($kata[1],0,1);

    }else{

        $kodeNama='';

        foreach($kata as $k){
            if($k!=''){
                $kodeNama .= substr($k,0,1);
            }
        }
    }

    return strtoupper(
        $kodeNama."-".$warna."-".$ukuran
    );
}

if(isset($_POST['simpan'])){

    $nama = strtoupper($_POST['nama']);
    $warna = strtoupper($_POST['warna']);
    $ukuran = strtoupper($_POST['ukuran']);

    $stok = $_POST['stok'];
    $stok_minimum = $_POST['stok_minimum'];

    $kode = generateKode(
        $nama,
        $warna,
        $ukuran
    );

    mysqli_query(
    $conn,
    "
    INSERT INTO produk
    (
    kode_barang,
    nama_barang,
    warna,
    ukuran,
    stok,
    stok_minimum
    )
    VALUES
    (
    '$kode',
    '$nama',
    '$warna',
    '$ukuran',
    '$stok',
    '$stok_minimum'
    )
    ");
}

$cari = "";

if(isset($_GET['cari'])){
    $cari = $_GET['cari'];
}

?>
<!DOCTYPE html>
<html>
<head>

<title>Produk</title>

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

<h2>Data Produk</h2>

<form method="POST">

<input
type="text"
name="nama"
class="form-control mb-2"
placeholder="Nama Produk"
required>

<input
type="text"
name="warna"
class="form-control mb-2"
placeholder="Warna"
required>

<input
type="text"
name="ukuran"
class="form-control mb-2"
placeholder="Ukuran"
required>

<input
type="number"
name="stok"
class="form-control mb-2"
placeholder="Stok Awal"
required>

<input
type="number"
name="stok_minimum"
class="form-control mb-2"
placeholder="Stok Minimum"
required>

<button
name="simpan"
class="btn btn-primary">

Simpan Produk

</button>

</form>

<hr>
<form method="GET">

<input
type="text"
name="cari"
class="form-control mb-3"
placeholder="Cari Produk">

</form>
<table class="table table-bordered">

<tr>

<th>Kode</th>
<th>Nama</th>
<th>Warna</th>
<th>Ukuran</th>
<th>Stok</th>
<th>Minimum</th>
<th>Aksi</th>

</tr>

<?php

$data = mysqli_query(
$conn,
"
SELECT *
FROM produk

WHERE

nama_barang LIKE '%$cari%'
OR kode_barang LIKE '%$cari%'

ORDER BY id DESC
"
);

while($d=mysqli_fetch_assoc($data)){

?>

<tr>

<td>
<?= $d['kode_barang']; ?>
</td>

<td>
<?= $d['nama_barang']; ?>
</td>

<td>
<?= $d['warna']; ?>
</td>

<td>
<?= $d['ukuran']; ?>
</td>

<td>

<?php

if(
$d['stok']
<=
$d['stok_minimum']
){

echo
"<span class='text-danger fw-bold'>
".$d['stok']."
</span>";

}else{

echo $d['stok'];

}

?>

</td>

<td>
<?= $d['stok_minimum']; ?>
</td>

<td>

<a
href="edit_produk.php?id=<?= $d['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="hapus_produk.php?id=<?= $d['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Hapus produk?')">

Hapus

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>