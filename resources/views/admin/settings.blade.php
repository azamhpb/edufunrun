<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<title>{{ session('admin_name') }} | Setting System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f6f9;
}

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

.content{

    margin-left:250px;

    padding:20px;

}

</style>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

</head>

<body>

@include('admin.sidebar')

<div class="content">

    <h3>

        Settings System - Gala Dinner Sabah 2026

    </h3>

    <hr>

    @if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

    @endif

    <br>

    <div class="card">

        <div class="card-body">

            <div class="container mt-4">

                <h3>System Settings</h3>

                <form method="POST">

                    @csrf

                    <div class="mb-3">

                        <label>No Telefon Admin</label>

                        <input
                        type="text"
                        name="admin_phone"
                        class="form-control"
                        value="{{ $setting->admin_phone }}">

                    </div>

                    <div class="mb-3">

                        <label>Email To</label>

                        <textarea
                        name="email_to"
                        class="form-control"
                        rows="3">{{ $setting->email_to }}</textarea>

                        <small>

                            Pisahkan dengan koma (,)

                        </small>

                    </div>

                    <div class="mb-3">

                        <label>Email CC</label>

                        <textarea
                        name="email_cc"
                        class="form-control"
                        rows="3">{{ $setting->email_cc }}</textarea>

                    </div>

                    <div class="mb-3">

                        <label>Email BCC</label>

                        <textarea
                        name="email_bcc"
                        class="form-control"
                        rows="3">{{ $setting->email_bcc }}</textarea>

                    </div>

                    <div class="mb-3">

                        <label>Aturcara Gala Dinner (HTML)</label>

                        <textarea
                        id="gala_program"
                        name="gala_program">

{!! $setting->gala_program !!}

                        </textarea>

                    </div>

                    <button
                    class="btn btn-success">

                        Simpan Settings

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<script>

$(document).ready(function(){

    $('#gala_program').summernote({

        height: 500,

        placeholder: 'Masukkan Aturcara Gala Dinner Sabah 2026...',

        toolbar: [

            ['style', ['style']],

            ['font', [
                'bold',
                'italic',
                'underline',
                'strikethrough',
                'clear'
            ]],

            ['fontsize', [
                'fontsize'
            ]],

            ['color', [
                'color'
            ]],

            ['para', [
                'ul',
                'ol',
                'paragraph'
            ]],

            ['table', [
                'table'
            ]],

            ['insert', [
                'link',
                'picture',
                'video'
            ]],

            ['view', [
                'fullscreen',
                'codeview'
            ]]

        ]

    });

});

</script>

</body>

</html>