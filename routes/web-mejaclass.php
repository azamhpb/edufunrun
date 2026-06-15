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


Route::get('/admin/classes', function () {

    if(!session('admin_id'))
    {
        return redirect('/admin/login');
    }

    $classes = DB::table('classes')
        ->orderByRaw('CAST(table_no AS UNSIGNED)')
        ->paginate(20);

    $guestCount = DB::table('guests')
        ->select(
            'class_code',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('class_code')
        ->pluck('total','class_code');

    foreach($classes as $class)
    {
        $class->used_pax =
            $guestCount[$class->class_code] ?? 0;

        $class->available =
            $class->max_pax -
            $class->used_pax;
    }

    return view(
        'admin.classes',
        compact('classes')
    );

});

Route::get(
'/admin/classes/{class_code}',
function($class_code){

    if(!session('admin_id'))
    {
        return redirect('/admin/login');
    }

    $guests = DB::table('guests')
        ->where(
            'class_code',
            $class_code
        )
        ->orderBy('nama')
        ->get();

    $tabledb = DB::table('classes')
        ->where('class_code', $class_code)
        ->first();


    return view(
        'admin.class_guest',
        compact(
            'guests',
            'class_code',
            'tabledb'
        )
    );

});

Route::get('/admin/floorplan', function(){

    if(!session('admin_id'))
    {
        return redirect('/admin/login');
    }

    $classes = DB::table('classes')->get();

    $guestCount = DB::table('guests')
        ->select(
            'class_code',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('class_code')
        ->pluck(
            'total',
            'class_code'
        );

    foreach($classes as $class)
    {
        $class->used_pax =
            $guestCount[$class->class_code] ?? 0;

        $class->percent =
            $class->max_pax > 0
            ? round(
                ($class->used_pax /
                $class->max_pax) * 100
            )
            : 0;
    }

    return view(
        'admin.floorplan',
        compact('classes')
    );

});

Route::get('/admin/classes/edit/{id}', function($id){

    $class = DB::table('classes')
        ->where('id',$id)
        ->first();

    return view(
        'admin.class_edit',
        compact('class')
    );

});

Route::post('/admin/classes/edit/{id}', function(Request $request, $id){

    DB::table('classes')
        ->where('id',$id)
        ->update([

            'max_pax' => $request->max_pax

        ]);

    return redirect('/admin/classes')
        ->with(
            'success',
            'Kapasiti berjaya dikemaskini'
        );

});


Route::get('/admin/classes/edit/{id}', function($id){

    $class = DB::table('classes')
        ->where('id',$id)
        ->first();

    return view(
        'admin.class_edit',
        compact('class')
    );

});

Route::post('/admin/classes/edit/{id}', function(Request $request, $id){

    DB::table('classes')
        ->where('id',$id)
        ->update([

            'max_pax' => $request->max_pax

        ]);

    return redirect('/admin/classes')
        ->with(
            'success',
            'Kapasiti berjaya dikemaskini'
        );

});