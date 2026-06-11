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

    top:1066px;

    left:164px;

    width:752px;

    text-align:center;

    font-size:24px;

    

}

.table_no{

    position:absolute;

    top:1150px;

    left:382px;

    width:350px;

    text-align:center;

    font-size:24px;

    font-weight:bold;

    

}

.table_no_without_company{

    position:absolute;

    top:1066px;

    left:342px;

    width:400px;

    text-align:center;

    font-size:26px;

    font-weight:bold;

    

}

.qr{

    position:absolute;

    left:88px;

    top:1221px;


    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,0.15);

    border-radius:25px;

    padding:20px;

    box-shadow:0 10px 40px rgba(0,0,0,0.4);



}

/* ======================================================== */
/* KOD TAMBAHAN: REKABENTUK & SEMBUNYI BUTANG CETAK         */
/* ======================================================== */
.print-section {
    text-align: center;
    margin-top: 30px;
    margin-bottom: 50px;
}

.btn-print {
    background: #ffc107;
    color: #111;
    border: none;
    padding: 15px 40px;
    font-size: 20px;
    font-weight: bold;
    border-radius: 50px;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

/* ======================================================== */
/* KOD FIX TERBARU: PENYELARASAN SAIZ HALAMAN SECARA TEPAT   */
/* ======================================================== */
@page {
    size: 1120px 1630px; 
    margin: 0;
}

@media print {
    .print-section, .custom-modal-overlay {
        display: none !important; 
    }
    html, body {
        width: 1120px !important;
        height: 1630px !important;
        background: #fff;
        overflow: hidden !important;
    }
    .card-container {
        box-shadow: none !important;
        border: none !important;
        margin: 0 !important;
        padding: 20px !important; 
        position: relative !important;
    }
}

/* ======================================================== */
/* REKABENTUK POPUP MODAL KUSTOM (TANPA BOOTSTRAP)          */
/* ======================================================== */
.btn-schedule {
    background: #013e6a; color: #fff; border: none;
    padding: 15px 40px; font-size: 20px; font-weight: bold;
    border-radius: 50px; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    margin-left: 15px; font-family: sans-serif;
}
.btn-schedule:hover { background: #01186a; }

.custom-modal-overlay {
    display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.6); z-index: 99999; align-items: center; justify-content: center;
    font-family: Arial, sans-serif;
}
.custom-modal-box {
    background: #fff; width: 90%; max-width: 650px; border-radius: 20px;
    overflow: hidden; box-shadow: 0 5px 30px rgba(0,0,0,0.3);
    animation: slideDown 0.3s ease-out;
}
@keyframes slideDown {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.custom-modal-header {
    background: linear-gradient(135deg, #013e6a, #01186a); color: #fff;
    padding: 20px; display: flex; justify-content: space-between; align-items: center;
}
.custom-modal-header h3 { margin: 0; font-size: 22px; font-weight: bold; }
.custom-modal-close { background: none; border: none; color: #fff; font-size: 28px; cursor: pointer; line-height: 1; }
.custom-modal-body { padding: 25px; color: #333; }
.custom-table { width: 100%; border-collapse: collapse; font-size: 16px; text-align: left; }
.custom-table th { background: #f4f6f9; padding: 12px; font-weight: bold; border-bottom: 2px solid #dee2e6; }
.custom-table td { padding: 14px 12px; border-bottom: 1px solid #eee; }
.custom-table tr:hover { background: #f9f9f9; }
.time-col { color: #013e6a; font-weight: bold; }
.custom-modal-footer { background: #f8f9fa; padding: 15px 20px; text-align: right; border-top: 1px solid #eee; }
.btn-close-modal { background: #6c757d; color: white; border: none; padding: 10px 25px; border-radius: 50px; cursor: pointer; font-weight: bold; font-size: 15px; }
.btn-close-modal:hover { background: #5a6268; }

</style>

</head>

<body>

<div class="card-container">

    <img
    src="{{ asset('img/card.png') }}"
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
        width="230"
        height="230" alt="QR Code">


        

    </div>

</div>

<!-- STRUKTUR BUTANG BARU -->
<div class="print-section">
    <button onclick="window.print()" class="btn-print">
        🖨️ Cetak
    </button>
    <button onclick="openModal()" class="btn-schedule">
        📅 Jadual Program
    </button>
</div>

<!-- POPUP MODAL ATURCARA KUSTOM -->
<div id="programModal" class="custom-modal-overlay" onclick="closeModalOutside(event)">
    <div class="custom-modal-box">
        <div class="custom-modal-header">
            <h3>📅 Aturcara Gala Dinner Sabah 2026</h3>
            <button class="custom-modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 30%">Masa</th>
                        <th>Agenda / Aktiviti</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="time-col">07:00 MLM</td>
                        <td>Ketibaan Para Jemputan & Pendaftaran Tetamu</td>
                    </tr>
                    <tr>
                        <td class="time-col">07:30 MLM</td>
                        <td>Ketibaan Tetamu Kehormat</td>
                    </tr>
                    <tr>
                        <td class="time-col">07:45 MLM</td>
                        <td>Bacaan Doa & Ucapan Aluan Pembukaan Majlis</td>
                    </tr>
                    <tr>
                        <td class="time-col">08:00 MLM</td>
                        <td>Acara Makan Malam Bermula & Persembahan Multimedia</td>
                    </tr>
                    <tr>
                        <td class="time-col">09:00 MLM</td>
                        <td>Penyampaian Anugerah & Cabutan Bertuah</td>
                    </tr>
                    <tr>
                        <td class="time-col">10:30 MLM</td>
                        <td>Sesi Bergambar & Bersurai</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="custom-modal-footer">
            <button class="btn-close-modal" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>

<!-- FUNGSI JAVASCRIPT POPUP -->
<script>
    function openModal() {
        document.getElementById('programModal').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('programModal').style.display = 'none';
    }
    function closeModalOutside(event) {
        if (event.target.id === 'programModal') {
            closeModal();
        }
    }
</script>


</body>

</html>
