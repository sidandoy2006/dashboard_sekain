<?php

session_start();

include 'config/koneksi.php';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM user
        WHERE username='$username'
        AND password='$password'"
    );

    if(mysqli_num_rows($query) > 0){

        $user = mysqli_fetch_assoc($query);

        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if($user['role'] == "admin"){

            header("Location: admin/dashboard.php");

        }else{

            header("Location: staff/dashboard.php");

        }

    }else{

        $error = "Username atau Password Salah";

    }

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Login Gudang Sekain</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body style="background:#f5f6fa;">

<div class="container">

<div class="row justify-content-center">

<div class="col-md-4 mt-5">

<div class="card shadow">

<div class="card-body">

<h3 class="text-center mb-4">

Gudang Sekain

</h3>

<?php if(isset($error)){ ?>

<div class="alert alert-danger">

<?= $error ?>

</div>

<?php } ?>

<form method="POST">

<input
type="text"
name="username"
class="form-control mb-3"
placeholder="Username">

<input
type="password"
name="password"
class="form-control mb-3"
placeholder="Password">

<button
name="login"
class="btn btn-primary w-100">

Login

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>
</html>