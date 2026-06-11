
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;








/*
|--------------------------------------------------------------------------
| VIEW
|--------------------------------------------------------------------------
*/




Route::get('/scanner', function () {
    return view('scanner');
});

Route::get('/screen_tv', function (Request $request) {

    $date = $request->get('date', 'today');

    // TODAY
    if($date == 'today'){

        $selectedDate = today('Asia/Kuala_Lumpur');

    // YESTERDAY
    }else if($date == 'yesterday'){

        $selectedDate = today('Asia/Kuala_Lumpur')->subDay();

    // CUSTOM DATE
    }else{

        $selectedDate = $date;

    }

    // TOTAL ATTENDANCE IKUT scan_time
    $total = \App\Models\Attendance::whereDate(
        'scan_time',
        $selectedDate
    )->count();

    // LATEST ATTENDANCE IKUT scan_time
    $latest = \App\Models\Attendance::whereDate(
        'scan_time',
        $selectedDate
    )->latest('scan_time')
    ->first();

    return view('screen_tv', compact(
        'total',
        'latest',
        'selectedDate'
    ));

});

/*
|--------------------------------------------------------------------------
| QR SCAN
|--------------------------------------------------------------------------
*/

Route::post('/scan', function (Request $request) {

    // check attendance hari ini ikut scan_time
    $todayAttendance = Attendance::where(
        'qr_code',
        $request->qr_code
    )
    ->whereDate('scan_time', today('Asia/Kuala_Lumpur'))
    ->first();

    // kalau dah scan hari ini
    if($todayAttendance){

        return response()->json([

            'success' => false,

            'duplicate' => true,

            'message' => 'Sudah hadir hari ini',

            'time' => \Carbon\Carbon::parse(
                $todayAttendance->scan_time
            )->format('h:i A')

        ]);

    }

    // save attendance baru
    Attendance::create([

        'qr_code' => $request->qr_code,

		'scan_time' => now('Asia/Kuala_Lumpur')

    ]);

    return response()->json([

        'success' => true,

        'message' => 'Berjaya hadir'

    ]);

});

/*
|--------------------------------------------------------------------------
| TEST ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/db-test', function () {

    \DB::table('attendances')->insert([

        'qr_code' => 'SERVER_TEST',

        'scan_time' => now('Asia/Kuala_Lumpur'),

        'created_at' => now('Asia/Kuala_Lumpur'),

        'updated_at' => now('Asia/Kuala_Lumpur')

    ]);

    return 'DATABASE CONNECTED';

});


/*
|--------------------------------------------------------------------------
| TEST ROUTES
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| INDEX IKLAN
|--------------------------------------------------------------------------
*/
Route::get('/', function () {

    return view('welcome_gala');

});

