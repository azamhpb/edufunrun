<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<title>Attendance Management</title>

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

<div class="content">

    <h3>

        Attendance Management

    </h3>

    <hr>

    @if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

    @endif

    <div class="card">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-6">

                        <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search Nama / Company / Attendance ID / Meja"
                        value="{{ request('search') }}">

                    </div>

                    <div class="col-md-2">

                        <button
                        class="btn btn-primary">

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <br>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Attendance ID</th>
                        <th>Nama</th>
                        <th>Company</th>
                        <th>Class</th>
                        <th>Meja</th>
                        <th>Scanner</th>
                        <th>Scan Time</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($attendance as $row)

                    <tr>

                        <td>

                            {{ $row->id }}

                        </td>

                        <td>

                            {{ $row->attendance_id }}

                        </td>

                        <td>

                            {{ $row->nama }}

                        </td>

                        <td>

                            {{ $row->company }}

                        </td>

                        <td>

                            {{ $row->class_code }}

                        </td>

                        <td>

                            {{ $row->table_no }}

                        </td>

                        <td>

                            {{ $row->scanner_id }}

                        </td>

                        <td>

                            {{ $row->scan_time }}

                        </td>

                        <td>

                            <form
                            method="POST"
                            action="{{ url('admin/attendance/undo/'.$row->id) }}"
                            onsubmit="return confirm('Undo check in ini?')">

                                @csrf

                                <button
                                class="btn btn-danger btn-sm">

                                    Undo

                                </button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            {{ $attendance->withQueryString()->links() }}

        </div>

    </div>

</div>

</body>

</html>