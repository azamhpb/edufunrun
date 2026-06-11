<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
<title>Guest New Registration</title>
</head>
<body style="font-family:Arial,sans-serif;background:#f4f6f9;padding:20px;">

<div style="
max-width:700px;
margin:auto;
background:white;
border-radius:12px;
overflow:hidden;
box-shadow:0 2px 10px rgba(0,0,0,.1);
">

<div style="
background:#8e1558;
padding:20px;
text-align:center;
color:white;
">

<h2 style="margin:0;">
Gala Dinner Sabah 2026
</h2>

<p style="margin:5px 0 0 0;">
Guest New Registration
</p>

</div>

<div style="padding:25px;">

<h3 style="color:#198754;">
Guest New Registration
</h3>

<table width="100%" cellpadding="8">

<tr>
<td width="180"><strong>Nama</strong></td>
<td>{{ $guest->nama }}</td>
</tr>

<tr>
<td><strong>Attendance ID</strong></td>
<td>{{ $guest->attendance_id }}</td>
</tr>

<tr>
<td><strong>Company</strong></td>
<td>{{ $guest->company }}</td>
</tr>

<tr>
<td><strong>Class</strong></td>
<td>{{ $guest->class_code }}</td>
</tr>

<tr>
<td><strong>Meja</strong></td>
<td>{{ $guest->table_no }}</td>
</tr>

<tr>
<td><strong>User Admin Create</strong></td>
<td>{{ $adminName }}</td>
</tr>

<tr>
<td><strong>Masa Check In</strong></td>
<td>{{ now('Asia/Kuala_Lumpur')->format('d/m/Y h:i:s A') }}</td>
</tr>

</table>

</div>

<div style="
background:#f8f9fa;
padding:15px;
text-align:center;
font-size:12px;
color:#666;
">

Yayasan ANGKASA<br>
Gala Dinner Sabah 2026

</div>

</div>

</body>
</html>
