{{-- Modal: Delete Confirmation (Vanilla JS Reusable) --}}
<div id="modalDelete" class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-black/50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6 text-center">

        {{-- Icon --}}
        <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
            <i class="bi bi-trash text-red-500 text-2xl"></i>
        </div>

        {{-- Judul Dinamis --}}
        <h3 id="deleteTitle" class="text-lg font-bold text-gray-800 mb-1">Hapus Data?</h3>

        {{-- Deskripsi Dinamis --}}
        <p class="text-sm text-gray-500 mb-5">
            Anda yakin ingin menghapus <span id="deleteEntityLabel"></span> 
            <span id="deleteNameLabel" class="font-semibold text-gray-700"></span>?
            Tindakan ini tidak dapat dibatalkan.
        </p>

        {{-- Form Action Dinamis --}}
        <form id="formDelete" action="" method="POST" class="flex justify-center gap-3">
            @csrf
            @method('DELETE')
            
            <button type="button" onclick="closeModalDelete()"
                class="px-5 py-2 text-sm border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition">
                Batal
            </button>
            <button type="submit"
                class="px-5 py-2 text-sm bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>