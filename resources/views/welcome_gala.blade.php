<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<meta name="viewport"
content="width=device-width, initial-scale=1">
<meta name="description" content="Portal Rasmi Gala Dinner Sabah 2026 anjuran Yayasan ANGKASA. Semak jemputan, nombor meja, aturcara majlis, lokasi dan maklumat terkini acara.">

<meta name="keywords" content="Gala Dinner Sabah 2026, Yayasan ANGKASA, Makan Malam Gala, Sabah, Jemputan, QR Attendance, Check In Tetamu">

<meta name="author" content="Yayasan ANGKASA">

<meta property="og:title" content="Gala Dinner Sabah 2026">

<meta property="og:description" content="Portal Rasmi Gala Dinner Sabah 2026. Semak maklumat jemputan, nombor meja, aturcara majlis dan lokasi acara.">

<meta property="og:type" content="website">

<meta property="og:image" content="{{ asset('img/logo-gala.png') }}">

<meta property="og:url" content="{{ url()->current() }}">

<meta name="twitter:card" content="summary_large_image">

<meta name="twitter:title" content="Gala Dinner Sabah 2026">

<meta name="twitter:description" content="Portal Rasmi Gala Dinner Sabah 2026 anjuran Yayasan ANGKASA.">

<meta name="twitter:image" content="{{ asset('img/logo-gala.png') }}">

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

/* ======================================================== */
/* KOD AUTO-SIZE DIPERBAIKI (ASINGKAN LOGO & POSTER DI PHONE)*/
/* ======================================================== */
@media (max-width: 768px) {
    .title {
        font-size: 32px; /* Kecilkan teks tajuk di phone */
    }
    
    .subtitle {
        font-size: 18px; /* Kecilkan subtitle di phone */
    }

    .box {
        padding: 10px; /* Lebarkan ruang untuk poster */
    }

    /* CARA BARU: Sasarkan imej pertama dalam kotak (Khusus untuk LOGO sahaja) */
    .box > img:first-of-type {
        width: 100px !important; /* Kekal kecil 100px di phone, tidak terikut besar */
    }

    /* Sasarkan imej yang ada class img-fluid (Khusus untuk POSTER sahaja) */
    .box .img-fluid {
        width: 100% !important; /* Dipaksa lebar penuh di phone */
        max-width: 100% !important;
        padding: 10px !important; /* Kurangkan padding dalam border poster */
        border-radius: 15px !important; /* Kemaskan bucu border poster */
    }
}

</style>

</head>

<body>

<div class="box">


<!-- URL Logo Yayasan Angkasa kekal di sini -->
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
    max-width:800px;
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
