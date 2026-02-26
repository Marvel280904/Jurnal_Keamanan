<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Location;
use App\Models\Shift;
use App\Models\Group;
use App\Models\Journal;
use App\Models\Upload;
use Carbon\Carbon;

class JournalController extends Controller
{
    public function create()
    {
        $locations = Location::where('status', 'Active')->get();
        $shifts    = Shift::where('status', 'Active')->get();
        $groups    = Group::all();

        return view('satpam.journal_submission', compact('locations', 'shifts', 'groups'));
    }

    public function submitJournal(Request $request)
    {
        $request->validate([
            'lokasi_id'         => 'required|exists:locations,id',
            'shift_id'          => 'required|exists:shifts,id',
            'tanggal'           => 'required|date',
            'next_shift'        => 'required|exists:groups,id',
            'laporan_kegiatan'  => 'required|string',
            'kejadian_temuan'   => 'nullable|string',
            'lembur'            => 'nullable|string|max:100',
            'proyek_vendor'     => 'nullable|string',
            'barang_inven'      => 'nullable|string',
            'info_tambahan'     => 'nullable|string',
            'files.*'           => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ], [
            'lokasi_id.required'        => 'Lokasi wajib dipilih.',
            'lokasi_id.exists'          => 'Lokasi tidak valid.',
            'shift_id.required'         => 'Shift saat ini wajib dipilih.',
            'shift_id.exists'           => 'Shift saat ini tidak valid.',
            'tanggal.required'          => 'Tanggal wajib diisi.',
            'tanggal.date'              => 'Format tanggal tidak valid.',
            'next_shift.required'       => 'Shift berikutnya (Grup) wajib dipilih.',
            'next_shift.exists'         => 'Grup shift berikutnya tidak valid.',
            'laporan_kegiatan.required' => 'Laporan Kegiatan wajib diisi.',
            'files.*.mimes'             => 'Format file tidak didukung. Gunakan PDF, DOC, DOCX, JPG, atau PNG.',
            'files.*.max'               => 'Ukuran file maksimal 10MB.',
        ]);

        $user     = Auth::user();
        $group_id = $user->group_id;

        // Cek duplikat awal (untuk UX yang lebih baik)
        $duplicate = Journal::where('group_id', $group_id)
            ->whereDate('tanggal', $request->tanggal)
            ->exists();

        if ($duplicate) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Journal untuk grup Anda pada tanggal ' . Carbon::parse($request->tanggal)->format('d/m/Y') . ' sudah pernah disubmit. Tidak boleh ada jurnal duplikat.');
        }

        DB::beginTransaction();
        try {
            $journal = Journal::create([
                'tanggal'          => $request->tanggal,
                'user_id'          => $user->id,
                'group_id'         => $group_id,
                'lokasi_id'        => $request->lokasi_id,
                'shift_id'         => $request->shift_id,
                'next_shift'       => $request->next_shift,
                'laporan_kegiatan' => $request->laporan_kegiatan,
                'kejadian_temuan'  => $request->kejadian_temuan ?? '',
                'lembur'           => $request->lembur ?? '-',
                'proyek_vendor'    => $request->proyek_vendor ?? '',
                'barang_inven'     => $request->barang_inven ?? '',
                'info_tambahan'    => $request->info_tambahan,
                'status'           => 'Pending',
            ]);

            // Upload files jika ada
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    Upload::uploadFile($journal->id, $file);
                }
            }

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            // Handle Race Condition (Unique Constraint Violation)
            // Error code 23000 is for integrity constraint violation, and message usually contains 'Duplicate entry' or constraint name
            if ($e->getCode() == '23000') {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal submit: Journal untuk grup Anda pada tanggal ini baru saja dikirim oleh anggota tim lain. Sistem mencegah duplikasi data.');
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan database: ' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }

        return redirect()->route('satpam.log-history')
            ->with('success', 'Journal berhasil disubmit dan sedang menunggu persetujuan.');
    }
}
