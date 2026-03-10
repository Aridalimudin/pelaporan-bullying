<div class="toast-container" id="toastContainer"></div>

<style>
.toast-container {
    position: fixed; top: 20px; right: 20px; z-index: 9999;
    display: flex; flex-direction: column; gap: 8px;
    pointer-events: none;
}
.toast {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 14px 16px; border-radius: 14px;
    background: white;
    box-shadow: 0 8px 32px rgba(0,0,0,.13), 0 2px 8px rgba(0,0,0,.06);
    min-width: 280px; max-width: 360px;
    pointer-events: auto;
    border-left: 4px solid transparent;
    position: relative; overflow: hidden;
    animation: toastIn .4s cubic-bezier(.16,1,.3,1) both;
}
.toast.removing { animation: toastOut .35s ease forwards; }

.toast.success { border-color: #10b981; }
.toast.error   { border-color: #ef4444; }
.toast.warning { border-color: #f59e0b; }
.toast.info    { border-color: #3b82f6; }

@keyframes toastIn  {
    from { opacity: 0; transform: translateX(60px) scale(.94); }
    to   { opacity: 1; transform: translateX(0)    scale(1);   }
}
@keyframes toastOut {
    from { opacity: 1; transform: translateX(0);    max-height: 100px; margin-bottom: 0; }
    to   { opacity: 0; transform: translateX(60px); max-height: 0;     margin-bottom: -8px; }
}

.toast-icon {
    width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.toast.success .toast-icon { background: #d1fae5; color: #059669; }
.toast.error   .toast-icon { background: #fee2e2; color: #dc2626; }
.toast.warning .toast-icon { background: #fef9c3; color: #d97706; }
.toast.info    .toast-icon { background: #dbeafe; color: #2563eb; }
.toast-icon svg { width: 18px; height: 18px; }

.toast-body { flex: 1; min-width: 0; padding-top: 1px; }
.toast-title { font-size: .83rem; font-weight: 700; color: #111827; line-height: 1.3; }
.toast-msg   { font-size: .75rem; color: #6b7280; line-height: 1.45; margin-top: 2px; }

.toast-close {
    background: none; border: none; cursor: pointer;
    padding: 2px; color: #9ca3af; flex-shrink: 0;
    display: flex; align-items: center;
    transition: color .15s; margin-top: 1px;
}
.toast-close:hover { color: #374151; }
.toast-close svg { width: 14px; height: 14px; }

.toast-progress {
    position: absolute; bottom: 0; left: 0; height: 3px;
    animation: toastProgress linear forwards;
}
.toast.success .toast-progress { background: #10b981; }
.toast.error   .toast-progress { background: #ef4444; }
.toast.warning .toast-progress { background: #f59e0b; }
.toast.info    .toast-progress { background: #3b82f6; }

@keyframes toastProgress { from { width: 100%; } to { width: 0%; } }

@media (max-width: 480px) {
    .toast-container { left: 12px; right: 12px; top: 12px; }
    .toast { min-width: 0; width: 100%; }
}
</style>

<script>
const Toast = {
    _icons: {
        success: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
        error:   `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
        warning: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`,
        info:    `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
    },

    show(type = 'info', title = '', msg = '', duration = 4000) {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const id  = 'toast-' + Date.now() + '-' + Math.random().toString(36).slice(2, 6);
        const el  = document.createElement('div');
        el.className = `toast ${type}`;
        el.id = id;
        el.innerHTML = `
            <div class="toast-icon">${this._icons[type] ?? this._icons.info}</div>
            <div class="toast-body">
                <div class="toast-title">${title}</div>
                ${msg ? `<div class="toast-msg">${msg}</div>` : ''}
            </div>
            <button class="toast-close" onclick="Toast.remove('${id}')" aria-label="Tutup">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="toast-progress" style="animation-duration:${duration}ms"></div>
        `;
        container.appendChild(el);
        setTimeout(() => this.remove(id), duration);
    },

    remove(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.add('removing');
        setTimeout(() => el?.remove(), 380);
    },

    success(title, msg, duration) { this.show('success', title, msg, duration); },
    error  (title, msg, duration) { this.show('error',   title, msg, duration); },
    warning(title, msg, duration) { this.show('warning', title, msg, duration); },
    info   (title, msg, duration) { this.show('info',    title, msg, duration); },
};
</script>