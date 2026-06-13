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
| Scanner User Interface
|--------------------------------------------------------------------------
*/



Route::get('/guest_scanner/{scanner_id}', function ($scanner_id) {

    return view(
        'guest_scanner',
        compact('scanner_id')
    );

});

Route::post('/guest-scan/{scanner_id}', function (
    Request $request,
    $scanner_id
) {

    $guest = DB::table('guests')
        ->where(
            'qr_token',
            $request->qr_code
        )
        ->first();

    if(!$guest)
    {

        DB::table('scan_logs')->insert([

            'guest_id' => 0,

            'scanner_id' => $scanner_id,

            'qr_token' => $request->qr_code,

            'scan_result' => 'INVALID',

            'scan_time' => now('Asia/Kuala_Lumpur'),

            'created_at' => now('Asia/Kuala_Lumpur'),

            'updated_at' => now('Asia/Kuala_Lumpur')

        ]);

        return response()->json([

            'success' => false,

            'message' => 'QR Tidak Sah'

        ]);

    }

    $already = DB::table('guest_attendance')
        ->where(
            'guest_id',
            $guest->id
        )
        ->exists();

    if($already)
{

    $lastScan = DB::table('guest_attendance')
        ->where(
            'guest_id',
            $guest->id
        )
        ->orderByDesc('id')
        ->first();

    DB::table('scan_logs')->insert([

        'guest_id' => $guest->id,

        'scanner_id' => $scanner_id,

        'qr_token' => $guest->qr_token,

        'scan_result' => 'DUPLICATE',

        'scan_time' => now('Asia/Kuala_Lumpur'),

        'created_at' => now('Asia/Kuala_Lumpur'),

        'updated_at' => now('Asia/Kuala_Lumpur')

    ]);

    return response()->json([

        'success' => false,

        'duplicate' => true,

        'message' => 'Sudah Check In',

        'nama' => $guest->nama,

        'company' => $guest->company,

        'class_code' => $guest->class_code,

        'table_no' => $guest->table_no,

        'scanner_id' => $lastScan->scanner_id,

        'scan_time' => date(
            'd/m/Y h:i:s A',
            strtotime($lastScan->scan_time)
        )

    ]);

}

    DB::table('guest_attendance')->insert([

        'guest_id' => $guest->id,

        'scanner_id' => $scanner_id,

        'scan_time' => now('Asia/Kuala_Lumpur'),

        'created_at' => now('Asia/Kuala_Lumpur'),

        'updated_at' => now('Asia/Kuala_Lumpur')

    ]);

    DB::table('guests')
        ->where('id',$guest->id)
        ->update([

            'checkin_status' => 'checked_in',

            'checkin_time' => now('Asia/Kuala_Lumpur'),

            'updated_at' => now('Asia/Kuala_Lumpur')

        ]);

    DB::table('scan_logs')->insert([

        'guest_id' => $guest->id,

        'scanner_id' => $scanner_id,

        'qr_token' => $guest->qr_token,

        'scan_result' => 'SUCCESS',

        'scan_time' => now('Asia/Kuala_Lumpur'),

        'created_at' => now('Asia/Kuala_Lumpur'),

        'updated_at' => now('Asia/Kuala_Lumpur')

    ]);


    if(
    str_starts_with($guest->class_code,'DIAMOND')
    ||
    str_starts_with($guest->class_code,'PLATINUM')
)
{
    @file_get_contents(
        url(
            'guest-checkin/'.
            $guest->id.'/'.
            $scanner_id
        )
    );
}

    return response()->json([

        'success' => true,

        'nama' => $guest->nama,

        'company' => $guest->company,

        'class_code' => $guest->class_code,

        'table_no' => $guest->table_no

    ]);

});


Route::get('/guest_screen_tv/{scanner_id}', function ($scanner_id) {

    return view(
        'guest_screen_tv',
        compact('scanner_id')
    );

});

Route::get('/guest-tv-data/{scanner_id}', function ($scanner_id) {

    $attendance = DB::table('guest_attendance')
        ->where(
            'scanner_id',
            $scanner_id
        )
        ->orderByDesc('id')
        ->first();

    if(!$attendance)
    {
        return response()->json([
            'success' => false
        ]);
    }

    $guest = DB::table('guests')
        ->where(
            'id',
            $attendance->guest_id
        )
        ->first();

    if(!$guest)
    {
        return response()->json([
            'success' => false
        ]);
    }

    return response()->json([

        'success' => true,

        'attendance_id' => $attendance->id,

        'nama' => $guest->nama,

        'company' => $guest->company,

        'class_code' => $guest->class_code,

        'table_no' => $guest->table_no

    ]);

});



Route::get('/guest_dashboard_tv', function () {

    return view(
        'guest_dashboard_tv'
    );

});


Route::get('/guest-dashboard-data', function () {

    $total = DB::table('guest_attendance')
        ->count();

    $latest = DB::table('guest_attendance')
        ->orderByDesc('id')
        ->first();

    if(!$latest)
    {
        return response()->json([

            'total' => $total,

            'latest' => null

        ]);
    }

    $guest = DB::table('guests')
        ->where(
            'id',
            $latest->guest_id
        )
        ->first();

    return response()->json([

        'total' => $total,

        'latest' => [

            'nama' => $guest->nama,

            'company' => $guest->company,

            'class_code' => $guest->class_code,

            'table_no' => $guest->table_no,

            'scan_time' => $latest->scan_time

        ]

    ]);

});



/*
|--------------------------------------------------------------------------
| Scanner User Interface
|--------------------------------------------------------------------------
*/

