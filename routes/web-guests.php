<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\KaunterQRController;



/*
|--------------------------------------------------------------------------
| GUEST MANAGEMENT
|--------------------------------------------------------------------------
*/
Route::get('/admin/guest', function () {

    if(!session('admin_id'))
    {
        return redirect('/');
    }

    $search = request('search');
    $class  = request('class');

    $query = DB::table('guests');

    if($search)
    {
        $query->where(function($q) use ($search){

            $q->where('nama','like','%'.$search.'%')
              ->orWhere('attendance_id','like','%'.$search.'%')
              ->orWhere('company','like','%'.$search.'%');

        });
    }

    if($class)
    {
        $query->where(
            'class_code',
            $class
        );
    }

    $guests = $query
        ->orderBy('id','desc')
        ->paginate(10);

    $totalGuest = DB::table('guests')->count();

    $checkedIn = DB::table('guests')
        ->where('checkin_status','checked_in')
        ->count();

    $pending = DB::table('guests')
        ->where('checkin_status','pending')
        ->count();

    $classes = DB::table('classes')
    ->select(
        'classes.*',
        DB::raw('
            (
                SELECT COUNT(*)
                FROM guests
                WHERE guests.class_code = classes.class_code
            ) as total_guest
        ')
    )
    ->orderBy('class_code')
    ->get();

    return view(
        'admin.guest',
        compact(
            'guests',
            'totalGuest',
            'checkedIn',
            'pending',
            'classes'
        )
    );

});

Route::get('/admin/guest/create', function () {

    $classes = DB::table('classes')
        ->orderBy('class_code')
        ->get();

    return view(
        'admin.guest_create',
        compact('classes')
    );

});


Route::post('/admin/guest/create', function (Request $request) {



    $id = DB::table('guests')->insertGetId([

        'nama' => $request->nama,

        'company' => $request->company,

        'phone_no' => $request->phone_no,

        'class_code' => $request->class_code,

        'table_no' => $request->table_no,

        'qr_token' => 'GDS-'.strtoupper(Str::random(8)),

        'checkin_status' => 'pending',

        'created_at' => now('Asia/Kuala_Lumpur'),

        'updated_at' => now('Asia/Kuala_Lumpur')

    ]);

    $attendanceId = 'GALADS-YA' . str_pad(
        $id,
        3,
        '0',
        STR_PAD_LEFT
    );

    DB::table('guests')
        ->where('id', $id)
        ->update([

            'attendance_id' => $attendanceId

        ]);

    return redirect('/admin/guest')
        ->with(
            'success',
            'Tetamu berjaya ditambah'
        );

});




Route::get('/admin/guest/create', function () {

    if(!session('admin_id'))
    {
        return redirect('/');
    }

    $classes = DB::table('classes')
        ->orderBy('class_code')
        ->get();

    return view(
        'admin.guest_create',
        compact('classes')
    );

});



Route::post('/admin/guest/create', function (Request $request) {

    $lastId = DB::table('guests')->max('id') + 1;

    $attendanceId = 'GALADS-YA' . str_pad(
        $lastId,
        3,
        '0',
        STR_PAD_LEFT
    );

    DB::table('guests')->insert([

        'attendance_id' => $attendanceId,

        'nama' => $request->nama,

        'company' => $request->company,

        'phone_no' => $request->phone_no,

        'class_code' => $request->class_code,

        'table_no' => $request->table_no,

        'qr_token' => 'GDS-'.strtoupper(Str::random(8)),

        'checkin_status' => 'pending',

        'created_at' => now('Asia/Kuala_Lumpur'),

        'updated_at' => now('Asia/Kuala_Lumpur')

    ]);


        // SMS dan Email dekat admin 
        $adminName = session('admin_name');

            @file_get_contents(

                url(

                    'guest-new/'.

                    $attendanceId.'/'.

                    urlencode($adminName)

                )

            );

        


    return redirect('/admin/guest')
        ->with(
            'success',
            'Tetamu berjaya ditambah'
        );





});



Route::get('/admin/guest/edit/{id}', function ($id) {

    if(!session('admin_id'))
    {
        return redirect('/');
    }

    $guest = DB::table('guests')
        ->where('id',$id)
        ->first();

    $classes = DB::table('classes')
        ->orderBy('class_code')
        ->get();

    return view(
        'admin.guest_edit',
        compact(
            'guest',
            'classes'
        )
    );

});


Route::post('/admin/guest/edit/{id}', function (
    Request $request,
    $id
) {

    DB::table('guests')
        ->where('id',$id)
        ->update([

            'nama' => $request->nama,

            'company' => $request->company,

            'phone_no' => $request->phone_no,

            'class_code' => $request->class_code,

            'table_no' => $request->table_no,

            'updated_at' => now('Asia/Kuala_Lumpur')

        ]);

    return redirect('/admin/guest')
        ->with(
            'success',
            'Tetamu berjaya dikemaskini'
        );

});

Route::get('/admin/guest/delete/{id}', function ($id) {

    if(!session('admin_id'))
    {
        return redirect('/');
    }

    DB::table('guests')
        ->where('id',$id)
        ->delete();

    return redirect('/admin/guest')
        ->with(
            'success',
            'Tetamu berjaya dipadam'
        );

});


Route::get('/admin/guest/sms/{id}', function ($id) {

    if(!session('admin_id'))
    {
        return redirect('/');
    }

    $guest = DB::table('guests')
        ->where('id',$id)
        ->first();

    if(!$guest)
    {
        return redirect('/admin/guest')
            ->with(
                'error',
                'Tetamu tidak dijumpai'
            );
    }

    $phone = preg_replace(
        '/[^0-9]/',
        '',
        $guest->phone_no
    );

    $message =
    "Assalamualaikum dan Salam Sejahtera.\n\n".
    "Jemputan Majlis Makan Malam Gala Dinner Sabah 2026.\n\n".
    "Nama: ".$guest->nama."\n".
    "Kategori: ".$guest->class_code."\n".
    "Meja: ".$guest->table_no."\n\n".
    "Kad Jemputan akan dihantar oleh Admin Yayasan ANGKASA melalui WhatsApp.\n\n";
    //"Waktu Create Guest:\n".
    //now('Asia/Kuala_Lumpur')->format('d/m/Y h:i A');

    $api_url =
    "http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?".
    http_build_query([

        'api_key' =>
        'e998433bf9918a7ea56479af11b106e43d587294e573741ed1b318163a6610e6',
        'action' => 'send',
        'to' => '6'.$phone,
        'msg' => $message,
        'sender_id' => 'CLOUDSMS',
        'content_type' => '1',
        'mode' => 'shortcode',
        'campaign' => 'GALASABAH2026'
    ]);

    $response = @file_get_contents($api_url);

    return redirect('/admin/guest')
        ->with(
            'success',
            'SMS berjaya dihantar kepada '.$guest->nama
        );

});


/*
|--------------------------------------------------------------------------
| GUEST MANAGEMENT
|--------------------------------------------------------------------------
*/