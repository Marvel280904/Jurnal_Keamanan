<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Shift;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class LocationShiftController extends Controller
{
    // ─── Index ───────────────────────────────────────────────────────────────

    public function index()
    {
        $locations = Location::orderBy('created_at', 'desc')->get();
        $shifts    = Shift::orderBy('created_at', 'desc')->get();

        return view('admin.location_shift', compact('locations', 'shifts'));
    }

    // ─── Location ─────────────────────────────────────────────────────────────

    public function addLocation(Request $request)
    {
        $request->validate([
            'nama_lokasi'   => 'required|string|max:255',
            'alamat_lokasi' => 'nullable|string',
        ]);

        $location = Location::create([
            'nama_lokasi'   => $request->nama_lokasi,
            'alamat_lokasi' => $request->alamat_lokasi,
        ]);

        SystemLog::recordLog([
            'user_id'   => auth()->id(),
            'aksi'      => 'Create',
            'deskripsi' => "Admin menambah lokasi: {$location->nama_lokasi}",
        ]);

        return redirect()->route('admin.location-shift')->with('success', 'Lokasi berhasil ditambahkan!');
    }

    public function editLocation(Request $request, Location $location)
    {
        $request->validate([
            'nama_lokasi'   => 'required|string|max:255',
            'alamat_lokasi' => 'nullable|string',
        ]);

        $location->update([
            'nama_lokasi'   => $request->nama_lokasi,
            'alamat_lokasi' => $request->alamat_lokasi,
        ]);

        SystemLog::recordLog([
            'user_id'   => auth()->id(),
            'aksi'      => 'Update',
            'deskripsi' => "Admin mengubah lokasi: {$location->nama_lokasi}",
        ]);

        return redirect()->route('admin.location-shift')->with('success', 'Lokasi berhasil diperbarui!');
    }

    public function updateLocationStatus(Location $location)
    {
        $newStatus = $location->status === 'Active' ? 'Inactive' : 'Active';
        $location->update(['status' => $newStatus]);

        SystemLog::recordLog([
            'user_id'   => auth()->id(),
            'aksi'      => 'Change Status',
            'deskripsi' => "Admin mengubah status lokasi '{$location->nama_lokasi}' menjadi {$newStatus}",
        ]);

        return redirect()->route('admin.location-shift')->with('success', "Status lokasi diubah menjadi {$newStatus}!");
    }

    public function deleteLocation(Location $location)
    {
        $nama = $location->nama_lokasi;
        $location->delete();

        SystemLog::recordLog([
            'user_id'   => auth()->id(),
            'aksi'      => 'Delete',
            'deskripsi' => "Admin menghapus lokasi: {$nama}",
        ]);

        return redirect()->route('admin.location-shift')->with('success', 'Lokasi berhasil dihapus!');
    }

    // ─── Shift ────────────────────────────────────────────────────────────────

    public function addShift(Request $request)
    {
        $request->validate([
            'nama_shift'    => 'required|string|max:255',
            'mulai_shift'   => 'required',
            'selesai_shift' => 'required',
        ]);

        $shift = Shift::create([
            'nama_shift'    => $request->nama_shift,
            'mulai_shift'   => $request->mulai_shift,
            'selesai_shift' => $request->selesai_shift,
        ]);

        SystemLog::recordLog([
            'user_id'   => auth()->id(),
            'aksi'      => 'Create',
            'deskripsi' => "Admin menambah shift: {$shift->nama_shift}",
        ]);

        return redirect()->route('admin.location-shift', ['tab' => 'shifts'])->with('success', 'Shift berhasil ditambahkan!');
    }

    public function editShift(Request $request, Shift $shift)
    {
        $request->validate([
            'nama_shift'    => 'required|string|max:255',
            'mulai_shift'   => 'required',
            'selesai_shift' => 'required',
        ]);

        $shift->update([
            'nama_shift'    => $request->nama_shift,
            'mulai_shift'   => $request->mulai_shift,
            'selesai_shift' => $request->selesai_shift,
        ]);

        SystemLog::recordLog([
            'user_id'   => auth()->id(),
            'aksi'      => 'Update',
            'deskripsi' => "Admin mengubah shift: {$shift->nama_shift}",
        ]);

        return redirect()->route('admin.location-shift', ['tab' => 'shifts'])->with('success', 'Shift berhasil diperbarui!');
    }

    public function updateShiftStatus(Shift $shift)
    {
        $newStatus = $shift->status === 'Active' ? 'Inactive' : 'Active';
        $shift->update(['status' => $newStatus]);

        SystemLog::recordLog([
            'user_id'   => auth()->id(),
            'aksi'      => 'Change Status',
            'deskripsi' => "Admin mengubah status shift '{$shift->nama_shift}' menjadi {$newStatus}",
        ]);

        return redirect()->route('admin.location-shift', ['tab' => 'shifts'])->with('success', "Status shift diubah menjadi {$newStatus}!");
    }

    public function deleteShift(Shift $shift)
    {
        $nama = $shift->nama_shift;
        $shift->delete();

        SystemLog::recordLog([
            'user_id'   => auth()->id(),
            'aksi'      => 'Delete',
            'deskripsi' => "Admin menghapus shift: {$nama}",
        ]);

        return redirect()->route('admin.location-shift', ['tab' => 'shifts'])->with('success', 'Shift berhasil dihapus!');
    }
}
