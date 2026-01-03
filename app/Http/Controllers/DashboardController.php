<?php

namespace App\Http\Controllers;

use App\Models\ServiceApplication;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total' => ServiceApplication::where('user_id', $user->id)->count(),
            'pending' => ServiceApplication::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved' => ServiceApplication::where('user_id', $user->id)->where('status', 'approved')->count(),
        ];

        $recentApplications = ServiceApplication::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $notifications = $user->notifications()->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentApplications', 'notifications'));
    }
}
