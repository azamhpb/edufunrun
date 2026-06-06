<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<title>Guest Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>


.diamond{

    color:#111;

    background:linear-gradient(
        135deg,
        #e7aa51,
        #ffe499,
        #8d5a1b,
        #e7aa51,
        #ac7031
    );

}

.platinum{

    color:#111;

    background:linear-gradient(
        135deg,
        #858489,
        #e7e4ef,
        #858489,
        #b9b9b9,
        #858489
    );

}

.gold{

    color:#fff;

    background:linear-gradient(
        135deg,
        #785c3a,
        #e2c29a,
        #785c3a,
        #ac8e68,
        #785c3a
    );

}

.silver{

    color:#fff;

    background:linear-gradient(
        135deg,
        #013e6a,
        #43d1ff,
        #013e6a,
        #419ad6,
        #01186a
    );

}



.blank{

    color:#fff;

    background:linear-gradient(
        135deg,
        #000000,
        #000000,
        #013e6a,
        #419ad6,
        #01186a
    );

}



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

.stat-card{

    border:none;

    border-radius:15px;

    box-shadow:0 2px 10px rgba(0,0,0,.08);

}

.stat-number{

    font-size:28px;

    font-weight:bold;

}

</style>

</head>

<body>


    @include('admin.sidebar')


<div class="content">

    <h3>Guest Management</h3>

    <hr>

    <div class="row">

        <div class="col-md-3">

            <div class="card stat-card">

                <div class="card-body">

                    <div class="text-muted">

                        Total Guest

                    </div>

                    <div class="stat-number">

                        {{ $totalGuest }}

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card stat-card">

                <div class="card-body">

                    <div class="text-muted">

                        Checked In

                    </div>

                    <div class="stat-number">

                        {{ $checkedIn }}

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card stat-card">

                <div class="card-body">

                    <div class="text-muted">

                        Pending

                    </div>

                    <div class="stat-number">

                        {{ $pending }}

                    </div>

                </div>

            </div>

        </div>

    </div>

    <br>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search Nama / Company / Attendance ID"
                        value="{{ request('search') }}">

                    </div>

                    <div class="col-md-3">

                        <select
                        name="class"
                        class="form-control">

                            <option value="">
                                Semua Class
                            </option>

                            @foreach($classes as $class)

                                @php

                                    $used = DB::table('guests')
                                        ->where(
                                            'class_code',
                                            $class->class_code
                                        )
                                        ->count();

                                    $available =
                                        $class->max_pax - $used;

                                @endphp

                                <option
                                value="{{ $class->class_code }}"
                                {{ request('class')==$class->class_code ? 'selected' : '' }}>

                                    {{ $class->class_code }}

                                    ( {{ $available }} / {{ $class->max_pax }} )

                                    {{ $available <= 0 ? '- FULL' : '' }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2">

                        <button
                        class="btn btn-primary">

                            Search

                        </button>

                    </div>

                    <div class="col-md-3 text-end">

                        <a
                        href="{{ url('admin/guest/create') }}"
                        class="btn btn-success">

                            Tambah Tetamu

                        </a>

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
                        <th>No Telefon</th>
                        <th>Class</th>
                        <th>Meja</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($guests as $guest)

                    <tr>

                        <td>{{ $guest->id }}</td>

                        <td>{{ $guest->attendance_id }}</td>

                        <td>{{ $guest->nama }}</td>

                        <td>{{ $guest->company }}</td>

                        <td>{{ $guest->phone_no }}</td>

                        
                        <td>
                        @php

                        $classCss = 'blank';

                        if(str_starts_with($guest->class_code,'DIAMOND'))
                        {
                            $classCss = 'diamond';
                        }
                        elseif(str_starts_with($guest->class_code,'PLATINUM'))
                        {
                            $classCss = 'platinum';
                        }
                        elseif(str_starts_with($guest->class_code,'GOLD'))
                        {
                            $classCss = 'gold';
                        }
                        elseif(str_starts_with($guest->class_code,'SILVER'))
                        {
                            $classCss = 'silver';
                        }

                        @endphp

                        <span class="badge {{ $classCss }}">

                            {{ $guest->class_code }}

                        </span>
                        </td>


                        


                        <td>{{ $guest->table_no }}</td>

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

                        <td>

                            <a
                            href="{{ url('admin/guest/edit/'.$guest->id) }}"
                            class="btn btn-warning btn-sm">

                                Edit

                            </a>
                            <a
                            href="{{ url('admin/guest/delete/'.$guest->id) }}"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Padam tetamu ini?')">

                            Delete

                            </a>
                            <a href="{{ url('card/'.$guest->qr_token) }}"
                            target="_blank"
                            class="btn btn-primary btn-sm">

                                Card

                            </a>
                            @php

                                $message =
                                "Assalamualaikum dan Salam Sejahtera.\n\n".
                                "Jemputan *Majlis Makan Malam Gala Sabah 2026*.\n\n".
                                "Nama*: ".$guest->nama."*\n".
                                "Kategori_: ".$guest->class_code."_\n".
                                "Meja: _".$guest->table_no."_\n\n".
                                "Kad Jemputan:\n".
                                url('card/'.$guest->qr_token);

                                @endphp

                                <a
                                href="https://wa.me/6{{ $guest->phone_no }}?&text={{ urlencode($message) }}"
                                target="_blank"
                                class="btn btn-success btn-sm">

                                WhatsApp

                                </a>

                                <a
                                href="{{ url('admin/guest/sms/'.$guest->id) }}"
                                class="btn btn-info btn-sm"
                                onclick="return confirm('Hantar SMS kepada tetamu ini?')">

                                SMS

                                </a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            {{ $guests->withQueryString()->links() }}

        </div>

    </div>

</div>

</body>
</html>