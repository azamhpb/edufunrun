<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>

Floor Plan View

</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

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


body{
    background:#f4f6f9;
}

.content{
    margin-left:250px;
    padding:20px;
}

.map-container{

    position:relative;

    width:1000px;

    margin:auto;

}

.map-container img{

    width:100%;

}

.table-dot{

    position:absolute;

    width:42px;
    height:42px;

    border-radius:50%;

    color:white;

    text-decoration:none;

    text-align:center;

    line-height:42px;

    font-size:12px;

    font-weight:bold;

    border:2px solid white;

}

.vip-table{

    position:absolute;

    width:42px;
    height:140px;

    color:black;

    text-decoration:none;

    font-size:14px;

    font-weight:bold;

    border:2px solid #c86a2c;

    background:white;

    display:flex;

    justify-content:center;

    align-items:center;

    clip-path: polygon(
        0% 10%,
        25% 0%,
        75% 0%,
        100% 10%,

        100% 90%,
        75% 100%,
        25% 100%,
        0% 90%
    );

}


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


.table-1   { left:692px; top:681px; }
.table-2   { left:692px; top:628px; }
.table-3   { left:692px; top:577px; }
.table-4   { left:692px; top:523px; }
.table-5   { left:692px; top:473px; }
.table-6   { left:692px; top:0px; }
.table-7   { left:692px; top:0px; }
.table-8   { left:692px; top:0px; }
.table-9   { left:692px; top:0px; }
.table-10  { left:692px; top:0px; }

.table-11  { left:692px; top:0px; }
.table-12  { left:692px; top:0px; }
.table-13  { left:0px; top:0px; }
.table-14  { left:0px; top:0px; }
.table-15  { left:0px; top:0px; }
.table-16  { left:0px; top:0px; }
.table-17  { left:0px; top:0px; }
.table-18  { left:0px; top:0px; }
.table-19  { left:0px; top:0px; }
.table-20  { left:0px; top:0px; }

.table-21  { left:0px; top:0px; }
.table-22  { left:0px; top:0px; }
.table-23  { left:0px; top:0px; }
.table-24  { left:0px; top:681px; }
.table-25  { left:0px; top:681px; }
.table-26  { left:0px; top:0px; }
.table-27  { left:0px; top:0px; }
.table-28  { left:0px; top:0px; }
.table-29  { left:0px; top:0px; }
.table-30  { left:0px; top:0px; }

.table-31  { left:0px; top:0px; }
.table-32  { left:0px; top:0px; }
.table-33  { left:0px; top:0px; }
.table-34  { left:0px; top:0px; }
.table-35  { left:0px; top:0px; }
.table-36  { left:0px; top:0px; }
.table-37  { left:0px; top:0px; }
.table-38  { left:0px; top:0px; }
.table-39  { left:0px; top:0px; }
.table-40  { left:0px; top:0px; }

.table-41  { left:0px; top:0px; }
.table-42  { left:0px; top:0px; }
.table-43  { left:0px; top:0px; }
.table-44  { left:0px; top:0px; }
.table-45  { left:0px; top:0px; }
.table-46  { left:0px; top:0px; }
.table-47  { left:0px; top:0px; }
.table-48  { left:0px; top:681px; }
.table-49  { left:0px; top:681px; }
.table-50  { left:0px; top:0px; }

.table-51  { left:0px; top:0px; }
.table-52  { left:0px; top:0px; }
.table-53  { left:0px; top:0px; }
.table-54  { left:0px; top:0px; }
.table-55  { left:0px; top:0px; }
.table-56  { left:0px; top:0px; }
.table-57  { left:0px; top:0px; }
.table-58  { left:0px; top:0px; }
.table-59  { left:0px; top:0px; }
.table-60  { left:0px; top:0px; }

.table-61  { left:0px; top:0px; }
.table-62  { left:0px; top:0px; }
.table-63  { left:0px; top:0px; }
.table-64  { left:0px; top:0px; }
.table-65  { left:0px; top:0px; }
.table-66  { left:0px; top:0px; }
.table-67  { left:0px; top:0px; }
.table-68  { left:0px; top:0px; }
.table-69  { left:0px; top:0px; }
.table-70  { left:0px; top:0px; }

.table-71  { left:0px; top:0px; }
.table-72  { left:0px; top:681px; }
.table-73  { left:0px; top:681px; }
.table-74  { left:0px; top:0px; }
.table-75  { left:0px; top:0px; }
.table-76  { left:0px; top:0px; }
.table-77  { left:0px; top:0px; }
.table-78  { left:0px; top:0px; }
.table-79  { left:0px; top:0px; }
.table-80  { left:0px; top:0px; }

.table-81  { left:0px; top:0px; }
.table-82  { left:0px; top:0px; }
.table-83  { left:0px; top:0px; }
.table-84  { left:0px; top:0px; }
.table-85  { left:0px; top:0px; }
.table-86  { left:0px; top:0px; }
.table-87  { left:0px; top:0px; }
.table-88  { left:0px; top:0px; }
.table-89  { left:0px; top:0px; }
.table-90  { left:0px; top:0px; }

.table-91  { left:0px; top:0px; }
.table-92  { left:0px; top:0px; }
.table-93  { left:0px; top:0px; }
.table-94  { left:0px; top:0px; }
.table-95  { left:0px; top:0px; }
.table-96  { left:247px; top:681px; }
.table-97  { left:0px; top:0px; }
.table-98  { left:0px; top:0px; }
.table-99  { left:0px; top:0px; }
.table-100 { left:0px; top:0px; }
.table-101 { left:0px; top:0px; }

</style>

</head>

<body>

@include('admin.sidebar')

<div class="content">

<h3>

Floor Plan View

</h3>

<div class="map-container">

    <img
    src="{{ asset('img/floorplan.jpg') }}">


<a
    href="{{ url('admin/classes/DIAMOND1') }}"
    class="vip-table diamond"
    style="left:769px;top:302px;"
    target="_blank">

    <span style="writing-mode:vertical-rl">

        VIP

    </span>

</a>

    
    <a
        href="{{ url('admin/classes/SILVER1') }}"
        class="table-dot silver"
        style="left:692px;top:681px;" target="_blank">
        1
    </a>

    @foreach($classes as $class)

    @php

        $color = 'silver';

        if(str_starts_with($class->class_code,'DIAMOND'))
        {
            $color = 'diamond';
        }
        elseif(str_starts_with($class->class_code,'PLATINUM'))
        {
            $color = 'platinum';
        }
        elseif(str_starts_with($class->class_code,'GOLD'))
        {
            $color = 'gold';
        }

    @endphp

    @if($class->table_no != 'VIP')

        <a
            href="{{ url('admin/classes/'.$class->class_code) }}"
            class="table-dot {{ $color }} table-{{ $class->table_no }}"
            target="_blank">

            {{ $class->table_no }}

        </a>

    @endif

@endforeach
    

    

    

</div>

</div>

</body>

</html>