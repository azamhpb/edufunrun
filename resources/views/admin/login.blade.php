<!DOCTYPE html>
<html>

<head>

<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
</head>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-4">

<div class="card shadow">

<div class="card-header text-center">

<h4>Admin Login</h4>

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

</div>

</div>

</div>

</div>

</div>

</body>
</html>