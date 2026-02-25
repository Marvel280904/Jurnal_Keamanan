<?php

namespace App\Http\Controllers;

use App\Models\SystemLog;

class SystemLogController extends Controller
{
    /**
     * Tampilkan halaman System Logs.
     */
    public function index()
    {
        $logs = SystemLog::viewLog();

        return view('admin.system_log', compact('logs'));
    }
}

