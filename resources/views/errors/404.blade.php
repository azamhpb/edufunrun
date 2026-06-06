<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>404 - Page Not Found</title>
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{

    background:
    linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
    url('https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=1974');

    display:flex;

    justify-content:center;

    align-items:center;

    height:100vh;

    font-family:Arial;
    

}

.box{

    text-align:center;

    background:rgba(255,255,255,0.08);

    backdrop-filter:blur(10px);

    border:1px solid rgba(255,255,255,0.15);

    border-radius:30px;

    padding:20px;

    box-shadow:0 10px 40px rgba(0,0,0,0.4);

}

.error-code{

    font-size:120px;

    font-weight:bold;

    color:#dc3545;

}

</style>

</head>

<body>

<div class="box">


    
    <img src="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png" width="150px" height="150px" alt="Logo">
    

    <div class="error-code">

        404

    </div>

    <h2 style="color:white;">

        Halaman Tidak Dijumpai

    </h2>

    <p style="color:white;">

        URL yang anda akses tidak wujud.

    </p>

    <a
    href="{{ url('/') }}"
    class="btn btn-primary">

        Kembali ke Laman Utama

    </a>

</div>

</body>

</html>