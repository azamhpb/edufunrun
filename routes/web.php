
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
use App\Http\Controllers\mejaclassController;







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


Route::get('/test-gmail', function () {

    Mail::raw('Test Email', function($m){

        $m->to('azamhpb@gmail.com')
          ->subject('TEST');

    });

    return 'OK';

});

Route::get('/test-mail-config', function () {

    dd(config('mail.mailers.smtp'));

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

Route::get('/admin/live-table-summary', function(){

    $diamond_used = DB::table('guests')
        ->where('class_code','like','DIAMOND%')
        ->count();

    $diamond_max = DB::table('classes')
        ->where('class_code','like','DIAMOND%')
        ->sum('max_pax');

    $platinum_used = DB::table('guests')
        ->where('class_code','like','PLATINUM%')
        ->count();

    $platinum_max = DB::table('classes')
        ->where('class_code','like','PLATINUM%')
        ->sum('max_pax');

    $gold_used = DB::table('guests')
        ->where('class_code','like','GOLD%')
        ->count();

    $gold_max = DB::table('classes')
        ->where('class_code','like','GOLD%')
        ->sum('max_pax');

    $silver_used = DB::table('guests')
        ->where('class_code','like','SILVER%')
        ->count();

    $silver_max = DB::table('classes')
        ->where('class_code','like','SILVER%')
        ->sum('max_pax');

    return response()->json([

        'diamond_used' => $diamond_used,
        'diamond_max'  => $diamond_max,

        'platinum_used' => $platinum_used,
        'platinum_max'  => $platinum_max,

        'gold_used' => $gold_used,
        'gold_max'  => $gold_max,

        'silver_used' => $silver_used,
        'silver_max'  => $silver_max

    ]);

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
| CARD JEMPUTAN
|--------------------------------------------------------------------------
*/



Route::get('/c/{id}', function ($id) {

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
        ->where('qr_token', $id)
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


/*
|--------------------------------------------------------------------------
| VIP CHECK-IN NOTIFICATION
|--------------------------------------------------------------------------
*/

Route::get('/guest-checkin/{id}/{scanner}', function($id, $scanner){

    $guest = DB::table('guests')
        ->where('id',$id)
        ->first();

    // simpan attendance

    if(
        str_starts_with(
            $guest->class_code,
            'DIAMOND'
        )
        ||
        str_starts_with(
            $guest->class_code,
            'PLATINUM'
        )
    )
    {

        Mail::send(

            'emails.vip_checkin',

            [

                'guest' => $guest,

                'scanner' => 'Scanner '.$scanner

            ],

            function($mail) use ($guest){

                $mail
                    ->to('azam.yayasanangkasa@gmail.com')
                    ->bcc('azamhpb@gmail.com')
                    ->subject(
                        '[VIP CHECK-IN] '.$guest->nama . ' (TIME ' . now('Asia/Kuala_Lumpur')->format('d/m/Y h:i A') . ')'
                    );

            }

        );


        // SMS dekat admin 
        

        $message =
        "VIP CHECK-IN\n\n".
        "Nama: ".$guest->nama."\n".
        "Kategori: ".$guest->class_code."\n".
        "Meja: ".$guest->table_no."\n".
        "Telefon: ".$guest->phone_no."\n".
        "Scanner: ".$scanner."\n\n".
        "Masa:\n".
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

        


    }

});


Route::get('/guest-new/{id}/{adminName}', function($id, $adminName){

    $guest = DB::table('guests')
        ->where('attendance_id',$id)
        ->first();

    if(!$guest)
    {
        return 'Guest Not Found';
    }

    // EMAIL ADMIN

    Mail::send(

        'emails.guest_new',

        [

            'guest'     => $guest,

            'adminName' => $adminName

        ],

        function($mail) use ($guest){

            $mail
                ->to('azam.yayasanangkasa@gmail.com')
                ->bcc('azamhpb@gmail.com')
                ->subject(
                    '[NEW GUEST] '.$guest->nama.
                    ' ('.now('Asia/Kuala_Lumpur')->format('d/m/Y h:i A').')'
                );

        }

    );

    // SMS ADMIN

    $message =
    "NEW GUEST REGISTRATION\n\n".
    "Nama: ".$guest->nama."\n".
    "Company: ".$guest->company."\n".
    "Kategori: ".$guest->class_code."\n".
    "Meja: ".$guest->table_no."\n".
    "Telefon: ".$guest->phone_no."\n".
    "Admin Create: ".$adminName."\n\n".
    "Masa:\n".
    now('Asia/Kuala_Lumpur')->format('d/m/Y h:i A');

    $api_url =
    "http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?".
    http_build_query([

        'api_key'      => 'e998433bf9918a7ea56479af11b106e43d587294e573741ed1b318163a6610e6',
        'action'       => 'send',
        'to'           => '60127743756',
        'msg'          => $message,
        'sender_id'    => 'CLOUDSMS',
        'content_type' => '1',
        'mode'         => 'shortcode',
        'campaign'     => 'GALASABAH2026'

    ]);

    @file_get_contents($api_url);

    return 'OK';

});

/*
|--------------------------------------------------------------------------
| VIP CHECK-IN NOTIFICATION
|--------------------------------------------------------------------------
*/