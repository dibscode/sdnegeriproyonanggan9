<div id="confirm-delete-overlay" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full">
        <div class="px-6 py-4">
            <h3 class="text-lg font-medium">Konfirmasi Hapus</h3>
            <p class="mt-2 text-sm text-gray-600">Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="mt-4 flex justify-end space-x-2">
                <button id="confirm-delete-cancel" class="px-3 py-2 bg-gray-200 rounded">Batal</button>
                <button id="confirm-delete-yes" class="px-3 py-2 bg-red-600 text-white rounded">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    (function(){
        var overlay = document.getElementById('confirm-delete-overlay');
        var cancel = document.getElementById('confirm-delete-cancel');
        var yes = document.getElementById('confirm-delete-yes');
        var currentForm = null;
        if(!overlay) return;
        function show(form){ currentForm = form; overlay.classList.remove('hidden'); }
        function hide(){ currentForm=null; overlay.classList.add('hidden'); }
        // Delegate clicks on delete buttons
        document.addEventListener('click', function(e){
            var btn = e.target.closest('[data-confirm-delete]');
            if(!btn) return;
            e.preventDefault();
            var formSelector = btn.getAttribute('data-target-form');
            var form = formSelector ? document.querySelector(formSelector) : btn.closest('form');
            if(!form) return;
            show(form);
        });
        cancel && cancel.addEventListener('click', hide);
        yes && yes.addEventListener('click', function(){ if(currentForm) currentForm.submit(); hide(); });
        document.addEventListener('keydown', function(e){ if(e.key==='Escape') hide(); });
    })();
</script>
