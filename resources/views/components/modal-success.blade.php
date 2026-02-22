{{-- Modal Success - Compact Version --}}
<div 
    id="successModal" 
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modalTitle"
>
    <div 
        id="modalContent"
        class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform transition-all scale-95 opacity-0 duration-300 relative"
    >
        <!-- Decorative gradient background -->
        <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-br from-emerald-50 to-green-50 opacity-50"></div>
        
        <!-- Content -->
        <div class="relative pt-8 pb-5 text-center px-5">
            <!-- Success Icon with animation -->
            <div class="mx-auto flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-400 to-green-500 rounded-full mb-3 shadow-lg animate-scale-in">
                <svg class="w-8 h-8 text-white animate-check-draw" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <!-- Title -->
            <h3 id="modalTitle" class="text-xl font-display font-bold text-gray-900 tracking-tight mb-1">
                Laporan Terkirim!
            </h3>
            <p class="text-gray-500 text-xs mb-4">
                Simpan kode laporan Anda
            </p>
        </div>

        <!-- Code Section -->
        <div class="px-5 pb-6">
            <div class="relative mb-4">
                <!-- Secret Badge -->
                <span class="absolute -top-2.5 right-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-[9px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider shadow-md z-10 animate-pulse-subtle">
                    Rahasia
                </span>
                
                <!-- Code Container -->
                <div class="flex items-center justify-between bg-gradient-to-br from-gray-50 to-emerald-50/30 border-2 border-emerald-200 rounded-xl p-3.5 group hover:border-emerald-400 hover:shadow-md transition-all duration-300">
                    <span id="reportCode" class="text-base font-mono font-bold text-emerald-700 tracking-wider select-all">
                        KRF-210325-XXXX
                    </span>
                    <button 
                        onclick="copyToClipboard()" 
                        class="p-1.5 hover:bg-emerald-100 rounded-lg text-gray-500 hover:text-emerald-600 transition-all active:scale-90 flex-shrink-0 group/btn" 
                        title="Salin Kode"
                        aria-label="Salin kode laporan"
                    >
                        <svg class="w-4 h-4 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Copy feedback -->
                <div id="copyFeedback" class="absolute -bottom-7 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-[10px] px-2.5 py-1 rounded-md opacity-0 transition-opacity pointer-events-none whitespace-nowrap">
                    Kode disalin! ✓
                </div>
            </div>

            <!-- Info box - more compact -->
            <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 mb-4">
                <p class="text-[11px] text-blue-700 leading-relaxed text-center">
                    Gunakan kode ini untuk melacak status laporan. <br/>Simpan dengan aman.
                </p>
            </div>

            <!-- Close Button -->
            <button 
                onclick="closeReportModal()" 
                class="w-full py-2.5 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-semibold text-sm hover:from-emerald-600 hover:to-green-700 transition-all active:scale-[0.98] shadow-md hover:shadow-lg"
            >
                Tutup
            </button>
        </div>
    </div>
</div>

<style>
/* Modal animations */
@keyframes scale-in {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes check-draw {
    0% {
        stroke-dasharray: 0, 100;
        opacity: 0;
    }
    50% {
        opacity: 1;
    }
    100% {
        stroke-dasharray: 100, 0;
        opacity: 1;
    }
}

@keyframes pulse-subtle {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

.animate-scale-in {
    animation: scale-in 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.animate-check-draw {
    animation: check-draw 0.6s ease-in-out 0.2s both;
}

.animate-pulse-subtle {
    animation: pulse-subtle 2s ease-in-out infinite;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    #reportCode {
        font-size: 0.875rem;
        letter-spacing: 0.1em;
    }
}
</style>

<script>
    function openReportModal(code) {
        const modal = document.getElementById('successModal');
        const content = document.getElementById('modalContent');
        const codeElement = document.getElementById('reportCode');
        
        codeElement.innerText = code;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
        
        // Trigger animation
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeReportModal() {
        const modal = document.getElementById('successModal');
        const content = document.getElementById('modalContent');
        
        content.classList.add('scale-95', 'opacity-0');
        content.classList.remove('scale-100', 'opacity-100');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            // Restore body scroll
            document.body.style.overflow = '';
        }, 300);
    }

    function copyToClipboard() {
        const code = document.getElementById('reportCode').innerText;
        const feedback = document.getElementById('copyFeedback');
        
        navigator.clipboard.writeText(code).then(() => {
            // Show feedback
            feedback.classList.remove('opacity-0');
            feedback.classList.add('opacity-100');
            
            // Hide after 2 seconds
            setTimeout(() => {
                feedback.classList.remove('opacity-100');
                feedback.classList.add('opacity-0');
            }, 2000);
        }).catch(err => {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = code;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            
            feedback.classList.remove('opacity-0');
            feedback.classList.add('opacity-100');
            setTimeout(() => {
                feedback.classList.remove('opacity-100');
                feedback.classList.add('opacity-0');
            }, 2000);
        });
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('successModal');
            if (!modal.classList.contains('hidden')) {
                closeReportModal();
            }
        }
    });

    // Close modal on backdrop click
    document.getElementById('successModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeReportModal();
        }
    });
</script>