<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>{{ $user->username }} | Reset Password</title>
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h3>Reset Password User</h3>

<hr>

<form
method="POST"
action="{{ url('admin/user/reset-password/'.$user->id) }}">

@csrf

<div class="mb-3">

<label>Nama</label>

<input
type="text"
class="form-control"
value="{{ $user->nama }}"
readonly>

</div>

<div class="mb-3">

<label>Username</label>

<input
type="text"
class="form-control"
value="{{ $user->username }}"
readonly>

</div>

<div class="mb-3">

<label>Password Baru</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
class="btn btn-success">

Reset Password

</button>

<a
href="{{ url('admin/user') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</body>

</html>