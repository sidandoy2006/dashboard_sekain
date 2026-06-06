<?php

session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
}

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT * FROM produk
WHERE id='$id'"
));

function generateKode($nama,$warna,$ukuran){

    $nama = strtoupper(trim($nama));

    $kata = explode(" ",$nama);

    if(count($kata)==1){

        $kodeNama =
        preg_replace('/[^A-Z0-9]/','',$kata[0]);

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
if(isset($_POST['update'])){

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
    UPDATE produk
    SET
    kode_barang='$kode',
    nama_barang='$nama',
    warna='$warna',
    ukuran='$ukuran',
    stok='$stok',
    stok_minimum='$stok_minimum'
    WHERE id='$id'
    "
    );

    header("Location: produk.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Produk</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<a href="produk.php"
class="btn btn-secondary mb-3">

← Kembali

</a>

<h2>Edit Produk</h2>

<form method="POST">

<input
type="text"
name="nama"
class="form-control mb-2"
value="<?= $data['nama_barang']; ?>">

<input
type="text"
name="warna"
class="form-control mb-2"
value="<?= $data['warna']; ?>">

<input
type="text"
name="ukuran"
class="form-control mb-2"
value="<?= $data['ukuran']; ?>">

<input
type="number"
name="stok"
class="form-control mb-2"
value="<?= $data['stok']; ?>">

<input
type="number"
name="stok_minimum"
class="form-control mb-2"
value="<?= $data['stok_minimum']; ?>">

<button
name="update"
class="btn btn-primary">

Update

</button>

</form>

</div>

</body>
</html>