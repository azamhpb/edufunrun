
<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>{{ session('admin_name') }} | User Management</title>
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<style>

body{
    background:#f4f6f9;
}

.sidebar{

    width:250px;
    height:100vh;

    background:#212529;

    position:fixed;

    left:0;
    top:0;

    overflow-y:auto;

    overflow-x:hidden;

}

.sidebar::-webkit-scrollbar{

    width:8px;

}

.sidebar::-webkit-scrollbar-track{

    background:#212529;

}

.sidebar::-webkit-scrollbar-thumb{

    background:#495057;

    border-radius:10px;

}

.sidebar::-webkit-scrollbar-thumb:hover{

    background:#6c757d;

}

.sidebar .logo{

    color:white;

    font-size:22px;

    font-weight:bold;

    padding:20px;

    border-bottom:1px solid rgba(255,255,255,.1);
    background:
    linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
    url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?q=80&w=1920');

}

.sidebar a{

    display:block;

    color:#ddd;

    text-decoration:none;

    padding:14px 20px;

}

.sidebar a:hover{

    background:#343a40;

    color:white;

}

.content{

    margin-left:250px;

    padding:20px;

}

</style>


</head>

<body>


        @include('admin.sidebar')
    

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

@if(session('error'))

<div class="alert alert-danger">

    {{ session('error') }}

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

<a
href="{{ url('admin/user/reset-password/'.$user->id) }}"
class="btn btn-info btn-sm">

Reset Password

</a>

<a
href="{{ url('admin/user/delete/'.$user->id) }}"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete user ini?')">

Delete

</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</body>

</html>