@php

$badgeClass = 'blank';

if(str_starts_with($guest->class_code,'DIAMOND'))
{
    $badgeClass = 'diamond';
}
elseif(str_starts_with($guest->class_code,'PLATINUM'))
{
    $badgeClass = 'platinum';
}
elseif(str_starts_with($guest->class_code,'GOLD'))
{
    $badgeClass = 'gold';
}
elseif(str_starts_with($guest->class_code,'SILVER'))
{
    $badgeClass = 'silver';
}

@endphp

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<title>{{ $guest->nama }} | Kad Jemputan Gala Dinner Sabah 2026 Yayasan ANGKASA</title>

<style>

.category{

    position:absolute;

    top:1230px;

    left:250px;

    width:500px;

    height:70px;

    border-radius:50px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:32px;

    font-weight:bold;

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

body{

    margin:0;
    padding:0;

    background:#fff;

}

.card-container{

    position:relative;

    width:1080px;

    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,0.15);

    border-radius:30px;

    padding:20px;

    box-shadow:0 10px 40px rgba(0,0,0,0.4);

    margin:auto;

}

.card-bg{

    width:100%;

    display:block;

}

.nama{

    position:absolute;

    top:983px;

    left:164px;

    width:752px;

    text-align:center;

    font-size:28px;

    font-weight:bold;

    
    

}

.company{

    position:absolute;

    top:1096px;

    left:164px;

    width:752px;

    text-align:center;

    font-size:24px;

    

}

.table_no{

    position:absolute;

    top:1210px;

    left:342px;

    width:400px;

    text-align:center;

    font-size:26px;

    font-weight:bold;

    

}

.table_no_without_company{

    position:absolute;

    top:1096px;

    left:342px;

    width:400px;

    text-align:center;

    font-size:26px;

    font-weight:bold;

    

}

.qr{

    position:absolute;

    left:85px;

    top:1285px;


        backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,0.15);

    border-radius:25px;

    padding:20px;

    box-shadow:0 10px 40px rgba(0,0,0,0.4);



}

</style>

</head>

<body>

<div class="card-container">

    <img
    src="{{ asset('Makan-Malam-Gala-Sabah-2026.png') }}"
    class="card-bg">

    <div class="category {{ $badgeClass }} nama">

        {{ $guest->nama }}

    </div>
@if(!empty($guest->company))

    <div class="category {{ $badgeClass }} company">

        {{ $guest->company }}

    </div>

    
    <div class="category {{ $badgeClass }} table_no">

        {{ $guest->class_code }}

        &nbsp; | &nbsp;

        MEJA {{ $guest->table_no }}

    </div>

@else


    <div class="category {{ $badgeClass }} table_no_without_company">

        {{ $guest->class_code }}

        @if($guest->table_no)

        &nbsp; | &nbsp;

        MEJA {{ $guest->table_no }}

        @endif

    </div>

@endif

    <div class="qr">

        <img
       src="{{ url('qr-guest/'.$guest->id) }}"
        width="175"
        height="175" alt="QR Code">


        

    </div>

</div>

</body>

</html>