/*
|--------------------------------------------------------------------------
| INDEX IKLAN
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| ADMIN LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', function () {

    if(session('admin_id'))
    {
        return redirect('/admin/dashboard');
    }

    return view('admin.login');

});

Route::get('/admin/login', function () {

    if(session('admin_id'))
    {
        return redirect('/admin/dashboard');
    }

    return view('admin.login');

});

Route::post('/admin/login', function (Request $request) {

    $admin = DB::table('admins')
        ->where('username',$request->username)
        ->where('status','active')
        ->first();

    if(
        $admin &&
        Hash::check(
            $request->password,
            $admin->password
        )
    ){

        session([

            'admin_id' => $admin->id,
            'admin_name' => $admin->nama,
            'admin_level' => $admin->level

        ]);

        return redirect('/admin/dashboard');

    }

    return back()
        ->with('error','Username atau Password Salah');

});

Route::get('/admin/logout', function () {

    session()->flush();

    return redirect('/');

});

Route::get('/admin/dashboard', function () {

    if(!session('admin_id'))
    {
        return redirect('/admin/login');
    }

    return view('admin.dashboard');

});

Route::get('/admin/live-attendance', function(){

    $totalGuest = DB::table('guests')
        ->count();

    $attendanceToday = DB::table('guest_attendance')
        ->distinct('guest_id')
        ->count();

    $notCheckedIn =
        $totalGuest -
        $attendanceToday;

    $latestAttendance = DB::table('guest_attendance')
        ->orderByDesc('id')
        ->first();

    $latest = null;

    if($latestAttendance)
    {

        $guest = DB::table('guests')
            ->where(
                'id',
                $latestAttendance->guest_id
            )
            ->first();

        if($guest)
        {

            $latest = [

                'nama' => $guest->nama,

                'class_code' => $guest->class_code,

                'table_no' => $guest->table_no

            ];

        }

    }

    return response()->json([

        'attendanceToday' => $attendanceToday,

        'totalAttendance' => $notCheckedIn,

        'totalGuest' => $totalGuest,

        'latest' => $latest

    ]);

});

Route::get('/admin/user', function () {

    if(!session('admin_id'))
    {
        return redirect('/admin/login');
    }

    if(session('admin_level') != 'superadmin')
    {
        abort(403);
    }

    $users = DB::table('admins')
        ->orderBy('id','desc')
        ->get();

    return view(
        'admin.user',
        compact('users')
    );

});

Route::get('/admin/user/create', function () {

    if(!session('admin_id'))
    {
        return redirect('/admin/login');
    }

    if(session('admin_level') != 'superadmin')
    {
        abort(403);
    }

    return view('admin.user_create');

});


Route::post('/admin/user/create', function (Request $request) {

    if(session('admin_level') != 'superadmin')
    {
        abort(403);
    }

    DB::table('admins')->insert([

        'nama' => $request->nama,

        'username' => $request->username,

        'password' => Hash::make(
            $request->password
        ),

        'level' => $request->level,

        'status' => 'active',

        'created_at' => now('Asia/Kuala_Lumpur'),

        'updated_at' => now('Asia/Kuala_Lumpur')

    ]);

    return redirect('/admin/user')
        ->with(
            'success',
            'User berjaya ditambah'
        );

});

Route::get('/admin/user/edit/{id}', function ($id) {

    if(!session('admin_id'))
    {
        return redirect('/admin/login');
    }

    if(session('admin_level') != 'superadmin')
    {
        abort(403);
    }

    $user = DB::table('admins')
        ->where('id',$id)
        ->first();

    if(!$user)
    {
        abort(404);
    }

    return view(
        'admin.user_edit',
        compact('user')
    );

});

Route::post('/admin/user/edit/{id}', function (Request $request,$id) {

    if(session('admin_level') != 'superadmin')
    {
        abort(403);
    }

    DB::table('admins')
    ->where('id',$id)
    ->update([

        'nama' => $request->nama,

        'username' => $request->username,

        'level' => $request->level,

        'status' => $request->status,

        'updated_at' => now('Asia/Kuala_Lumpur')

    ]);

    return redirect('/admin/user')
        ->with(
            'success',
            'User berjaya dikemaskini'
        );

});

Route::get('/admin/user/reset-password/{id}', function ($id) {

    if(session('admin_level') != 'superadmin')
    {
        abort(403);
    }

    $user = DB::table('admins')
        ->where('id',$id)
        ->first();

    if(!$user)
    {
        abort(404);
    }

    return view(
        'admin.user_reset_password',
        compact('user')
    );

});

Route::post('/admin/user/reset-password/{id}', function (Request $request,$id) {

    if(session('admin_level') != 'superadmin')
    {
        abort(403);
    }

    DB::table('admins')
    ->where('id',$id)
    ->update([

        'password' => Hash::make(
            $request->password
        ),

        'updated_at' => now('Asia/Kuala_Lumpur')

    ]);

    return redirect('/admin/user')
    ->with(
        'success',
        'Password berjaya direset'
    );

});

Route::get('/admin/user/delete/{id}', function ($id) {

    if(session('admin_level') != 'superadmin')
    {
        abort(403);
    }

    // Tak boleh delete diri sendiri
    if(session('admin_id') == $id)
    {
        return back()->with(
            'error',
            'Tidak boleh delete akaun sendiri'
        );
    }

    $user = DB::table('admins')
        ->where('id',$id)
        ->first();

    if(!$user)
    {
        abort(404);
    }

    // Kira superadmin aktif
    $superadminCount = DB::table('admins')
        ->where('level','superadmin')
        ->where('status','active')
        ->count();

    // Jangan delete superadmin terakhir
    if(
        $user->level == 'superadmin'
        &&
        $superadminCount <= 1
    )
    {
        return back()->with(
            'error',
            'Superadmin terakhir tidak boleh dipadam'
        );
    }

    DB::table('admins')
        ->where('id',$id)
        ->delete();

    return back()->with(
        'success',
        'User berjaya dipadam'
    );

});


/*
|--------------------------------------------------------------------------
| ADMIN LOGIN
|--------------------------------------------------------------------------
*/


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

        'qr_token' => Str::uuid(),

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

        'qr_token' => Str::uuid(),

        'checkin_status' => 'pending',

        'created_at' => now('Asia/Kuala_Lumpur'),

        'updated_at' => now('Asia/Kuala_Lumpur')

    ]);




        // SMS dekat admin 
        $phone = preg_replace('/[^0-9]/', '', $request->phone_no);

        $message =
        "Daftar Baru.\n\n".
        "Admin Sila Hantar Kad Jemputan.\n\n".
        "Nama: ".$request->nama."\n".
        "Kategori: ".$request->class_code."\n".
        "Meja: ".$request->table_no."\n\n".
        "Phone: ".$phone."\n\n".
        "Waktu Create Guest:\n".
        now('Asia/Kuala_Lumpur')->format('d/m/Y h:i A');

        $api_url =
        "http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?".
        http_build_query([

            'api_key'      => 'e998433bf9918a7ea56479af11b106e43d587294e573741ed1b318163a6610e6',
            'action'       => 'send',
            'to'           => '60127743756', // Gantikan dengan nombor admin
            'msg'          => $message,
            'sender_id'    => 'CLOUDSMS',
            'content_type' => '1',
            'mode'         => 'shortcode',
            'campaign'     => 'GALASABAH2026'

        ]);

        $response = @file_get_contents($api_url);

        // Dapatkan QR Token untuk dihantar dalam SMS


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


