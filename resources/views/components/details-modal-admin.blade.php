<div class="md-overlay" id="modalDetail" style="display:none">
    <div class="md-panel">

        <div class="md-header" id="mdHeader">
            <div class="md-header-left">
                <div class="md-header-icon" id="mdHeaderIcon"></div>
                <div>
                    <p class="md-type-label" id="mdTypeLabel"></p>
                    <h2 class="md-title">Detail Laporan</h2>
                </div>
            </div>
            <div class="md-header-right">
                <span class="md-id-badge" id="mdIdBadge">ID: —</span>
                <button class="md-close-btn" onclick="closeDetailModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="15" height="15">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="md-body">

            <div class="md-section">
                <div class="md-sh">
                    <div class="md-sh-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span>INFORMASI PELAPOR</span>
                </div>
                <div class="md-grid2">
                    <div class="md-f">
                        <div class="md-fl">NAMA</div>
                        <div class="md-fv">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span id="mdNama">—</span>
                        </div>
                    </div>
                    <div class="md-f">
                        <div class="md-fl">NIS</div>
                        <div class="md-fv">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                            <span id="mdNis">—</span>
                        </div>
                    </div>
                    <div class="md-f">
                        <div class="md-fl">KELAS</div>
                        <div class="md-fv">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                            <span id="mdKelas">—</span>
                        </div>
                    </div>
                    <div class="md-f">
                        <div class="md-fl">EMAIL</div>
                        <div class="md-fv">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span id="mdEmail">—</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md-section" id="sectionWaktu">
                <div class="md-sh">
                    <div class="md-sh-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span>WAKTU &amp; KEJADIAN</span>
                </div>
                <div class="md-grid2">
                    <div class="md-f">
                        <div class="md-fl">TANGGAL</div>
                        <div class="md-fv">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span id="mdTanggal">—</span>
                        </div>
                    </div>
                    <div class="md-f">
                        <div class="md-fl">TEMPAT</div>
                        <div class="md-fv">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span id="mdTempat">—</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md-section" id="sectionPihak">
                <div class="md-sh">
                    <div class="md-sh-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span>PIHAK TERLIBAT</span>
                </div>
                <div class="md-grid2">
                    <div class="md-f">
                        <div class="md-fl">PELAKU</div>
                        <div class="md-fv danger">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span id="mdPelaku">—</span>
                        </div>
                    </div>
                    <div class="md-f">
                        <div class="md-fl">KORBAN</div>
                        <div class="md-fv">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            <span id="mdKorban">—</span>
                        </div>
                    </div>
                    <div class="md-f">
                        <div class="md-fl">SAKSI <span style="font-weight:400;text-transform:none;letter-spacing:0">(Opsional)</span></div>
                        <div class="md-fv">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span id="mdSaksi">—</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md-section">
                <div class="md-sh">
                    <div class="md-sh-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span>DESKRIPSI KEJADIAN</span>
                </div>
                <p class="md-desc" id="mdDeskripsi">—</p>
            </div>

            <div class="md-section">
                <div class="md-sh">
                    <div class="md-sh-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span>BUKTI PENDUKUNG</span>
                </div>
                <div class="md-bukti-row">
                    <div class="md-bukti">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Bukti 1</span>
                    </div>
                    <div class="md-bukti">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Bukti 2</span>
                    </div>
                </div>
            </div>

            <div class="md-section md-section-tindak" id="sectionTindakLanjut">
                <div class="md-sh">
                    <div class="md-sh-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                        </svg>
                    </div>
                    <span>TINDAK LANJUT</span>
                </div>
                <div class="md-grid2" style="margin-bottom:10px">
                    <div class="md-f">
                        <div class="md-fl">JENIS TINDAKAN</div>
                        <select class="md-select" id="mdJenisTindakan">
                            <option value="">Pilih Tindakan...</option>
                            <option>Pembinaan</option>
                            <option>Pemanggilan Orang Tua</option>
                            <option>Skorsing</option>
                            <option>Mediasi</option>
                            <option>Konseling</option>
                        </select>
                        <div class="md-fv" id="mdJenisTindakanDisplay">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                            <span id="mdJenisTindakanText">—</span>
                        </div>
                    </div>
                    <div class="md-f">
                        <div class="md-fl">TANGGAL PELAKSANAAN</div>
                        <input type="date" class="md-input-date" id="mdTanggalTindak">
                        <div class="md-fv" id="mdTanggalTindakDisplay">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span id="mdTanggalTindakText">—</span>
                        </div>
                    </div>
                </div>
                <div class="md-f" style="margin-bottom:10px">
                    <div class="md-fl">DESKRIPSI TINDAKAN</div>
                    <textarea class="md-textarea" id="mdDeskripsiTindakan"
                        placeholder="Tuliskan butir-butir sanksi atau langkah pembinaan yang akan dijalankan oleh pelaku..." rows="3"></textarea>
                    <p class="md-desc" id="mdDeskripsiTindakanDisplay" style="margin:0">—</p>
                </div>
                <div class="md-f">
                    <div class="md-fl">BUKTI PELAKSANAAN</div>
                    <div class="md-upload" id="mdUploadArea" onclick="document.getElementById('mdFileInput').click()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <p>Klik untuk upload bukti pelaksanaan sanksi</p>
                        <span>PNG, JPG, PDF (maks. 5MB)</span>
                        <input type="file" id="mdFileInput" style="display:none" accept="image/*,.pdf">
                    </div>
                    <div class="md-dokumen" id="mdDokumenDisplay">
                        <div style="display:flex;align-items:center;gap:8px;flex:1">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span style="font-size:.83rem;font-weight:600;color:#111827">Dokumen Penunjang</span>
                        </div>
                        <button class="md-dl-btn">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Unduh
                        </button>
                    </div>
                </div>
            </div>

        </div>

        {{-- Section khusus laporan-ditolak --}}
        <div class="md-section md-section-tolak" id="sectionPenolakan" style="display:none">
            <div class="md-sh">
                <div class="md-sh-icon" style="background:#fef2f2">
                    <svg fill="none" stroke="#ef4444" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <span style="color:#b91c1c">INFORMASI PENOLAKAN</span>
            </div>
            <div class="md-grid2" style="margin-bottom:10px">
                <div class="md-f">
                    <div class="md-fl">DITOLAK DARI TAHAP</div>
                    <div class="md-fv">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                        <span id="mdTahapDitolak">—</span>
                    </div>
                </div>
                <div class="md-f">
                    <div class="md-fl">TANGGAL PENOLAKAN</div>
                    <div class="md-fv">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span id="mdTglDitolak">—</span>
                    </div>
                </div>
            </div>
            <div class="md-f">
                <div class="md-fl">ALASAN PENOLAKAN</div>
                <p class="md-desc md-alasan" id="mdAlasanTolak">—</p>
            </div>
        </div>

        <div class="md-footer" id="mdFooter"></div>

    </div>
