@php
    $success = session('success');
    $error = session('error');
    $has = $success || $error;
    $type = $success ? 'success' : 'error';
    $message = $success ?? $error ?? null;
@endphp

@if($has)
    <div id="flash-modal-overlay" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div id="flash-modal" class="max-w-lg w-full bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @if($type === 'success')
                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @else
                            <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @endif
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $type === 'success' ? 'Sukses' : 'Gagal' }}</p>
                        <p class="mt-1 text-sm text-gray-600">{{ $message }}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0 self-start">
                        <button id="flash-modal-close" class="inline-flex items-center px-2 py-1 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function(){
            var overlay = document.getElementById('flash-modal-overlay');
            var close = document.getElementById('flash-modal-close');
            if(!overlay) return;
            function hide(){ overlay.style.display = 'none'; }
            close && close.addEventListener('click', hide);
            // auto close after 4 seconds
            setTimeout(hide, 4000);
            // close on ESC
            document.addEventListener('keydown', function(e){ if(e.key === 'Escape') hide(); });
        })();
    </script>
@endif
