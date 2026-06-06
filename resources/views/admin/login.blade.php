<!DOCTYPE html>
<html>

<head>

<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">

<style>
body{

    background:
    linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
    url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?q=80&w=1920');

    background-size:cover;
    background-position:center;

    min-height:100vh;

    font-family:Arial, sans-serif;

}

.card-login{

    background:rgba(255,255,255,0.08);

    backdrop-filter:blur(10px);

    border:1px solid rgba(255,255,255,0.15);

    border-radius:30px;

    padding:20px;

    box-shadow:0 10px 40px rgba(0,0,0,0.4);

}
</style>


</head>

<body >

<div class="container">

<div class="row justify-content-center mt-5">

        <div class="col-md-4">

        <div class="card-login">

        <div class="card-header text-center">
            <img src="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png" width="150px" height="150px" alt="Logo">
            <hr>
            <h2 style="color:white;"><strong>Sistem Gala Dinner Sabah 2026</strong></h2>
            <hr>

        </div>

        <div class="card-body">

        @if(session('error'))

        <div class="alert alert-danger">

        {{ session('error') }}

        </div>

        @endif

        <form method="POST" action="{{ url('admin/login') }}">

        @csrf

        <div class="mb-3">

        <input
        type="text"
        name="username"
        class="form-control"
        placeholder="Username"
        required>

        </div>

        <div class="mb-3">

        <input
        type="password"
        name="password"
        class="form-control"
        placeholder="Password"
        required>

        </div>

        <button
        class="btn btn-primary w-100">

        LOGIN

        </button>

        </form>

        <div class="card-footer text-center">
            <hr>
            <small style="color:white;">&copy; 2026 Yayasan ANGKASA</small>
        </div>



        </div>

        </div>

        </div>

        </div>

</div>

</body>
</html>