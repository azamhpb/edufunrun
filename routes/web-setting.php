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
use App\Http\Controllers\SettingController;
use App\Exports\GalaDinnerExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/admin/settings', function(){
    
    if(session('admin_level') != 'superadmin')
    {
        abort(403);
    }

    
    $setting = DB::table('settings')
        ->first();

    return view(
        'admin.settings',
        compact('setting')
    );

});

Route::post('/admin/settings', function(Request $request){

    DB::table('settings')
    ->where('id',1)
    ->update([

        'admin_phone' =>
            $request->admin_phone,

        'email_to' =>
            $request->email_to,

        'email_cc' =>
            $request->email_cc,

        'email_bcc' =>
            $request->email_bcc,

        'gala_program' =>
            $request->gala_program,

        'updated_at' =>
            now('Asia/Kuala_Lumpur')

    ]);

    return back()
        ->with(
            'success',
            'Settings berjaya disimpan'
        );

});