<!-- Bootstrap Style Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-3 max-w-sm w-full px-3 sm:px-0 pointer-events-none">

    {{-- Success Toast --}}
    @if (session('success'))
        <div class="toast-item pointer-events-auto bg-white rounded-lg shadow-xl border border-gray-200/90 overflow-hidden transition-all duration-300 transform translate-x-0" role="alert" aria-live="assertive" aria-atomic="true">
            <!-- Toast Header -->
            <div class="bg-gray-50 px-3.5 py-2 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-2 min-w-0">
                    <span class="w-3 h-3 rounded bg-emerald-500 shrink-0"></span>
                    <strong class="text-xs font-bold text-gray-900 truncate">Karate Polindra</strong>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <small class="text-[10px] text-gray-400 font-medium">baru saja</small>
                    <button type="button" onclick="closeBootstrapToast(this.closest('.toast-item'))" class="text-gray-400 hover:text-gray-700 p-0.5 rounded transition text-base leading-none font-bold" aria-label="Close">&times;</button>
                </div>
            </div>
            <!-- Toast Body -->
            <div class="p-3.5 text-xs sm:text-sm text-gray-700 font-medium leading-relaxed">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Error Toast --}}
    @if (session('error'))
        <div class="toast-item pointer-events-auto bg-white rounded-lg shadow-xl border border-gray-200/90 overflow-hidden transition-all duration-300 transform translate-x-0" role="alert" aria-live="assertive" aria-atomic="true">
            <!-- Toast Header -->
            <div class="bg-gray-50 px-3.5 py-2 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-2 min-w-0">
                    <span class="w-3 h-3 rounded bg-red-500 shrink-0"></span>
                    <strong class="text-xs font-bold text-gray-900 truncate">Karate Polindra</strong>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <small class="text-[10px] text-gray-400 font-medium">baru saja</small>
                    <button type="button" onclick="closeBootstrapToast(this.closest('.toast-item'))" class="text-gray-400 hover:text-gray-700 p-0.5 rounded transition text-base leading-none font-bold" aria-label="Close">&times;</button>
                </div>
            </div>
            <!-- Toast Body -->
            <div class="p-3.5 text-xs sm:text-sm text-gray-700 font-medium leading-relaxed">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Validation Errors Toast --}}
    @if ($errors->any())
        <div class="toast-item pointer-events-auto bg-white rounded-lg shadow-xl border border-gray-200/90 overflow-hidden transition-all duration-300 transform translate-x-0" role="alert" aria-live="assertive" aria-atomic="true">
            <!-- Toast Header -->
            <div class="bg-gray-50 px-3.5 py-2 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-2 min-w-0">
                    <span class="w-3 h-3 rounded bg-red-500 shrink-0"></span>
                    <strong class="text-xs font-bold text-gray-900 truncate">Periksa Inputan Form</strong>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <small class="text-[10px] text-gray-400 font-medium">baru saja</small>
                    <button type="button" onclick="closeBootstrapToast(this.closest('.toast-item'))" class="text-gray-400 hover:text-gray-700 p-0.5 rounded transition text-base leading-none font-bold" aria-label="Close">&times;</button>
                </div>
            </div>
            <!-- Toast Body -->
            <div class="p-3.5 text-xs text-gray-700 font-medium">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Warning Toast --}}
    @if (session('warning'))
        <div class="toast-item pointer-events-auto bg-white rounded-lg shadow-xl border border-gray-200/90 overflow-hidden transition-all duration-300 transform translate-x-0" role="alert" aria-live="assertive" aria-atomic="true">
            <!-- Toast Header -->
            <div class="bg-gray-50 px-3.5 py-2 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-2 min-w-0">
                    <span class="w-3 h-3 rounded bg-amber-500 shrink-0"></span>
                    <strong class="text-xs font-bold text-gray-900 truncate">Karate Polindra</strong>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <small class="text-[10px] text-gray-400 font-medium">baru saja</small>
                    <button type="button" onclick="closeBootstrapToast(this.closest('.toast-item'))" class="text-gray-400 hover:text-gray-700 p-0.5 rounded transition text-base leading-none font-bold" aria-label="Close">&times;</button>
                </div>
            </div>
            <!-- Toast Body -->
            <div class="p-3.5 text-xs sm:text-sm text-gray-700 font-medium leading-relaxed">
                {{ session('warning') }}
            </div>
        </div>
    @endif

    {{-- Info Toast --}}
    @if (session('info') || session('status'))
        <div class="toast-item pointer-events-auto bg-white rounded-lg shadow-xl border border-gray-200/90 overflow-hidden transition-all duration-300 transform translate-x-0" role="alert" aria-live="assertive" aria-atomic="true">
            <!-- Toast Header -->
            <div class="bg-gray-50 px-3.5 py-2 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-2 min-w-0">
                    <span class="w-3 h-3 rounded bg-blue-500 shrink-0"></span>
                    <strong class="text-xs font-bold text-gray-900 truncate">Karate Polindra</strong>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <small class="text-[10px] text-gray-400 font-medium">baru saja</small>
                    <button type="button" onclick="closeBootstrapToast(this.closest('.toast-item'))" class="text-gray-400 hover:text-gray-700 p-0.5 rounded transition text-base leading-none font-bold" aria-label="Close">&times;</button>
                </div>
            </div>
            <!-- Toast Body -->
            <div class="p-3.5 text-xs sm:text-sm text-gray-700 font-medium leading-relaxed">
                {{ session('info') ?? session('status') }}
            </div>
        </div>
    @endif

</div>

<script>
    function closeBootstrapToast(el) {
        if (!el) return;
        el.classList.add('opacity-0', 'translate-x-full');
        setTimeout(() => {
            el.remove();
        }, 300);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const toasts = document.querySelectorAll('.toast-item');
        toasts.forEach((toast) => {
            setTimeout(() => {
                closeBootstrapToast(toast);
            }, 6000);
        });
    });
</script>
