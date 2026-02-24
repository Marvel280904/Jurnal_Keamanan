@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div x-data="{ modalUser: false, modalLoc: false, modalShift: false, modalGroup: false }">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Users</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $total_user }}</h3>
            </div>
            <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">
                <i class="bi bi-people text-blue-500 text-2xl"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Active Locations</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $active_locations }}</h3>
            </div>
            <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center">
                <i class="bi bi-geo-alt text-green-500 text-2xl"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Active Shifts</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $active_shifts }}</h3>
            </div>
            <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center">
                <i class="bi bi-clock text-purple-500 text-2xl"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Groups</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $total_groups }}</h3>
            </div>
            <div class="w-14 h-14 rounded-xl bg-orange-100 flex items-center justify-center">
                <i class="bi bi-person-badge text-orange-500 text-2xl"></i>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
        <h4 class="text-base font-bold text-gray-800 mb-4">Quick Actions</h4>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <button @click="modalUser = true" class="bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-lg flex flex-col items-center justify-center transition">
                <span class="text-2xl font-light mb-1">+</span>
                <span class="text-sm font-semibold">Add User</span>
            </button>
            <button @click="modalLoc = true" class="bg-green-600 hover:bg-green-700 text-white py-4 rounded-lg flex flex-col items-center justify-center transition">
                <span class="text-2xl font-light mb-1">+</span>
                <span class="text-sm font-semibold">Add Location</span>
            </button>
            <button @click="modalShift = true" class="bg-purple-600 hover:bg-purple-700 text-white py-4 rounded-lg flex flex-col items-center justify-center transition">
                <span class="text-2xl font-light mb-1">+</span>
                <span class="text-sm font-semibold">Add Shift</span>
            </button>
            <button @click="modalGroup = true" class="bg-orange-600 hover:bg-orange-700 text-white py-4 rounded-lg flex flex-col items-center justify-center transition">
                <span class="text-2xl font-light mb-1">+</span>
                <span class="text-sm font-semibold">Create Group</span>
            </button>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="bg-white p-6 rounded-xl shadow-sm">
        <h4 class="text-base font-bold text-gray-800 mb-4">Recent Activity</h4>
        <div class="space-y-4">
            @foreach($recent_logs as $log)
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-3">
                    <span class="mt-1.5 w-2 h-2 rounded-full bg-blue-500 flex-shrink-0"></span>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $log->user->nama }}</p>
                        <p class="text-sm text-gray-500">{{ $log->deskripsi }}</p>
                        <span class="inline-block mt-1 text-xs uppercase tracking-wide border border-gray-300 text-gray-600 px-2 py-0.5 rounded">{{ $log->aksi }}</span>
                    </div>
                </div>
                <span class="text-xs text-gray-400 whitespace-nowrap ml-4">{{ $log->created_at->format('d M Y, H:i') }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Modal: Add User --}}
    <div x-show="modalUser" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/50">
        <div @click.away="modalUser = false" class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold mb-4">Add New User</h3>
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" placeholder="Masukkan username" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" placeholder="Masukkan password" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Masukkan nama lengkap" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" class="w-full p-2 border rounded">
                        <option value="Admin">Admin</option>
                        <option value="Satpam">Satpam</option>
                        <option value="PGA">PGA</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="modalUser = false" class="px-4 py-2 text-gray-500">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save User</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Add Location --}}
    <div x-show="modalLoc" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/50">
        <div @click.away="modalLoc = false" class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold mb-4">Add Location</h3>
            <form action="{{ route('admin.location.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lokasi</label>
                    <input type="text" name="nama_lokasi" placeholder="Masukkan nama lokasi" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="alamat_lokasi" placeholder="Masukkan alamat lokasi" class="w-full p-2 border rounded" rows="3"></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="modalLoc = false" class="px-4 py-2 text-gray-500">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save Location</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Add Shift --}}
    <div x-show="modalShift" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/50">
        <div @click.away="modalShift = false" class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold mb-4">Add Shift</h3>
            <form action="{{ route('admin.shift.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Shift</label>
                    <input type="text" name="nama_shift" placeholder="Masukkan nama shift" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                    <input type="time" name="mulai_shift" class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                    <input type="time" name="selesai_shift" class="w-full p-2 border rounded">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="modalShift = false" class="px-4 py-2 text-gray-500">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded">Save Shift</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Create Group --}}
    <div x-show="modalGroup" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/50">
        <div @click.away="modalGroup = false" class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold mb-4">Create Group</h3>
            <form action="{{ route('admin.group.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Grup</label>
                    <input type="text" name="nama_grup" placeholder="Masukkan nama grup" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Anggota Satpam</label>
                    <div class="border rounded max-h-48 overflow-y-auto divide-y">
                        @forelse($satpam_users as $satpam)
                            <label class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="satpam_ids[]" value="{{ $satpam->id }}" class="w-4 h-4 text-blue-600 rounded">
                                <span class="text-sm text-gray-800">{{ $satpam->nama }}</span>
                            </label>
                        @empty
                            <p class="text-sm text-gray-400 px-3 py-2">Tidak ada user Satpam.</p>
                        @endforelse
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="modalGroup = false" class="px-4 py-2 text-gray-500">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded">Save Group</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection