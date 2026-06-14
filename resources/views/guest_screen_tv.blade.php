
<!DOCTYPE html>
<html>

<head>

<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Guest Live Screen</title>

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
    linear-gradient(
        rgba(0,0,0,0.75),
        rgba(0,0,0,0.75)
    ),
    url('{{ asset('img/bg.png') }}');

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

    text-align:center;

}

.title{

    font-size:70px;
    font-weight:bold;

    margin-bottom:30px;

}

.latest-box{

    width:900px;

    background:rgba(255,255,255,0.08);

    border:1px solid rgba(255,255,255,0.15);

    backdrop-filter:blur(10px);

    border-radius:30px;

    padding:50px;

    text-align:center;

}

.screen-layout{

    display:flex;

    align-items:center;

    justify-content:center;

    gap:40px;

}

.floorplan-wrap{

    position:relative;

    width:700px;

}

.floorplan{

    width:100%;

    border-radius:20px;

}

.table-marker{

    position:absolute;

    width:40px;
    height:40px;

    border:4px solid red;

    border-radius:50%;

    display:none;

    animation:pulse 1s infinite;
}

@keyframes pulse{

    0%{
        transform:scale(1);
        opacity:1;
    }

    100%{
        transform:scale(1.4);
        opacity:.2;
    }

}

.guest-name{

    font-size:70px;

    font-weight:bold;

    color:#00ff99;

    margin-bottom:15px;

}

.company{

    font-size:35px;

    margin-bottom:20px;

}

.info{

    font-size:45px;

}

.clock{

    position:absolute;

    top:30px;
    right:40px;

    font-size:35px;

    font-weight:bold;

}

.scanner{

    position:absolute;

    top:30px;
    left:40px;

    font-size:30px;

    opacity:.8;

}

.footer{

    position:absolute;

    bottom:20px;

    opacity:.6;

    font-size:22px;

}

.fade{

    animation:fadeIn .5s;
}

@keyframes fadeIn{

    from{

        opacity:0;
        transform:scale(.95);

    }

    to{

        opacity:1;
        transform:scale(1);

    }

}

</style>

</head>

<body>

<div class="clock" id="clock"></div>

<div class="scanner">

    Scanner {{ $scanner_id }}

</div>

<div class="container">

    <div class="title">

        SELAMAT DATANG

    </div>

    <div class="screen-layout">

    <div
    class="latest-box"
    id="guestBox">

        <div class="guest-name">

            Menunggu Tetamu...

        </div>

    </div>

    <div class="floorplan-wrap">

        <img
        src="{{ asset('img/floorplan.jpg') }}"
        class="floorplan">

        <div
        id="tableMarker"
        class="table-marker">
        </div>

    </div>

</div>

    <div class="footer">

        Majlis Makan Malam Gala Dinner Sabah 2026

    </div>

</div>

<script>

const posisi = {};

// VIP
posisi['VIP'] = {left:525, top:245};

// Kolum meja
const leftPos = [
    167,
    214,
    258,
    299,
    342,
    390,
    435,
    479
];

const topPos = [
    55,
    91,
    128,
    163,
    199,
    239,
    290,
    326,
    361,
    399,
    435,
    474
];

// Meja 1 - 96
const columns = [

    [85,86,87,88,89,90,91,92,93,94,95,96],
    [84,83,82,81,80,79,78,77,76,75,74,73],

    [61,62,63,64,65,66,67,68,69,70,71,72],
    [60,59,58,57,56,55,54,53,52,51,50,49],

    [37,38,39,40,41,42,43,44,45,46,47,48],
    [36,35,34,33,32,31,30,29,28,27,26,25],

    [13,14,15,16,17,18,19,20,21,22,23,24],
    [12,11,10,9,8,7,6,5,4,3,2,1]

];

for(let col = 0; col < columns.length; col++)
{
    for(let row = 0; row < columns[col].length; row++)
    {
        let tableNo = columns[col][row];

        posisi[tableNo] = {

            left: leftPos[col],

            top: topPos[row]

        };
    }
}


// Meja 97 - 100
posisi[97] = {
    left:118,
    top:313
};

posisi[98] = {
    left:118,
    top:273
};

posisi[99] = {
    left:118,
    top:233
};

posisi[100] = {
    left:118,
    top:180
};



let lastAttendanceId = 0;

function updateClock(){

    const now = new Date();

    const malaysiaTime =
    now.toLocaleString(
        'en-MY',
        {

            timeZone:
            'Asia/Kuala_Lumpur',

            day:'2-digit',
            month:'short',
            year:'numeric',

            hour:'2-digit',
            minute:'2-digit',
            second:'2-digit',

            hour12:true

        }
    );

    document
    .getElementById(
        'clock'
    )
    .innerHTML =
    malaysiaTime;

}

setInterval(
    updateClock,
    1000
);

updateClock();

function loadData()
{

    fetch(
        '{{ url("guest-tv-data/".$scanner_id) }}'
    )
    .then(response => response.json())
    .then(data => {

        if(!data.success)
        {
            return;
        }

        if(
            data.attendance_id ==
            lastAttendanceId
        )
        {
            return;
        }

        lastAttendanceId =
        data.attendance_id;

        let meja = data.table_no;

        // VIP
        if(
            data.class_code &&
            data.class_code.startsWith('DIAMOND')
        )
        {
            meja = 'VIP';
        }

        let marker =
        document.getElementById(
            'tableMarker'
        );

        if(posisi[meja])
        {
            marker.style.display = 'block';

            const scale = 700 / 1000;

            marker.style.left =
                ((posisi[meja].left))
                + 'px';

            marker.style.top =
                ((posisi[meja].top))
                + 'px';
        }

        document
        .getElementById(
            'guestBox'
        )
        .innerHTML = `

            <div class="guest-name fade">

                ${data.nama}

            </div>

            <div class="company fade">

                ${data.company ?? ''}

            </div>

            <div class="info fade">

                ${data.class_code}

                |

                MEJA ${data.table_no}

            </div>

        `;

    });

}

loadData();

setInterval(
    loadData,
    2000
);

</script>

</body>

</html>

