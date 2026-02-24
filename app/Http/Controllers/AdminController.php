<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use App\Models\Shift;
use App\Models\Group;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = [
            'total_user' => User::count(),
            'active_locations' => Location::where('status', 'Active')->count(),
            'active_shifts' => Shift::where('status', 'Active')->count(),
            'total_groups' => Group::count(),
            'recent_logs' => SystemLog::viewLog()->take(5),
            'satpam_users' => User::where('role', 'Satpam')->get(),
        ];

        return view('admin.dashboard', $data);
    }

    public function createUser(Request $request) {
        $user = User::createUser([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'role' => $request->role,
            'group_id' => null
        ]);

        SystemLog::recordLog([
            'user_id' => auth()->id(),
            'aksi' => 'Create User',
            'deskripsi' => "Admin membuat user baru: {$user->username}"
        ]);

        return back()->with('success', 'User berhasil ditambahkan!');
    }

    public function addLocation(Request $request) {
        Location::addLocation($request->all());
        SystemLog::recordLog([
            'user_id' => auth()->id(), 
            'aksi' => 'Add Location', 
            'deskripsi' => "Admin menambah lokasi: {$request->nama_lokasi}"
        ]);
        return back()->with('success', 'Lokasi berhasil ditambahkan!');
    }

    public function addShift(Request $request) {
        Shift::addShift($request->all());
        SystemLog::recordLog([
            'user_id' => auth()->id(), 
            'aksi' => 'Add Shift', 
            'deskripsi' => "Admin menambah shift: {$request->nama_shift}"
        ]);
        return back()->with('success', 'Shift berhasil ditambahkan!');
    }

    public function createGroup(Request $request) {
        $group = Group::createGroup(['nama_grup' => $request->nama_grup]);

        if ($request->has('satpam_ids') && is_array($request->satpam_ids)) {
            User::whereIn('id', $request->satpam_ids)->update(['group_id' => $group->id]);
        }

        SystemLog::recordLog([
            'user_id' => auth()->id(), 
            'aksi' => 'Create Group', 
            'deskripsi' => "Admin membuat grup: {$request->nama_grup}"
        ]);
        return back()->with('success', 'Grup berhasil dibuat!');
    }
}