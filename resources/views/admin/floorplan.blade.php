<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<title>

{{ session('admin_name') }} | Floor Plan View

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

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:12px;

    font-weight:bold;

    border:2px solid white;

    overflow:visible;

}

.pax-count{

    position:absolute;

    top:32px;

    left:50%;

    transform:translateX(-50%);

    font-size:12px;

    font-weight:bold;

    white-space:nowrap;

    color:#111;

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

.vip-text{

    writing-mode:vertical-rl;

    font-weight:bold;

    color:#111;

}

.vip-pax{

    position:absolute;

    bottom:0px;

    font-size:13px;

    font-weight:bold;

    color:#111;

    white-space:nowrap;

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

    <span class="vip-text">

        VIP

    </span>

    <span class="vip-pax">

        {{
            collect($classes)
            ->where('class_code','DIAMOND1')
            ->first()
            ?->used_pax ?? 0
        }}/7

    </span>

</a>

    
    @php

$leftColumn = [

    1  => 692,
    13 => 627,
    25 => 563,
    37 => 494,
    49 => 433,
    61 => 375,
    73 => 313,
    85 => 247

];

$topRow = [

    1  => 681,
    2  => 628,
    3  => 577,
    4  => 523,
    5  => 473,
    6  => 418,
    7  => 345,
    8  => 291,
    9  => 241,
    10 => 187,
    11 => 136,
    12 => 82

];

$posisi = [];

/*
|--------------------------------------------------------------------------
| Meja 1 - 96
|--------------------------------------------------------------------------
*/

foreach($leftColumn as $startTable => $left)
{
    for($i=0; $i<12; $i++)
    {
        $tableNo = $startTable + $i;

        $posisi[$tableNo] = [

            'left' => $left,

            'top' => $topRow[$i + 1]

        ];
    }
}

/*
|--------------------------------------------------------------------------
| Meja 97 - 100 (tepi kiri)
|--------------------------------------------------------------------------
*/

$posisi[97] = [

    'left' => 176,
    'top'  => 452

];

$posisi[98] = [

    'left' => 176,
    'top'  => 395

];

$posisi[99] = [

    'left' => 176,
    'top'  => 339

];

$posisi[100] = [

    'left' => 176,
    'top'  => 280

];

@endphp
    

@foreach($classes as $class)

@php

$tableNo = (int)$class->table_no;

if(!isset($posisi[$tableNo]))
{
    continue;
}

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

<a
    href="{{ url('admin/classes/'.$class->class_code) }}"
    class="table-dot {{ $color }}"
    style="
        left:{{ $posisi[$tableNo]['left'] }}px;
        top:{{ $posisi[$tableNo]['top'] }}px;
    "
    target="_blank">

    <div>

        {{ $tableNo }}

        <div class="pax-count">

            {{ $class->used_pax }}
            /
            {{ $class->max_pax }}

        </div>

    </div>

</a>

@endforeach

    

</div>

</div>

</body>

</html>