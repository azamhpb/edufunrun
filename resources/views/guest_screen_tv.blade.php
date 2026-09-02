<!DOCTYPE html>
<html>

<head>

<link rel="icon" type="image/png"
href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Guest Live Screen EDU FUN RUN 4.0 2026</title>


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


    <div class="latest-box" id="guestBox">

        <div class="guest-name">

            Menunggu Scanner...

        </div>

    </div>


    <div class="footer">

        EDU FUN RUN 4.0 2026

    </div>


</div>


<script>


let lastAttendanceId = 0;


/*
|--------------------------------------------------------------------------
| CLOCK
|--------------------------------------------------------------------------
*/

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

        .getElementById('clock')

        .innerHTML = malaysiaTime;

}


setInterval(

    updateClock,

    1000

);


updateClock();



/*
|--------------------------------------------------------------------------
| LOAD GUEST DATA
|--------------------------------------------------------------------------
*/

function loadData(){

    fetch(

        '{{ url("guest-tv-data/".$scanner_id) }}'

    )

    .then(response => response.json())

    .then(data => {


        if(!data.success){

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Elak guest yang sama dipaparkan berulang
        |--------------------------------------------------------------------------
        */

        if(

            data.attendance_id ==

            lastAttendanceId

        ){

            return;

        }


        lastAttendanceId =

            data.attendance_id;


        /*
        |--------------------------------------------------------------------------
        | PRINT GUEST
        |--------------------------------------------------------------------------
        */

        fetch(
    '{{ url("guest-print") }}/' +
    data.attendance_id
)
.then(response => response.json())
.then(printData => {

    console.log(
        'Print:',
        printData.message
    );

})
.catch(error => {

    console.error(
        'Print error:',
        error
    );

});


        /*
        |--------------------------------------------------------------------------
        | Paparkan Guest
        |--------------------------------------------------------------------------
        */

        document

            .getElementById('guestBox')

            .innerHTML = `


                <div class="guest-name fade">

                    ${data.nama}

                </div>


                <div class="company fade">

                    ${data.company ?? ''}

                </div>


                <div class="info fade">

                    BAJU : ${data.table_no}

                </div>


            `;

    })

    .catch(error => {

        console.error(
            'Error loading guest data:',
            error
        );

    });

}


loadData();


setInterval(

    loadData,

    2000

);


loadData();


setInterval(

    loadData,

    2000

);


</script>


</body>

</html>