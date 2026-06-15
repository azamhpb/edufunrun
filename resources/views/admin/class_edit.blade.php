
<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<link rel="icon" type="image/png" href="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png">
<title>{{ $class->class_code }} | Edit Kapasiti Meja</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h3>Edit Kapasiti Meja</h3>

<hr>



<div class="container mt-4">

<h3>Edit Kapasiti Meja</h3>

<form
method="POST"
action="{{ url('admin/classes/edit/'.$class->id) }}">

@csrf

<div class="mb-3">

<label>Class</label>

<input
type="text"
class="form-control"
value="{{ $class->class_code }}"
readonly>

</div>

<div class="mb-3">

<label>No Meja</label>

<input
type="text"
class="form-control"
value="{{ $class->table_no }}"
readonly>

</div>

<div class="mb-3">

<label>Kapasiti</label>

<input
type="number"
name="max_pax"
class="form-control"
value="{{ $class->max_pax }}"
required>

</div>

<button
class="btn btn-success">

Simpan

</button>

<a
href="{{ url('admin/classes') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>







</form>

</div>

</body>
</html>