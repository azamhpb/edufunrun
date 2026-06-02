
<!DOCTYPE html>
<html>

<head>
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<title>User Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h3>User Management</h3>

<hr>

<a
href="{{ url('admin/dashboard') }}"
class="btn btn-secondary mb-3">

Dashboard

</a>

<a
href="{{ url('admin/user/create') }}"
class="btn btn-primary mb-3">

Tambah User

</a>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif


<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>
<th>Nama</th>
<th>Username</th>
<th>Level</th>
<th>Status</th>
<th>Action</th>

</tr>

</thead>

<tbody>

@foreach($users as $user)

<tr>

<td>{{ $user->id }}</td>

<td>{{ $user->nama }}</td>

<td>{{ $user->username }}</td>

<td>

<span class="badge bg-primary">

{{ strtoupper($user->level) }}

</span>

</td>

<td>

@if($user->status=='active')

<span class="badge bg-success">

ACTIVE

</span>

@else

<span class="badge bg-danger">

INACTIVE

</span>

@endif

</td>

<td>

<a
href="{{ url('admin/user/edit/'.$user->id) }}"
class="btn btn-warning btn-sm">

Edit

</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</body>

</html>