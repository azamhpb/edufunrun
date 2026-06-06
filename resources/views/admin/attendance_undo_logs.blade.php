<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<title>Attendance Undo Logs</title>

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

<h3>

Attendance Undo Logs

</h3>

<hr>

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>ID</th>

<th>Nama</th>

<th>Company</th>

<th>Undo By</th>

<th>Reason</th>

<th>Time</th>

</tr>

</thead>

<tbody>

@foreach($logs as $row)

<tr>

<td>

{{ $row->id }}

</td>

<td>

{{ $row->nama }}

</td>

<td>

{{ $row->company }}

</td>

<td>

{{ $row->undo_by }}

</td>

<td>

{{ $row->undo_reason }}

</td>

<td>

{{ $row->created_at }}

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</body>

</html>