</div>

<style>
.md-overlay {
    position: fixed; inset: 0; z-index: 600;
    background: rgba(15,23,42,.62);
    backdrop-filter: blur(5px);
    overflow-y: auto;
    padding: 24px 16px;
    display: flex; align-items: flex-start; justify-content: center;
}
.md-panel {
    background: white; border-radius: 20px;
    width: 100%; max-width: 580px;
    margin: auto;
    box-shadow: 0 32px 80px rgba(0,0,0,.22);
    overflow: hidden;
    animation: mdIn .3s cubic-bezier(.16,1,.3,1) both;
}
@keyframes mdIn {
    from { opacity:0; transform: translateY(24px) scale(.97); }
    to   { opacity:1; transform: translateY(0) scale(1); }
}

.md-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:16px 20px; flex-shrink:0;
}
.md-header-left  { display:flex; align-items:center; gap:12px; }
.md-header-icon  {
    width:42px; height:42px; border-radius:12px;
    background:rgba(255,255,255,.2); border:1.5px solid rgba(255,255,255,.28);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.md-header-icon svg { width:20px; height:20px; color:white; }
.md-type-label {
    font-size:.6rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase;
    color:rgba(255,255,255,.72); line-height:1; margin-bottom:4px;
}
.md-title { font-size:1.05rem; font-weight:800; color:white; line-height:1; }
.md-header-right { display:flex; align-items:center; gap:8px; }
.md-id-badge {
    font-family:'Courier New',monospace; font-size:.72rem; font-weight:700;
    background:rgba(255,255,255,.18); color:white;
    padding:5px 11px; border-radius:8px; border:1.5px solid rgba(255,255,255,.25);
}
.md-close-btn {
    width:32px; height:32px; border-radius:9px;
    background:rgba(255,255,255,.15); border:1.5px solid rgba(255,255,255,.22);
    cursor:pointer; display:flex; align-items:center; justify-content:center;
    color:white; transition:background .15s; flex-shrink:0;
}
.md-close-btn:hover { background:rgba(255,255,255,.28); }

.md-body { padding:16px 18px; display:flex; flex-direction:column; gap:10px; }

.md-section {
    background:#f9fafb; border:1.5px solid #e5e7eb; border-radius:14px; padding:14px 15px;
}
.md-section-tindak { background:#f0fdf4; border-color:#bbf7d0; }
.md-section-tolak  { background:#fef2f2; border-color:#fecaca; }
.md-alasan { background:#fff; border:1.5px solid #fca5a5; border-radius:10px; padding:10px 13px; color:#7f1d1d; font-style:italic; }

.md-sh {
    display:flex; align-items:center; gap:8px; margin-bottom:12px;
    font-size:.67rem; font-weight:800; letter-spacing:.1em; color:#374151;
}
.md-sh-icon {
    width:22px; height:22px; border-radius:6px; background:#d1fae5; color:#059669;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.md-sh-icon svg { width:12px; height:12px; }

.md-grid2 { display:grid; grid-template-columns:1fr 1fr; gap:8px; }

.md-f   { display:flex; flex-direction:column; gap:4px; }
.md-fl  { font-size:.6rem; font-weight:700; color:#9ca3af; letter-spacing:.08em; }
.md-fv  {
    display:flex; align-items:center; gap:8px; padding:8px 11px;
    background:white; border:1.5px solid #e5e7eb; border-radius:9px;
    font-size:.83rem; font-weight:500; color:#111827; min-height:38px;
}
.md-fv svg { width:13px; height:13px; color:#9ca3af; flex-shrink:0; }
.md-fv.danger { background:#fef2f2; border-color:#fecaca; }
.md-fv.danger svg { color:#ef4444; }

.md-desc {
    font-size:.83rem; color:#374151; line-height:1.65;
    background:white; border:1.5px solid #e5e7eb; border-radius:9px;
    padding:10px 12px; margin-top:0;
}

.md-bukti-row { display:flex; gap:8px; }
.md-bukti {
    flex:1; aspect-ratio:4/3; background:white; border:2px dashed #d1d5db;
    border-radius:10px; display:flex; flex-direction:column;
    align-items:center; justify-content:center; gap:5px; color:#d1d5db;
}
.md-bukti svg { width:22px; height:22px; }
.md-bukti span { font-size:.69rem; font-weight:500; color:#9ca3af; }

.md-select, .md-input-date {
    width:100%; padding:8px 12px; border:1.5px solid #d1d5db; border-radius:9px;
    font-family:inherit; font-size:.83rem; color:#111827; background:white; outline:none;
    transition:border-color .2s, box-shadow .2s;
}
.md-select {
    appearance:none; cursor:pointer; padding-right:30px;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 8px center; background-size:13px;
}
.md-select:focus, .md-input-date:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,.1); }

.md-textarea {
    width:100%; padding:9px 11px; border:1.5px solid #d1d5db; border-radius:9px;
    font-family:inherit; font-size:.83rem; color:#111827; background:white;
    outline:none; resize:vertical; line-height:1.5;
    transition:border-color .2s, box-shadow .2s;
}
.md-textarea:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,.1); }
.md-textarea::placeholder { color:#9ca3af; }

.md-upload {
    border:2px dashed #86efac; background:#f0fdf4; border-radius:10px;
    padding:18px; display:flex; flex-direction:column;
    align-items:center; justify-content:center; gap:4px;
    cursor:pointer; text-align:center; transition:background .15s;
}
.md-upload:hover { background:#dcfce7; }
.md-upload svg { width:24px; height:24px; color:#16a34a; }
.md-upload p  { font-size:.8rem; font-weight:600; color:#15803d; margin:0; }
.md-upload span { font-size:.68rem; color:#6b7280; }

.md-dokumen {
    display:flex; align-items:center; gap:8px;
    padding:10px 13px; background:white; border:1.5px solid #bbf7d0; border-radius:9px;
    color:#16a34a;
}
.md-dl-btn {
    display:flex; align-items:center; gap:5px; padding:6px 12px;
    background:#10b981; color:white; border:none; border-radius:8px;
    font-family:inherit; font-size:.73rem; font-weight:700; cursor:pointer;
    transition:background .15s; flex-shrink:0;
}
.md-dl-btn:hover { background:#059669; }

.md-footer {
    display:flex; gap:8px; padding:12px 18px 16px;
    border-top:1px solid #f0f0f0; background:#fafafa;
}
.md-btn {
    flex:1; padding:11px 12px; border-radius:10px; border:none;
    font-family:inherit; font-size:.83rem; font-weight:700; cursor:pointer;
    display:flex; align-items:center; justify-content:center; gap:6px;
    transition:filter .15s, transform .1s;
}
.md-btn svg { width:15px; height:15px; }
.md-btn:hover  { filter:brightness(.9); transform:translateY(-1px); }
.md-btn:active { transform:scale(.98) translateY(0); }
.md-btn-cancel  { background:white; color:#374151; border:1.5px solid #d1d5db !important; flex:0 0 auto !important; padding-left:18px; padding-right:18px; }
.md-btn-cancel:hover { background:#f9fafb; filter:none; }
.md-btn-tolak    { background:#ef4444; color:white; box-shadow:0 3px 12px rgba(239,68,68,.28); }
.md-btn-terima   { background:#10b981; color:white; box-shadow:0 3px 12px rgba(16,185,129,.28); }
.md-btn-proses   { background:#f59e0b; color:white; box-shadow:0 3px 12px rgba(245,158,11,.28); }
.md-btn-selesai  { background:#10b981; color:white; box-shadow:0 3px 12px rgba(16,185,129,.28); }
.md-btn-pulihkan { background:#3b82f6; color:white; box-shadow:0 3px 12px rgba(59,130,246,.28); }

/* Progress trail badge */
.md-progress-trail {
    display:flex; align-items:center; gap:6px; flex-wrap:wrap;
    padding:10px 13px; background:#fff7ed; border:1.5px solid #fed7aa;
    border-radius:10px; margin-bottom:4px;
}
.md-pt-label { font-size:.65rem; font-weight:800; letter-spacing:.08em; color:#92400e; }
.md-pt-step {
    display:flex; align-items:center; gap:4px;
    font-size:.72rem; font-weight:600; color:#374151;
}
.md-pt-step.done { color:#10b981; }
.md-pt-step.rejected { color:#ef4444; }
.md-pt-arrow { font-size:.7rem; color:#9ca3af; }

@media (max-width:580px) {
    .md-overlay  { padding:0; align-items:flex-start; }
    .md-panel    { border-radius:0 0 20px 20px; margin:0 0 auto; }
    .md-grid2    { grid-template-columns:1fr; }
    .md-footer   { flex-wrap:wrap; }
    .md-btn-cancel { flex:1 !important; order:9; }
}
</style>

<script>
/* =========================================================
   SHARED STATE — digunakan oleh detail modal DAN konfirmasi
   ========================================================= */
var _currentRow  = null;
var _currentType = null;
var _currentData = null;

/* =========================================================
   HEADER & FOOTER CONFIG
   ========================================================= */
const _HDR = {
    'laporan-masuk'       : { label:'LAPORAN MASUK',        bg:'linear-gradient(135deg,#3b82f6,#1d4ed8)', icon:'clip' },
    'menunggu-verifikasi' : { label:'VERIFIKASI LAPORAN',   bg:'linear-gradient(135deg,#7c3aed,#5b21b6)', icon:'shield' },
    'proses-laporan'      : { label:'PROSES TINDAK LANJUT', bg:'linear-gradient(135deg,#f59e0b,#d97706)', icon:'bolt' },
    'laporan-selesai'     : { label:'LAPORAN SELESAI',      bg:'linear-gradient(135deg,#10b981,#047857)', icon:'check' },
    'laporan-ditolak'     : { label:'LAPORAN DITOLAK',      bg:'linear-gradient(135deg,#ef4444,#b91c1c)', icon:'ban' },
};
const _ICONS = {
    clip:   `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>`,
    shield: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>`,
    bolt:   `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>`,
    check:  `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
    cross:  `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>`,
    ban:    `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>`,
    undo:   `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>`,
};

/* Footer buttons per tipe halaman */
const _FOOTER = {
    'laporan-masuk'       : [
        { c:'md-btn-cancel', l:'Batal',         i:'',      a:'closeDetailModal()' },
        { c:'md-btn-tolak',  l:'Tolak Laporan', i:'cross', a:"_fromDetailTrigger('tolak')" },
        { c:'md-btn-terima', l:'Terima Laporan',i:'check', a:"_fromDetailTrigger('terima')" },
    ],
    'menunggu-verifikasi' : [
        { c:'md-btn-cancel', l:'Batal',         i:'',      a:'closeDetailModal()' },
        { c:'md-btn-tolak',  l:'Tolak Laporan', i:'cross', a:"_fromDetailTrigger('tolak')" },
        { c:'md-btn-proses', l:'Proses Laporan',i:'bolt',  a:"_fromDetailTrigger('proses')" },
    ],
    'proses-laporan'      : [
        { c:'md-btn-cancel',  l:'Batal',         i:'',      a:'closeDetailModal()' },
        { c:'md-btn-tolak',   l:'Tolak Laporan', i:'cross', a:"_fromDetailTrigger('tolak')" },
        { c:'md-btn-selesai', l:'Selesaikan',    i:'check', a:"_fromDetailTrigger('selesai')" },
    ],
    'laporan-selesai'     : [
        { c:'md-btn-cancel', l:'Tutup', i:'', a:'closeDetailModal()' },
    ],
    'laporan-ditolak'     : [
        { c:'md-btn-cancel',  l:'Tutup',    i:'',     a:'closeDetailModal()' },
        { c:'md-btn-pulihkan',l:'Pulihkan', i:'undo', a:"_fromDetailTrigger('pulihkan')" },
    ],
};

/* =========================================================
   TRIGGER DARI FOOTER DETAIL MODAL
   Tutup detail dulu, lalu buka konfirmasi
   ========================================================= */
function _fromDetailTrigger(action) {
    /* Tutup detail modal */
    document.getElementById('modalDetail').style.display = 'none';
    /* Buka konfirmasi setelah 1 frame agar animasi tidak bentrok */
    requestAnimationFrame(() => {
        triggerKonfirmasi(action);
    });
}

/* =========================================================
   OPEN DETAIL MODAL
   ========================================================= */
function openDetailModal(data, type, rowEl) {
    _currentRow  = rowEl  || null;
    _currentType = type   || 'laporan-masuk';
    _currentData = data   || {};

    const h = _HDR[_currentType] || _HDR['laporan-masuk'];
    document.getElementById('mdHeader').style.background = h.bg;
    document.getElementById('mdHeaderIcon').innerHTML    = _ICONS[h.icon];
    _T('mdTypeLabel', h.label);
    _T('mdIdBadge',  'ID: ' + (data.kode || '—'));

    _T('mdNama',  data.nama);
    _T('mdNis',   data.nis);
    _T('mdKelas', data.kelas);
    _T('mdEmail', data.email);

    /* Untuk laporan-ditolak, tampilkan data selengkap tahap terakhirnya */
    const isDitolak = _currentType === 'laporan-ditolak';
    const lastType  = isDitolak ? (data.tahapTerakhir || 'laporan-masuk') : _currentType;
    const isLM      = lastType === 'laporan-masuk';

    _V('sectionWaktu', !isLM);
    _V('sectionPihak', !isLM);
    if (!isLM) {
        _T('mdTanggal', data.tanggal);
        _T('mdTempat',  data.tempat);
        _T('mdPelaku',  data.pelaku);
        _T('mdKorban',  data.korban);
        _T('mdSaksi',   data.saksi || 'Tidak ada');
    }

    _T('mdDeskripsi', data.deskripsi);

    /* Section tindak lanjut: tampil jika tahap terakhir = proses/selesai */
    const hasTindak = lastType === 'proses-laporan' || lastType === 'laporan-selesai';
    _V('sectionTindakLanjut', hasTindak);
    if (hasTindak) {
        /* Selalu display-only untuk laporan-ditolak & laporan-selesai */
        const isDisplay = isDitolak || lastType === 'laporan-selesai';
        _V('mdJenisTindakan',            !isDisplay);
        _V('mdJenisTindakanDisplay',      isDisplay);
        _V('mdTanggalTindak',            !isDisplay);
        _V('mdTanggalTindakDisplay',      isDisplay);
        _V('mdDeskripsiTindakan',        !isDisplay);
        _V('mdDeskripsiTindakanDisplay',  isDisplay);
        _V('mdUploadArea',               !isDisplay);
        _V('mdDokumenDisplay',            isDisplay);
        if (isDisplay) {
            _T('mdJenisTindakanText',        data.jenisTindakan);
            _T('mdTanggalTindakText',        data.tanggalTindak);
            _T('mdDeskripsiTindakanDisplay', data.deskripsiTindakan);
        } else {
            ['mdJenisTindakan','mdTanggalTindak','mdDeskripsiTindakan'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
        }
    }

    /* Section penolakan — hanya untuk laporan-ditolak */
    _V('sectionPenolakan', isDitolak);
    if (isDitolak) {
        /* Label tahap terakhir */
        const tahapLabel = {
            'laporan-masuk':       'Laporan Masuk',
            'menunggu-verifikasi': 'Menunggu Verifikasi',
            'proses-laporan':      'Proses Laporan',
        };
        _T('mdTahapDitolak', tahapLabel[data.tahapTerakhir] || data.tahapTerakhir || '—');
        _T('mdTglDitolak',   data.tglDitolak   || '—');
        _T('mdAlasanTolak',  data.alasanTolak  || '—');

        /* Progress trail */
        _renderProgressTrail(data.tahapTerakhir);
    }

    /* Footer buttons */
    const footer = document.getElementById('mdFooter');
    footer.innerHTML = (_FOOTER[_currentType] || []).map(b =>
        `<button class="md-btn ${b.c}" onclick="${b.a}">${b.i ? _ICONS[b.i] : ''} ${b.l}</button>`
    ).join('');

    const overlay = document.getElementById('modalDetail');
    overlay.scrollTop = 0;
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

/* Render progress trail badge di atas section penolakan */
function _renderProgressTrail(tahapTerakhir) {
    const STEPS = [
        { key:'laporan-masuk',       label:'Laporan Masuk' },
        { key:'menunggu-verifikasi', label:'Verifikasi' },
        { key:'proses-laporan',      label:'Proses' },
    ];
    const idx = STEPS.findIndex(s => s.key === tahapTerakhir);
    const wrap = document.getElementById('sectionPenolakan');
    /* Hapus trail lama kalau ada */
    const old = wrap.querySelector('.md-progress-trail');
    if (old) old.remove();

    const trail = document.createElement('div');
    trail.className = 'md-progress-trail';
    trail.innerHTML = `<span class="md-pt-label">PROGRESS:</span>`;
    STEPS.forEach((s, i) => {
        const isDone     = i < idx;
        const isRejected = i === idx;
        const cls        = isDone ? 'done' : isRejected ? 'rejected' : '';
        const icon       = isDone ? '✓' : isRejected ? '✕' : '○';
        trail.innerHTML += `<span class="md-pt-step ${cls}">${icon} ${s.label}</span>`;
        if (i < STEPS.length - 1) trail.innerHTML += `<span class="md-pt-arrow">›</span>`;
    });
    wrap.insertBefore(trail, wrap.querySelector('.md-sh').nextSibling);
}

/* =========================================================
   CLOSE DETAIL MODAL
   ========================================================= */
function closeDetailModal() {
    document.getElementById('modalDetail').style.display = 'none';
    document.body.style.overflow = '';
}

/* Klik overlay untuk tutup */
document.getElementById('modalDetail').addEventListener('click', function(e) {
    if (e.target === this) closeDetailModal();
});

/* =========================================================
   HELPERS
   ========================================================= */
function _T(id, v) {
    const e = document.getElementById(id);
    if (e) e.textContent = v || '—';
}
function _V(id, show) {
    const e = document.getElementById(id);
    if (e) e.style.display = show ? '' : 'none';
}
</script>