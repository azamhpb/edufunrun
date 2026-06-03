@php



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

<title>{{ $guest->nama }}</title>

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
        #f7d36b,
        #9c5f00,
        #f8c867
    );

}

.platinum{

    color:#111;

    background:linear-gradient(
        135deg,
        #f0eef5,
        #9a9aa0,
        #d7d7dc
    );

}

.gold{

    color:#fff;

    background:linear-gradient(
        135deg,
        #d8c0a0,
        #8f6d42,
        #c9aa7d
    );

}

.silver{

    color:#fff;

    background:linear-gradient(
        135deg,
        #6dd6ff,
        #0056b3
    );

}

body{

    margin:0;
    padding:0;

    background:#eee;

}

.card-container{

    position:relative;

    width:1080px;

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

    color:#111;

}

.company{

    position:absolute;

    top:1096px;

    left:164px;

    width:752px;

    text-align:center;

    font-size:24px;

    color:#111;

}

.table_no{

    position:absolute;

    top:1210px;

    left:342px;

    width:400px;

    text-align:center;

    font-size:26px;

    font-weight:bold;

    color:#111;

}

.qr{

    position:absolute;

    left:85px;

    top:1286px;

}

</style>

</head>

<body>

<div class="card-container">

    <img
    src="{{ asset('card-template.png') }}"
    class="card-bg">

    <div class="category {{ $badgeClass }} nama">

        {{ $guest->nama }}

    </div>

    <div class="category {{ $badgeClass }} company">

        {{ $guest->company }}

    </div>

    <div class="category {{ $badgeClass }} table_no">

        {{ $guest->class_code }}

        &nbsp; | &nbsp;

        MEJA {{ $guest->table_no }}

    </div>

    <div class="qr">

      
<img src="https://api.qrserver.com/v1/create-qr-code/?size=175x175&data={{ urlencode($guest->attendance_id) }}" alt="QR Code">

    </div>

</div>

</body>

</html>

