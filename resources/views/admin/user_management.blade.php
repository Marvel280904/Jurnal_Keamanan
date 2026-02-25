@extends('layouts.app')

@section('title', 'User & Role Management')

@section('content')

{{-- Page Title --}}
<h1 class="text-2xl font-bold text-gray-800 mb-5">User & Role Management</h1>

{{-- Table Card --}}
<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-base font-bold text-gray-800">Users</h2>
        <button onclick="openModalUser()"
            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            <span class="text-lg leading-none">+</span> Add User
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-700 font-bold border-b border-gray-100">
                    <th class="pb-3 pr-6">Name</th>
                    <th class="pb-3 pr-6">Username</th>
                    <th class="pb-3 pr-6">Role</th>
                    <th class="pb-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="py-3.5 pr-6 font-semibold text-gray-800">{{ $user->nama }}</td>
                    <td class="py-3.5 pr-6 text-gray-500">{{ $user->username }}</td>
                    <td class="py-3.5 pr-6">
                        @php
                            $roleColor = match($user->role) {
                                'Admin'  => 'bg-blue-100 text-blue-700',
                                'Satpam' => 'bg-green-100 text-green-700',
                                'PGA'    => 'bg-purple-100 text-purple-700',
                                default  => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $roleColor }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="py-3.5 text-right">
                        <div class="flex items-center justify-end gap-3">
                            {{-- Edit: Kirim semua data ke fungsi JS --}}
                            <button onclick="openModalUser({{ $user->id }}, '{{ addslashes($user->nama) }}', '{{ addslashes($user->username) }}', '{{ $user->role }}')"
                                class="text-gray-500 hover:text-blue-600 transition text-base">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            
                            {{-- Delete --}}
                            <button onclick="openModalDelete('/admin/user/{{ $user->id }}', '{{ addslashes($user->nama) }}', 'User')"
                                class="text-red-400 hover:text-red-600 transition text-base {{ $user->id === auth()->id() ? 'opacity-30 cursor-not-allowed' : '' }}"
                                @if($user->id === auth()->id()) disabled @endif>
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="py-10 text-center text-gray-400 text-sm">Belum ada data user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('admin.modals.modal_user')
@include('admin.modals.modal_delete')

<script>
    /* Fungsi Modal User (Add/Edit) */
    function openModalUser(id = null, nama = '', username = '', role = 'Admin') {
        const modal = document.getElementById('modalUser');
        const form = document.getElementById('formUser');
        const title = document.getElementById('modalTitle');
        const methodInput = document.getElementById('methodField');
        const passNote = document.getElementById('passwordNote');
        const passReq = document.getElementById('passwordInput');

        form.reset();

        if (id) {
            title.innerText = 'Edit User';
            form.action = `/admin/user/${id}`;
            methodInput.value = 'PUT';
            document.getElementById('inputNama').value = nama;
            document.getElementById('inputUsername').value = username;
            document.getElementById('inputRole').value = role;
            passNote.classList.remove('hidden');
            passReq.required = false;
        } else {
            title.innerText = 'Add User';
            form.action = "{{ route('admin.user.store') }}";
            methodInput.value = 'POST';
            passNote.classList.add('hidden');
            passReq.required = true;
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModalUser() {
        document.getElementById('modalUser').classList.add('hidden');
        document.getElementById('modalUser').classList.remove('flex');
    }

    /* Fungsi Modal Delete */
    function openModalDelete(actionUrl, name, entity = 'User') {
        const modal = document.getElementById('modalDelete');
        const form = document.getElementById('formDelete');
        
        // Isi konten dinamis
        form.action = actionUrl;
        document.getElementById('deleteTitle').innerText = 'Hapus ' + entity + '?';
        document.getElementById('deleteEntityLabel').innerText = entity.toLowerCase();
        document.getElementById('deleteNameLabel').innerText = `"${name}"`;

        // Tampilkan modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModalDelete() {
        document.getElementById('modalDelete').classList.add('hidden');
        document.getElementById('modalDelete').classList.remove('flex');
    }

    // Auto-open modal User jika ada error validasi
    @if($errors->any())
        window.onload = () => {
            document.getElementById('modalUser').classList.remove('hidden');
            document.getElementById('modalUser').classList.add('flex');
        };
    @endif
</script>

@endsection