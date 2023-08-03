<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $this->authorize('super-admin');
        $title = 'Device';
        return view('device.index', compact('title'));
    }
}
