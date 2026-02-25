@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div x-data="{
    modalUser: false,
    editUserId: null, editUserName: '', editUsername: '', editUserRole: '',
    modalGroup: false,
    editGroupId: null, editGroupName: '', editGroupDescription: '',
    modalLoc: false,
    editLocId: null, editLocName: '', editLocAddress: '',
    modalShift: false,
    editShiftId: null, editShiftName: '', editShiftStart: '', editShiftEnd: ''
}">

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
            <button @click="editLocId = null; editLocName = ''; editLocAddress = ''; modalLoc = true" class="bg-green-600 hover:bg-green-700 text-white py-4 rounded-lg flex flex-col items-center justify-center transition">
                <span class="text-2xl font-light mb-1">+</span>
                <span class="text-sm font-semibold">Add Location</span>
            </button>
            <button @click="editShiftId = null; editShiftName = ''; editShiftStart = ''; editShiftEnd = ''; modalShift = true" class="bg-purple-600 hover:bg-purple-700 text-white py-4 rounded-lg flex flex-col items-center justify-center transition">
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

    {{-- Modals --}}
    @include('admin.modals.modal_user')
    @include('admin.modals.modal_location')
    @include('admin.modals.modal_shift')
    @include('admin.modals.modal_group')

</div>
@endsection