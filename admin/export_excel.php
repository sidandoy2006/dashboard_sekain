<?php

session_start();
include '../config/koneksi.php';

header("Content-Type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Gudang_".date('Ymd').".xls");

?>

<table border="1">

<tr>
    <th colspan="5">
        LAPORAN GUDANG SEKAIN
    </th>
</tr>

<tr>
    <th>Tanggal</th>
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Jumlah</th>
    <th>Status</th>
</tr>

<?php

$keluar = mysqli_query(
$conn,
"
SELECT
sk.tanggal,
p.kode_barang,
p.nama_barang,
sk.jumlah,
'Keluar' as status

FROM stok_keluar sk

JOIN produk p
ON p.id = sk.produk_id
"
);

while($k=mysqli_fetch_assoc($keluar)){

?>

<tr>
    <td><?= $k['tanggal']; ?></td>
    <td><?= $k['kode_barang']; ?></td>
    <td><?= $k['nama_barang']; ?></td>
    <td><?= $k['jumlah']; ?></td>
    <td><?= $k['status']; ?></td>
</tr>

<?php } ?>

<?php

$reject = mysqli_query(
$conn,
"
SELECT
br.tanggal,
p.kode_barang,
p.nama_barang,
br.jumlah,
'Reject' as status

FROM barang_reject br

JOIN produk p
ON p.id = br.produk_id
"
);

while($r=mysqli_fetch_assoc($reject)){

?>

<tr>
    <td><?= $r['tanggal']; ?></td>
    <td><?= $r['kode_barang']; ?></td>
    <td><?= $r['nama_barang']; ?></td>
    <td><?= $r['jumlah']; ?></td>
    <td><?= $r['status']; ?></td>
</tr>

<?php } ?>

</table>