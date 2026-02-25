{{-- Modal: Add / Edit Location (Unified) --}}
{{-- Requires Alpine state: modalLoc, editLocId, editLocName, editLocAddress --}}
{{-- Add mode  : modalLoc = true (editLocId stays null)                      --}}
{{-- Edit mode : modalLoc = true, editLocId = {id}, editLocName, editLocAddress set --}}

<div id="modalLoc" class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-black/50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">

        {{-- Title berubah sesuai mode --}}
        <h3 id="modalLocTitle" class="text-xl font-bold mb-5 text-gray-800">Add Location</h3>

        {{-- Form action & _method berubah sesuai mode --}}
        <form id="formLoc" action="" method="POST">
            @csrf
            {{-- Spoof method: PUT untuk edit, POST untuk add --}}
            <input type="hidden" name="_method" id="methodLoc" value="POST">

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Lokasi <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="inputLocName"
                    name="nama_lokasi"
                    placeholder="Masukkan nama lokasi"
                    class="w-full p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                    required>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea
                    id="inputLocAddress"
                    name="alamat_lokasi"
                    placeholder="Masukkan alamat lokasi"
                    required
                    class="w-full p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                    rows="3"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button
                    type="button"
                    onclick="closeModalLoc()"
                    class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