/*
|--------------------------------------------------------------------------
| CARD JEMPUTAN
|--------------------------------------------------------------------------
*/



Route::get('/card/{id}', function ($id) {

    $guest = DB::table('guests')
        ->where('qr_token',$id)
        ->first();

    if(!$guest)
    {
        abort(404);
    }

    return view(
        'card',
        compact('guest')
    );

});


Route::get('/qr-guest/{id}', function ($id) {

    $guest = DB::table('guests')
        ->where('id', $id)
        ->first();

    if(!$guest)
    {
        abort(404);
    }

    return redirect(
        'https://api.qrserver.com/v1/create-qr-code/?size=175x175&data='
        . urlencode($guest->qr_token)
    );

});

/*
|--------------------------------------------------------------------------
| CARD JEMPUTAN
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Attendance Management
|--------------------------------------------------------------------------
*/


Route::get('/admin/attendance-management', function () {

    if(!session('admin_id'))
    {
        return redirect('/');
    }

    $attendance = DB::table('guest_attendance')
        ->join(
            'guests',
            'guest_attendance.guest_id',
            '=',
            'guests.id'
        );

    if(request('search'))
    {
        $attendance->where(function($q){

            $q->where(
                'guests.nama',
                'like',
                '%'.request('search').'%'
            )

            ->orWhere(
                'guests.company',
                'like',
                '%'.request('search').'%'
            )

            ->orWhere(
                'guests.attendance_id',
                'like',
                '%'.request('search').'%'
            )

            ->orWhere(
                'guests.table_no',
                'like',
                '%'.request('search').'%'
            );

        });
    }

    $attendance = $attendance
        ->select(
            'guest_attendance.*',
            'guests.nama',
            'guests.company',
            'guests.class_code',
            'guests.table_no',
            'guests.attendance_id'
        )
        ->orderByDesc(
            'guest_attendance.id'
        )
        ->paginate(20);

    return view(
        'admin.attendance_management',
        compact('attendance')
    );

});

Route::post('/admin/attendance/undo/{id}', function ($id) {

    if(!session('admin_id'))
    {
        return redirect('/');
    }

    $attendance = DB::table('guest_attendance')
        ->where('id',$id)
        ->first();

    if(!$attendance)
    {
        return back();
    }

    DB::table('attendance_undo_logs')
        ->insert([

            'attendance_id' => $attendance->id,

            'guest_id' => $attendance->guest_id,

            'undo_by' => session('admin_name'),

            'undo_reason' => 'Manual Undo',

            'created_at' => now('Asia/Kuala_Lumpur')

        ]);

    DB::table('guest_attendance')
        ->where('id',$id)
        ->delete();

    DB::table('guests')
        ->where(
            'id',
            $attendance->guest_id
        )
        ->update([

            'checkin_status' => 'pending',

            'checkin_time' => null,

            'updated_at' => now('Asia/Kuala_Lumpur')

        ]);

    return back()
        ->with(
            'success',
            'Check In berjaya dibatalkan'
        );

});


Route::get('/admin/attendance-undo-logs', function () {

    if(!session('admin_id'))
    {
        return redirect('/');
    }

    $logs = DB::table('attendance_undo_logs')
        ->leftJoin(
            'guests',
            'attendance_undo_logs.guest_id',
            '=',
            'guests.id'
        )
        ->select(
            'attendance_undo_logs.*',
            'guests.nama',
            'guests.company'
        )
        ->orderByDesc(
            'attendance_undo_logs.id'
        )
        ->get();

    return view(
        'admin.attendance_undo_logs',
        compact('logs')
    );

});


/*
|--------------------------------------------------------------------------
| Attendance Management
|--------------------------------------------------------------------------
*/
