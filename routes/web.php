
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
| DATABASE TEST
|--------------------------------------------------------------------------
*/

Route::get('/db-test', function () {

    \DB::table('attendances')->insert([

        'qr_code' => 'SERVER_TEST',

        'scan_time' => now(),

        'created_at' => now(),

        'updated_at' => now()

    ]);

    return 'DATABASE CONNECTED';

});

/*
|--------------------------------------------------------------------------
| ADMIN LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

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

    return response()->json([

        'attendanceToday' => Attendance::whereDate(
            'scan_time',
            today('Asia/Kuala_Lumpur')
        )->count(),

        'totalAttendance' => Attendance::count()

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

        'created_at' => now(),

        'updated_at' => now()

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

        'updated_at' => now()

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

        'updated_at' => now()

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


Route::get('/guest_screen_tv/{scanner_id}', function ($scanner_id) {

    return view(
        'guest_screen_tv',
        compact('scanner_id')
    );

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
        return redirect('/admin/login');
    }

    $guests = DB::table('guests')
        ->orderBy('id','desc')
        ->paginate(20);

    return view(
        'admin.guest',
        compact('guests')
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

    DB::table('guests')->insert([

        'attendance_id' => $request->attendance_id,

        'nama' => $request->nama,

        'company' => $request->company,

        'class_code' => $request->class_code,

        'table_no' => $request->table_no,

        'qr_token' => Str::uuid(),

        'checkin_status' => 'pending',

        'created_at' => now(),

        'updated_at' => now()

    ]);

    return redirect('/admin/guest');

});



/*
|--------------------------------------------------------------------------
| GUEST MANAGEMENT
|--------------------------------------------------------------------------
*/