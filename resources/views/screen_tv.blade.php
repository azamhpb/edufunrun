<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Attendance Live Screen</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    width:100%;
    height:100vh;

    overflow:hidden;

    background:
    linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)),
    url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?q=80&w=1920');

    background-size:cover;
    background-position:center;

    font-family:Arial,sans-serif;

    color:white;

}

.container{

    width:100%;
    height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;
    flex-direction:column;

}

.title{

    font-size:70px;
    font-weight:bold;

    margin-bottom:30px;

}

.total{

    font-size:180px;
    font-weight:bold;

    color:#00ff99;

    text-shadow:0 0 30px rgba(0,255,153,0.5);

}

.label{

    font-size:40px;

    margin-bottom:40px;

}

.latest-box{

    width:700px;

    background:rgba(255,255,255,0.08);

    border:1px solid rgba(255,255,255,0.15);

    backdrop-filter:blur(10px);

    border-radius:30px;

    padding:40px;

    text-align:center;

}

.latest-title{

    font-size:35px;

    margin-bottom:20px;

}

.latest-name{

    font-size:55px;

    font-weight:bold;

    color:#00ff99;

}

.clock{

    position:absolute;

    top:30px;
    right:40px;

    font-size:40px;

    font-weight:bold;

}

.footer{

    position:absolute;

    bottom:20px;

    opacity:0.6;

    font-size:22px;

}

</style>

</head>

<body>

<div class="clock" id="clock"></div>

<div class="container">

    <div class="title">
        LIVE ATTENDANCE
    </div>
	<div style="font-size:30px; margin-bottom:20px;">

    DATE:
    {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}

</div>

    <div class="total">
        {{ $total }}
    </div>

    <div class="label">
        TOTAL KEHADIRAN
    </div>

    <div class="latest-box">

        <div class="latest-title">
            Latest Scan
        </div>

        <div class="latest-name">

            @if($latest)

                {{ $latest->qr_code }}

            @else

                NO DATA

            @endif

        </div>

    </div>

    <div class="footer">
        Majlis Makan Malam Gala Dinner
    </div>

</div>

<script>

function updateClock(){

    const now = new Date();

    const malaysiaTime = now.toLocaleString('en-MY', {

        timeZone: 'Asia/Kuala_Lumpur',

        day:'2-digit',
        month:'short',
        year:'numeric',

        hour:'2-digit',
        minute:'2-digit',
        second:'2-digit',

        hour12:true

    });

    document.getElementById('clock').innerHTML =
        malaysiaTime;

}

setInterval(updateClock, 1000);

updateClock();

setInterval(() => {

    location.reload();

}, 5000);

if(document.documentElement.requestFullscreen){

    document.documentElement.requestFullscreen();

}

</script>

</body>
</html>