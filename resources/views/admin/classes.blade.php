<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<title>

{{ session('admin_name') }} | Classes & Table Management

</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

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

.full{
    background:#dc3545;
    color:white;
}

.available{
    background:#198754;
    color:white;
}

</style>

</head>

<body>

@include('admin.sidebar')

<div class="content">

    
    <h3>

        Classes & Table Management

    </h3>

    <hr>

    @if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

    @endif

    <div class="card">

        <div class="card-header">

            Classes & Table Management

        </div>

        <div class="card-body">

            <table
            class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>Meja</th>

                        <th>Class</th>

                        <th>Kapasiti</th>

                        <th>Digunakan</th>

                        <th>Baki</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($classes as $class)

                    <tr>

                        <td>

                            {{ $class->table_no }}

                        </td>

                        <td>

                            {{ $class->class_code }}

                        </td>

                        <td>

                            {{ $class->max_pax }}

                        </td>

                        <td>

                            {{ $class->used_pax ?? 0 }}

                        </td>

                        <td>

                            {{ $class->available ?? 0 }}

                        </td>

                        <td>

                            @if($class->available <= 0)

                                <span
                                class="badge bg-danger">

                                    FULL

                                </span>

                            @else

                                <span
                                class="badge bg-success">

                                    AVAILABLE

                                </span>

                            @endif

                        </td>

                        <td>

                            <a
                            href="{{ url('admin/classes/edit/'.$class->id) }}"
                            class="btn btn-warning btn-sm">

                            Edit

                            </a>

                            <a
                            href="{{ url('admin/classes/'.$class->class_code) }}"
                            class="btn btn-primary btn-sm">

                                View Guest

                            </a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>


            </table>
                 <div class="mt-3">
                    {{ $classes->links() }}
                </div>
        </div>

    </div>

</div>

</body>

</html>