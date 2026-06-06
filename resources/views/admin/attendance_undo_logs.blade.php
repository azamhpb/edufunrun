<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Attendance Undo Logs</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<style>

body{
    background:#f4f6f9;
}

.sidebar{

    width:250px;
    min-height:100vh;

    background:#212529;

    position:fixed;

    left:0;
    top:0;

}

.sidebar .logo{

    color:white;

    font-size:22px;

    font-weight:bold;

    padding:20px;

    border-bottom:1px solid rgba(255,255,255,.1);

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