<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SatpamController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $group_id = $user->group_id;
        $today = Carbon::today();

        // Journals to submit today
        $journals_to_submit = Journal::where('next_shift', $group_id)
            ->whereDate('tanggal', $today)
            ->count();

        // Pending journals
        $pending_journals = Journal::where('group_id', $group_id)
            ->where('status', 'Pending')
            ->count();

        // Waiting approval
        $waiting_approval = Journal::where('next_shift', $group_id)
            ->where('status', 'Pending')
            ->count();

        // My Group
        $my_group = User::where('group_id', $group_id)
            ->whereNotNull('group_id')
            ->get();

        // Recent Submissions
        $recent_submissions = Journal::with(['user', 'group', 'location', 'shift', 'nextShift'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('satpam.dashboard', compact(
            'journals_to_submit',
            'pending_journals',
            'waiting_approval',
            'my_group',
            'recent_submissions'
        ));
    }
}
