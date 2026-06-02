
<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>QR Attendance Scanner</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    background:
    linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
    url('https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=1974');

    background-size:cover;
    background-position:center;

    min-height:100vh;

    font-family:Arial, sans-serif;

    overflow:hidden;

}

.main-container{

    width:100%;
    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;
    flex-direction:column;

    padding:20px;

}

.title{

    color:white;
    font-size:48px;
    font-weight:bold;

    margin-bottom:25px;

    text-shadow:0 5px 20px rgba(0,0,0,0.5);

}

.scanner-card{

    width:100%;
    max-width:550px;

    background:rgba(255,255,255,0.08);

    backdrop-filter:blur(10px);

    border:1px solid rgba(255,255,255,0.15);

    border-radius:30px;

    padding:20px;

    box-shadow:0 10px 40px rgba(0,0,0,0.4);

}

#reader{

    width:100%;

    min-height:400px;

    overflow:hidden;

    border-radius:20px;

    position:relative;

    background:black;

}

#reader video{

    width:100% !important;

    border-radius:20px;

    object-fit:cover;

}

#reader__scan_region{

    background:transparent !important;

}

.result-card{

    width:100%;
    max-width:550px;

    margin-top:20px;

    background:rgba(255,255,255,0.12);

    backdrop-filter:blur(10px);

    border-radius:25px;

    padding:25px;

    text-align:center;

    color:white;

    border:1px solid rgba(255,255,255,0.15);

}

.status{

    font-size:32px;
    font-weight:bold;
    margin-bottom:10px;

}

.qr-result{

    font-size:22px;
    word-break:break-word;

}

.scan-animation{

    position:absolute;

    width:100%;
    height:3px;

    background:#00ff99;

    top:0;

    animation:scanMove 2s linear infinite;

    z-index:999;

}

@keyframes scanMove{

    0%{
        top:0;
    }

    50%{
        top:90%;
    }

    100%{
        top:0;
    }

}

.footer{

    margin-top:20px;
    color:white;
    opacity:0.7;

}

</style>

</head>

<body>

<div class="main-container">

    <div class="title">
        QR Attendance Scanner
    </div>

    <div class="scanner-card">

        <div style="position:relative;">

            <div class="scan-animation"></div>

            <div id="reader"></div>

        </div>

    </div>

    <div class="result-card">

        <div class="status" id="status">
            Waiting Scan...
        </div>

        <div class="qr-result" id="result">
            -
        </div>

    </div>

    <div class="footer">
        Laravel + MySQL QR Attendance System
    </div>

</div>

<audio id="beep">
    <source src="https://actions.google.com/sounds/v1/alarms/beep_short.ogg">
</audio>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>

let processing = false;

let lastScanned = '';

let lastScanTime = 0;

const cooldown = 5000;

function onScanSuccess(decodedText) {

    const now = Date.now();

    // block duplicate scan dalam 5 saat
    if(
        decodedText === lastScanned &&
        (now - lastScanTime) < cooldown
    ){
        return;
    }

    if(processing) return;

    processing = true;

    lastScanned = decodedText;

    lastScanTime = now;

    document.getElementById('beep').play();

    document.getElementById('status').innerHTML =
        'Processing...';

    document.getElementById('result').innerHTML =
        decodedText;

    fetch('./scan', {

        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },

        body: JSON.stringify({
            qr_code: decodedText
        })

    })
    .then(response => response.json())
    .then(data => {

        if(data.success){

            document.getElementById('status').innerHTML =
                '✅ BERJAYA HADIR';

        }else if(data.duplicate){

            document.getElementById('status').innerHTML =
                '⚠️ SUDAH HADIR';

            document.getElementById('result').innerHTML =
                'Waktu Scan: ' + data.time;

        }else{

            document.getElementById('status').innerHTML =
                '❌ Database Error';

            console.log(data.error);

        }

        setTimeout(() => {

            processing = false;

            document.getElementById('status').innerHTML =
                'Waiting Scan...';

        }, 2000);

    })
    .catch(error => {

        console.log(error);

        document.getElementById('status').innerHTML =
            '❌ Error';

        processing = false;

    });

}

const scanner = new Html5QrcodeScanner(
    "reader",
    {
        fps:10,
        qrbox:{
            width:250,
            height:250
        },
        aspectRatio:1.0,
        rememberLastUsedCamera:true
    }
);

scanner.render(onScanSuccess);

</script>

</body>
</html>

