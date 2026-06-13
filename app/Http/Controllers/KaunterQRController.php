<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KaunterQRController extends Controller
{
    public function index()
    {
        return 'Senarai Tetamu';
    }

    public function create()
    {
        return 'Tambah Tetamu';
    }
}
