<?php

session_start();

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
}

?>


<!DOCTYPE html>
<html>
<head>

<title>Dashboard Staff</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{
    background-image:
    linear-gradient(
        rgba(0,0,0,.25),
        rgba(0,0,0,.25)
    ),
    url('../assets/img/background6.jpeg');

    background-size: cover;
background-position: center 30%;
    background-repeat:no-repeat;
    background-attachment:fixed;
}

.main-card{

    max-width:900px;

    margin:40px auto;

    background:rgba(255,255,255,0.15);

    color:white;

    border:1px solid rgba(255,255,255,0.2);

    backdrop-filter:blur(10px);

    border-radius:25px;

    padding:30px;
}

.logo{
    width:120px;
}

</style>

</head>
<body>
    

<div class="container">

<div class="main-card">

<div class="text-center">

<img
src="../assets/img/logo.png"
class="logo">


</div>

<div class="row mt-4">

<div class="col-md-6 mb-3">

<a
href="keluar.php"
class="btn btn-picking w-100 menu-btn">

📦<br>
Picking Barang

</a>

</div>

<div class="col-md-6 mb-3">

<a
href="reject.php"
class="btn btn-reject w-100 menu-btn">

❌<br>
Barang Reject

</a>

</div>

</div>

<div class="card mt-3">

<div class="card-body text-center">

Selamat Datang

<br>

<b>


</b>

</div>

</div>

<a
href="logout.php"
class="btn btn-dark w-100 mt-3">

Logout

</a>

</div>

</div>
</body>
</html>