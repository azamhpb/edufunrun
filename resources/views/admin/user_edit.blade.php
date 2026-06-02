<!DOCTYPE html>
<html>

<head>
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<title>Edit User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h3>Edit User</h3>

<hr>

<form
method="POST"
action="{{ url('admin/user/edit/'.$user->id) }}">

@csrf

<div class="mb-3">

<label>Nama</label>

<input
type="text"
name="nama"
class="form-control"
value="{{ $user->nama }}"
required>

</div>

<div class="mb-3">

<label>Username</label>

<input
type="text"
name="username"
class="form-control"
value="{{ $user->username }}"
required>

</div>

<div class="mb-3">

<label>Level</label>

<select
name="level"
class="form-control">

<option
value="superadmin"
{{ $user->level=='superadmin'?'selected':'' }}>

Superadmin

</option>

<option
value="supervisor"
{{ $user->level=='supervisor'?'selected':'' }}>

Supervisor

</option>

<option
value="maker"
{{ $user->level=='maker'?'selected':'' }}>

Maker

</option>

</select>

</div>

<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-control">

<option
value="active"
{{ $user->status=='active'?'selected':'' }}>

Active

</option>

<option
value="inactive"
{{ $user->status=='inactive'?'selected':'' }}>

Inactive

</option>

</select>

</div>

<button
class="btn btn-success">

Update User

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