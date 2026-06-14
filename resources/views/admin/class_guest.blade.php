
<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>{{ $class_code }}</title>
 <link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
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

<div
style="margin-left:250px;padding:20px;">

    <h3>

        <strong> {{ $class_code }} </strong> | MEJA  : {{ $tabledb -> table_no }} (MAX {{ $tabledb -> max_pax }} PAX)

    </h3>

    <hr>

    <div class="card">

        <div class="card-header">

            {{ $class_code }}

            ({{ $guests->count() }} Tetamu)

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Attendance ID</th>
                        <th>Nama</th>
                        <th>Company</th>
                        <th>Telefon</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($guests as $guest)

                    <tr>

                        <td>
                            {{ $guest->attendance_id }}
                        </td>

                        <td>
                            {{ $guest->nama }}
                        </td>

                        <td>
                            {{ $guest->company }}
                        </td>

                        <td>
                            {{ $guest->phone_no }}
                        </td>

                        <td>

                            @if($guest->checkin_status=='checked_in')

                                <span class="badge bg-success">

                                    CHECKED IN

                                </span>

                            @else

                                <span class="badge bg-warning">

                                    PENDING

                                </span>

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>