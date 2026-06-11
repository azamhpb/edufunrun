<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>

Gala Dinner Sabah 2026

</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{

    margin:0;

    min-height:100vh;

    background:
    linear-gradient(
        rgba(0,0,0,.75),
        rgba(0,0,0,.75)
    ),
    url('{{ asset("img/bg.png") }}');

    background-position:center;
    background-repeat:no-repeat;
    background-size:cover;
    background-attachment: fixed;

    display:flex;
    justify-content:center;
    align-items:center;

    color:white;

}

.box{

    text-align:center;

    padding:30px;

    border-radius:25px;

}

.title{

    font-size:60px;

    font-weight:bold;

}

.subtitle{

    font-size:24px;

    margin-bottom:30px;

}

/* BAHARU: Kod Auto-Size untuk Mobile dan Tablet */
@media (max-width: 768px) {
    .title {
        font-size: 35px; /* Saiz teks lebih kecil untuk phone & tablet */
    }
    
    .subtitle {
        font-size: 18px; /* Saiz subtitle lebih kecil untuk phone & tablet */
    }

    .box {
        padding: 15px; /* Kurangkan padding kotak di skrin kecil */
    }

    .box > img {
        width: 100px !important; /* Logo yayasan lebih kecil di skrin kecil */
    }
}

</style>

</head>

<body>

<div class="box">

<img
src="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png"
width="150"
style="filter:drop-shadow(0 0 15px rgba(255,255,255,.3));"
class="mb-4">


    <h1 class="title">

        Gala Dinner Sabah 2026

    </h1>

    <img
    src="{{ asset('img/poster-2026-06-11.png') }}"
    class="img-fluid mb-4"
    style="
    backdrop-filter:blur(10px);

    border:1px solid rgba(255,255,255,0.15);

    border-radius:30px;

    padding:20px;

    box-shadow:0 10px 40px rgba(0,0,0,0.4);
    ">

    

    <p class="subtitle">

        Yayasan ANGKASA

    </p>

    <a
    href="{{ url('/admin/login') }}"
    class="btn btn-warning btn-lg">

        Login Admin

    </a>

</div>

</body>

</html>
