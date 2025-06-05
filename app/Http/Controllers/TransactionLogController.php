<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionLog;

class TransactionLogController extends Controller
{
     public function index()
    {
        $logs = TransactionLog::orderBy('date', 'desc')->take(10)->get();
        return view('admin.dashboard', compact('logs'));
    }
}
