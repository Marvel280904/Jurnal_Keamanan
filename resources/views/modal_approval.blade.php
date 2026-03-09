<!-- Modal Approval (Approve/Reject) -->
<div id="approvalModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden transform transition-all">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-2" id="approvalModalTitle">Confirm Action</h3>
            <p class="text-gray-600 text-sm mb-6" id="approvalModalMessage">Are you sure you want to proceed?</p>
            
            <form id="approvalForm" method="POST" action="">
                @csrf
                <input type="hidden" name="status" id="approvalStatusInput" value="">
                
                <div id="catatanContainer" class="hidden mb-4">
                    <label for="catatanInput" class="block text-sm font-bold text-gray-700 mb-1">Catatan Penolakan <span class="text-red-500">*</span></label>
                    <textarea required name="catatan" id="catatanInput" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all text-sm" placeholder="Jelaskan alasan kenapa jurnal ini ditolak..."></textarea>
                </div>
                
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeApprovalModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-bold rounded-xl transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="approvalSubmitBtn" class="px-4 py-2 text-white text-sm font-bold rounded-xl transition-colors">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openApprovalModal(journalId, action) {
        const modal = document.getElementById('approvalModal');
        const form = document.getElementById('approvalForm');
        const statusInput = document.getElementById('approvalStatusInput');
        const title = document.getElementById('approvalModalTitle');
        const submitBtn = document.getElementById('approvalSubmitBtn');
        const catatanContainer = document.getElementById('catatanContainer');
        const catatanInput = document.getElementById('catatanInput');
        
        // Let's also grab message since it was missing in the JS block you provided recently
        const message = document.getElementById('approvalModalMessage');

        // Set action route dynamic, replace PLACEHOLDER with id
        let routeTemplate = "{{ route('pga.journal.approve', ['id' => 'JDID']) }}";
        form.action = routeTemplate.replace('JDID', journalId);
        
        statusInput.value = action;
        catatanInput.value = ''; // Reset catatan

        if (action === 'Approved') {
            title.textContent = 'Approve Journal';
            message.textContent = 'Apakah anda yakin ingin menyetujui jurnal ini?';
            submitBtn.className = 'px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl transition-colors';
            submitBtn.innerHTML = 'Confirm Approve';
            catatanContainer.classList.add('hidden');
            catatanInput.removeAttribute('required');
        } else {
            title.textContent = 'Reject Journal';
            message.textContent = 'Apakah anda yakin ingin menolak jurnal ini? Tolong berikan alasan penolakan';
            submitBtn.className = 'px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl transition-colors';
            submitBtn.innerHTML = 'Confirm Reject';
            catatanContainer.classList.remove('hidden');
            catatanInput.setAttribute('required', 'required');
        }

        modal.classList.remove('hidden');
    }

    function closeApprovalModal() {
        document.getElementById('approvalModal').classList.add('hidden');
    }
</script>
