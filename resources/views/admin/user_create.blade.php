<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>Tambah User</title>
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h3>Tambah User</h3>

<hr>

<form
method="POST"
action="{{ url('admin/user/create') }}">

@csrf

<div class="mb-3">

<label>Nama</label>

<input
type="text"
name="nama"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Username</label>

<input
type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Level</label>

<select
name="level"
class="form-control">

<option value="superadmin">
    Superadmin
</option>

<option value="supervisor">
    Supervisor
</option>

<option value="maker">
    Maker
</option>

</select>

</div>

<button
class="btn btn-success">

Simpan User

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