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
