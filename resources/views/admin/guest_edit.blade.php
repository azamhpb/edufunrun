
<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<title>{{ $guest->attendance_id }} | Edit Tetamu</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h3>Edit Tetamu</h3>

<hr>

<form
method="POST"
action="{{ url('admin/guest/edit/'.$guest->id) }}">

@csrf

<div class="mb-3">

<label>Attendance ID</label>

<input
type="text"
class="form-control"
value="{{ $guest->attendance_id }}"
readonly>

</div>

<div class="mb-3">

<label>Nama</label>

<input
type="text"
name="nama"
class="form-control"
value="{{ $guest->nama }}"
required>

</div>

<div class="mb-3">

<label>Company</label>

<input
type="text"
name="company"
class="form-control"
value="{{ $guest->company }}">

</div>


<div class="mb-3">

    <label>No Telefon</label>

    <input
    type="text"
    name="phone_no"
    class="form-control"
    value="{{ $guest->phone_no }}">

</div>


<div class="mb-3">

<label>Class/Meja</label>
<div class="alert alert-info">

Class/Meja Semasa:

<b>{{ $guest->class_code }}  / Meja : {{ $guest->table_no }}</b>

</div>


<select
name="class_code"
class="form-control">

@foreach($classes as $class)

@php

    $used = DB::table('guests')
        ->where(
            'class_code',
            $class->class_code
        )
        ->where(
            'id',
            '!=',
            $guest->id
        )
        ->count();

    $available = $class->max_pax - $used;

@endphp

<option
value="{{ $class->class_code }}"

{{ $guest->class_code == $class->class_code ? 'selected' : '' }}

{{ $available <= 0 && $guest->class_code != $class->class_code ? 'disabled' : '' }}>

{{ $class->class_code }}

- Meja {{ $class->table_no }}

({{ $used }}/{{ $class->max_pax }})

{{ $available <= 0 ? '- FULL' : '' }}

</option>

@endforeach

</select>

</div>



<button
class="btn btn-success">

Update

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