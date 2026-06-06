
<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<title>Admin Dashboard</title>

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

.topbar{

    background:white;

    border-radius:10px;

    padding:15px 20px;

    box-shadow:0 2px 10px rgba(0,0,0,.08);

}

.stat-card{

    border:none;

    border-radius:15px;

    box-shadow:0 2px 10px rgba(0,0,0,.08);

}

.stat-number{

    font-size:32px;

    font-weight:bold;

}

</style>

</head>

<body>


@include('admin.sidebar')

<div class="content">

    <div class="topbar">

        <div class="row">

            <div class="col-md-6">

                <h4>

                    Selamat Datang,
                    {{ session('admin_name') }}

                </h4>

            </div>

            <div class="col-md-6 text-end">

                <span class="badge bg-primary">

                    {{ strtoupper(session('admin_level')) }}

                </span>

            </div>

        </div>

    </div>

    <br>

    <div class="row">

        <div class="col-md-3">

            <div class="card stat-card">

                <div class="card-body">

                    <div class="text-muted">
                        Tetamu Hadir
                    </div>

                    <div
                        class="stat-number"
                        id="attendanceToday">

                        0

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card stat-card">

                <div class="card-body">

                    <div class="text-muted">
                        Belum Check In
                    </div>

                    <div
                        class="stat-number"
                        id="totalAttendance">

                        0

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card stat-card">

                <div class="card-body">

                    <div class="text-muted">
                        Jumlah Tetamu
                    </div>

                    <div class="stat-number" id="totalGuest">

                        0

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card stat-card">

                <div class="card-body">

                    <div class="text-muted">
                        Progress
                    </div>

                    <div class="stat-number" id="attendancePercent">

                        0%

                    </div>

                </div>

            </div>

        </div>

    </div>

    <br>

        <div class="card">

            <div class="card-header">

                Progress Kehadiran

            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between mb-2">

                    <span>

                        Tetamu Hadir

                    </span>

                    <span id="progressText">

                        0 / 0

                    </span>

                </div>

                <div
                class="progress"
                style="height:30px;">

                    <div
                    id="progressBar"
                    class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                    role="progressbar"
                    style="width:0%">

                        0%

                    </div>

                </div>

            </div>

        </div>

        <hr>

        

    <div class="card">

        <div class="card-header">

            Dashboard Overview

        </div>

        <div class="card-body">

            Sistem QR Attendance
            berjaya login sebagai

            <b>{{ session('admin_name') }}</b>

            dengan level

            <b>{{ session('admin_level') }}</b>

        </div>

    </div>
    <hr>
                <div class="card">

                <div class="card-header">

                    Latest Scan

                </div>

                <div class="card-body">

                    <h3 id="latestName">

                        Menunggu Scan...

                    </h3>

                    <p id="latestInfo"></p>

                </div>

            </div>






<script>

function loadAttendance(){

    fetch('{{ url("admin/live-attendance") }}')

    .then(response => response.json())

    .then(data => {

        document.getElementById(
            'attendanceToday'
        ).innerHTML =
        data.attendanceToday;

        document.getElementById(
            'totalAttendance'
        ).innerHTML =
        data.totalAttendance;

        document.getElementById(
            'totalGuest'
        ).innerHTML =
        data.totalGuest;

        let totalGuest =
        parseInt(data.totalGuest);

        let hadir =
        parseInt(data.attendanceToday);

        let percent = 0;

        if(totalGuest > 0)
        {

            percent =
            Math.round(
                (hadir / totalGuest) * 100
            );

        }

        document.getElementById(
            'attendancePercent'
        ).innerHTML =
        percent + '%';

        document.getElementById(
            'progressText'
        ).innerHTML =

            hadir +

            ' / ' +

            totalGuest;

        document.getElementById(
            'progressBar'
        ).style.width =

            percent + '%';

        document.getElementById(
            'progressBar'
        ).innerHTML =

            percent + '%';

        if(data.latest)
        {

            document.getElementById(
                'latestName'
            ).innerHTML =
            data.latest.nama;

            document.getElementById(
                'latestInfo'
            ).innerHTML =

                data.latest.class_code +

                ' | MEJA ' +

                data.latest.table_no;

        }

    });

}

loadAttendance();

setInterval(
    loadAttendance,
    1000
);
</script>


</body>

</html>

