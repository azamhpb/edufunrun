<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<title>Tambah Tetamu</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

    <h3>Tambah Tetamu</h3>

    <hr>

    <form
    method="POST"
    action="{{ url('admin/guest/create') }}">

        @csrf

        

        <div class="mb-3">

            <label>Nama</label>

            <input
            type="text"
            name="nama"
            class="form-control"
            required>

        </div>

        <div class="mb-3">

            <label>Company</label>

            <input
            type="text"
            name="company"
            class="form-control">

        </div>

        <div class="mb-3">

            <label>No Telefon</label>

            <input
            type="text"
            name="phone_no"
            class="form-control">

        </div>

        <div class="mb-3">

            <label>Class</label>

            <select
            name="class_code"
            class="form-control"
            required>

                @foreach($classes as $class)

                        @php

                            $used = DB::table('guests')
                                ->where(
                                    'class_code',
                                    $class->class_code
                                )
                                ->count();

                            $available = $class->max_pax - $used;

                        @endphp

                        <option
                        value="{{ $class->class_code }}"
                        {{ $available <= 0 ? 'disabled' : '' }}>

                        {{ $class->class_code }}

                        ({{ $available }} lagi)

                        {{ $available <= 0 ? '- FULL' : '' }}

                        </option>

                        @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label>No Meja</label>

            <input
            type="text"
            name="table_no"
            class="form-control">

        </div>

        <button
        class="btn btn-success">

            Simpan Tetamu

        </button>

        <a
        href="{{ url('admin/guest') }}"
        class="btn btn-secondary">

            Kembali

        </a>

    </form>

</div>

</body>
</html>