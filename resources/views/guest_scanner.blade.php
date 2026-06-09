
<!DOCTYPE html>
<html>

<head>

<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta
name="csrf-token"
content="{{ csrf_token() }}">

<title>Guest Scanner</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://unpkg.com/html5-qrcode"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    background:
    linear-gradient(
        rgba(0,0,0,0.65),
        rgba(0,0,0,0.65)
    ),
    url('{{ asset('img/bg.png') }}');

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    min-height:100vh;

    font-family:Arial,sans-serif;

    overflow-x:hidden;
    overflow-y:auto;

}

.main-container{

    width:100%;
    min-height:100vh;

    display:flex;
    justify-content:flex-start;
    align-items:center;
    flex-direction:column;

    padding:30px 20px;

}

.title{

    color:white;

    font-size:48px;

    font-weight:bold;

    margin-bottom:10px;

    text-shadow:0 5px 20px rgba(0,0,0,0.5);

}

.scanner-id{

    color:white;

    font-size:20px;

    margin-bottom:20px;

    opacity:0.8;

}

.scanner-card{

    width:100%;

    max-width:600px;

    background:rgba(255,255,255,0.08);

    backdrop-filter:blur(10px);

    border:1px solid rgba(255,255,255,0.15);

    border-radius:30px;

    padding:20px;

    box-shadow:0 10px 40px rgba(0,0,0,0.4);

}

#reader{

    width:100%;

    min-height:420px;

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

.result-card{

    width:100%;

    max-width:600px;

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

    line-height:1.6;

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

        Gala Dinner QR Scanner

    </div>

    <div class="scanner-id">

        Scanner ID :
        {{ $scanner_id }}

    </div>

    <div class="scanner-card">

        <div style="position:relative;">

            <div class="scan-animation"></div>

            <div id="reader"></div>

        </div>

    </div>

    <div class="result-card">

        <div
        class="status"
        id="status">

            Waiting Scan...

        </div>

        <div
        class="qr-result"
        id="result">

            -

        </div>

    </div>

    <div class="footer">

        Gala Dinner Sabah 2026

    </div>

</div>

<audio id="beep">

    <source
    src="https://actions.google.com/sounds/v1/alarms/beep_short.ogg">

</audio>

<script>

let processing = false;

let lastScanned = '';

let lastScanTime = 0;

const cooldown = 5000;

function onScanSuccess(decodedText)
{

    const now = Date.now();

    if(
        decodedText === lastScanned &&
        (now - lastScanTime) < cooldown
    ){
        return;
    }

    if(processing)
    {
        return;
    }

    processing = true;

    lastScanned = decodedText;

    lastScanTime = now;

    document
    .getElementById('beep')
    .play();

    document
    .getElementById('status')
    .innerHTML =
    'Processing...';

    fetch(
        '{{ url("guest-scan/".$scanner_id) }}',
        {

            method:'POST',

            headers:{

                'Content-Type':
                'application/json',

                'Accept':
                'application/json',

                'X-CSRF-TOKEN':
                document.querySelector(
                    'meta[name="csrf-token"]'
                ).content

            },

            body:JSON.stringify({

                qr_code:decodedText

            })

        }
    )
    .then(response => response.json())
    .then(data => {

        if(data.success)
        {

            document
            .getElementById('status')
            .innerHTML =
            '✅ CHECK-IN BERJAYA';

            document
            .getElementById('result')
            .innerHTML =

            '<b>'+data.nama+'</b><br>' +

            (data.company ?? '') +

            '<br>' +

            data.class_code +

            ' | MEJA ' +

            data.table_no;

        }
        else if(data.duplicate)
        {

            document
            .getElementById('status')
            .innerHTML =
            '⚠️ SUDAH CHECK-IN';

            document
            .getElementById('result')
            .innerHTML =

            '<b>'+data.nama+'</b><br>' +

            (data.company ?? '') +

            '<br>' +

            data.class_code +

            ' | MEJA ' +

            data.table_no +

            '<hr>' +

            'Scanner : ' +

            (data.scanner_name ?? data.scanner_id) +

            '<br>' +

            data.scan_time;

        }
        else
        {

            document
            .getElementById('status')
            .innerHTML =
            '❌ QR TIDAK SAH';

            document
            .getElementById('result')
            .innerHTML =
            data.message;

        }

        setTimeout(() => {

            processing = false;

            document
            .getElementById('status')
            .innerHTML =
            'Waiting Scan...';

        },3000);

    })
    .catch(error => {

        console.log(error);

        document
        .getElementById('status')
        .innerHTML =
        '❌ ERROR';

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
