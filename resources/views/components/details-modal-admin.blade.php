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

                            {{-- INFO ORANG TUA (tampil hanya jika reporter_type = ortu) --}}
                            <div class="md-f" id="mdOrtuWrap" style="display:none">
                                <div class="md-fl">NAMA ORANG TUA / WALI</div>
                                <div class="md-fv">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span id="mdOrtuNama">—</span>
                                </div>
                            </div>
                            <div class="md-f" id="mdOrtuPhoneWrap" style="display:none">
                                <div class="md-fl">NO. HP / WHATSAPP</div>
                                <div class="md-fv">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span id="mdOrtuPhone">—</span>
                                </div>
                            </div>
                            <div class="md-f" id="mdChildNameWrap" style="display:none">
                                <div class="md-fl">NAMA ANAK</div>
                                <div class="md-fv">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span id="mdChildName">—</span>
                                </div>
                            </div>
                            <div class="md-f" id="mdChildGradeWrap" style="display:none">
                                <div class="md-fl">KELAS ANAK</div>
                                <div class="md-fv">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                                    <span id="mdChildGrade">—</span>
                                </div>
                            </div>

                            <!-- JENIS LAPORAN & URGENSI sejajar kiri-kanan, span 2 kolom masing-masing -->
                            <div class="md-f">
                                <div class="md-fl">JENIS LAPORAN</div>
                                <div id="mdJenisLaporan" style="
                                    display:flex;flex-wrap:wrap;gap:6px;
                                    padding:8px 11px;background:white;
                                    border:1.5px solid #e5e7eb;border-radius:9px;
                                    min-height:38px;align-items:center;">
                                </div>
                            </div>
                            <div class="md-f">
                                <div class="md-fl">URGENSI</div>
                                <div id="mdUrgensiWrap" style="
                                    padding:8px 11px;background:white;
                                    border:1.5px solid #e5e7eb;border-radius:9px;
                                    min-height:38px;display:flex;align-items:center;">
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
                                <div class="md-fl">JAM</div>
                                <div class="md-fv">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span id="mdJam">—</span>
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
                            <!-- Tambah SETELAH div md-grid2 di sectionPihak -->
                            <div class="md-f" id="sectionCatatanPihak" style="display:none;margin-top:8px;">
                                <div class="md-fl">CATATAN PIHAK TERLIBAT</div>
                                <p class="md-desc" id="mdCatatanPihak" style="margin:0;font-style:italic;color:#6b7280;">—</p>
                            </div>
                            <div class="md-f">
                                <div class="md-fl">PELAKU</div>
                                <div id="mdPelaku" style="padding:8px 11px;background:#fef2f2;
                                    border:1.5px solid #fecaca;border-radius:9px;min-height:38px;
                                    word-break:break-word;overflow-wrap:break-word;">—</div>
                            </div>
                            <div class="md-f">
                                <div class="md-fl">KORBAN</div>
                                <div id="mdKorban" style="padding:8px 11px;background:white;
                                    border:1.5px solid #e5e7eb;border-radius:9px;min-height:38px;
                                    word-break:break-word;overflow-wrap:break-word;">—</div>
                            </div>
                            <div class="md-f">
                                <div class="md-fl">SAKSI <span style="font-weight:400;text-transform:none;letter-spacing:0">(Opsional)</span></div>
                                <div id="mdSaksi" style="padding:8px 11px;background:white;
                                    border:1.5px solid #e5e7eb;border-radius:9px;min-height:38px;
                                    word-break:break-word;overflow-wrap:break-word;">—</div>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                </svg>
                            </div>
                            <span>TINDAK LANJUT</span>
                        </div>

                        <!-- EDIT MODE -->
                        <div id="tindakEditMode">
                            <div class="md-grid2" style="margin-bottom:10px">
                                <div class="md-f">
                                    <div class="md-fl">JENIS TINDAKAN <span style="color:#ef4444">*</span></div>
                                    <select class="md-select" id="mdJenisTindakan" onchange="onTindakanChange(this)">
                                        <option value="">Pilih Tindakan...</option>
                                    </select>
                                </div>
                                <div class="md-f">
                                    <div class="md-fl">TANGGAL PELAKSANAAN <span style="color:#ef4444">*</span></div>
                                    <input type="date" class="md-input-date" id="mdTanggalTindak">
                                </div>
                            </div>

                            <div id="mdTindakanInfo" style="display:none;padding:8px 12px;background:#fffbeb;
                                border:1.5px solid #fde68a;border-radius:9px;font-size:.78rem;
                                color:#92400e;margin-bottom:10px;"></div>

                            <div class="md-f" style="margin-bottom:10px">
                                <div class="md-fl">DESKRIPSI TINDAKAN <span style="color:#ef4444">*</span></div>
                                <textarea class="md-textarea" id="mdDeskripsiTindakan" rows="4"
                                    placeholder="Otomatis terisi saat memilih jenis tindakan, dapat disesuaikan..."></textarea>
                            </div>

                            <div class="md-f" style="margin-bottom:10px">
                                <div class="md-fl">CATATAN TAMBAHAN
                                    <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#9ca3af">(opsional)</span>
                                </div>
                                <textarea class="md-textarea" id="mdCatatanTambahan" rows="2"
                                    placeholder="Informasi tambahan yang perlu dicatat..."></textarea>
                            </div>

                            <div class="md-f">
                                <div class="md-fl">BUKTI PELAKSANAAN
                                    <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#9ca3af">(opsional)</span>
                                </div>
                                <div class="md-upload" id="mdUploadArea"
                                    onclick="document.getElementById('mdFileInput').click()">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p>Klik untuk upload bukti pelaksanaan</p>
                                    <span>PNG, JPG, PDF, Video (maks. 50MB)</span>
                                    <input type="file" id="mdFileInput" style="display:none"
                                        accept="image/*,.pdf,video/*" multiple
                                        onchange="onFollowUpFileSelected(this)">
                                </div>
                                <div id="mdFilePreview" style="display:none;margin-top:8px;
                                    display:flex;flex-wrap:wrap;gap:6px;"></div>
                            </div>
                        </div>

                        <!-- DISPLAY MODE (readonly) -->
                        <div id="tindakDisplayMode" style="display:none">
                            <div class="md-grid2" style="margin-bottom:10px">
                                <div class="md-f">
                                    <div class="md-fl">JENIS TINDAKAN</div>
                                    <div class="md-fv">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                                        </svg>
                                        <span id="mdJenisTindakanText">—</span>
                                    </div>
                                </div>
                                <div class="md-f">
                                    <div class="md-fl">TANGGAL PELAKSANAAN</div>
                                    <div class="md-fv">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span id="mdTanggalTindakText">—</span>
                                    </div>
                                </div>
                            </div>
                            <div class="md-f" style="margin-bottom:10px">
                                <div class="md-fl">DESKRIPSI TINDAKAN</div>
                                <p class="md-desc" id="mdDeskripsiTindakanDisplay" style="margin:0">—</p>
                            </div>
                            <div class="md-grid2" style="margin-bottom:10px" id="mdPelaksanaWrap">
                                <div class="md-f">
                                    <div class="md-fl">PELAKSANA</div>
                                    <div class="md-fv">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span id="mdPelaksanaText">—</span>
                                    </div>
                                </div>
                                <div class="md-f">
                                    <div class="md-fl">KETERLIBATAN ORANG TUA</div>
                                    <div class="md-fv" id="mdKeterlibatanOrtuFv">
                                        <span id="mdKeterlibatanOrtuText">—</span>
                                    </div>
                                </div>
                            </div>
                            <div class="md-f" id="mdCatatanTambahanWrap" style="display:none;margin-bottom:10px">
                                <div class="md-fl">CATATAN TAMBAHAN</div>
                                <p class="md-desc" id="mdCatatanTambahanDisplay"
                                style="margin:0;font-style:italic;color:#6b7280;">—</p>
                            </div>
                            <div class="md-f">
                                <div class="md-fl">BUKTI PELAKSANAAN</div>
                                <div class="md-dokumen" id="mdDokumenDisplay">
                                    <div style="display:flex;align-items:center;gap:8px;flex:1">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span style="font-size:.83rem;font-weight:600;color:#111827">Dokumen Penunjang</span>
                                    </div>
                                    <button class="md-dl-btn">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="13" height="13">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Unduh
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

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
                <div class="md-section" id="sectionFeedback" style="display:none">
                    <div class="md-sh">
                        <div class="md-sh-icon" style="background:#fef9c3;">
                            <svg fill="none" stroke="#ca8a04" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        <span>FEEDBACK PELAPOR</span>
                    </div>
                    <div id="feedbackContent"></div>
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
            word-break: break-word;
            overflow-wrap: break-word;
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
        var _currentRow  = null;
        var _currentType = null;
        var _currentData = null;

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

        const _FOOTER = {
            'laporan-masuk'       : [
                { c:'md-btn-cancel', l:'Batal',         i:'',      a:'closeDetailModal()' },
                { c:'md-btn-tolak',  l:'Tolak Laporan', i:'cross', a:"_fromDetailTrigger('tolak')" },
                { c:'md-btn-terima', l:'Terima Laporan',i:'check', a:"_fromDetailTrigger('terima')" },
            ],
            'menunggu-verifikasi' : [
            { c:'md-btn-cancel', l:'Tutup', i:'', a:'closeDetailModal()' },
            { c:'md-btn-pulihkan', l:'Kirim Reminder', i:'clip', a:"_fromDetailTrigger('reminder')" },
            ],
            'proses-laporan'      : [
                { c:'md-btn-cancel',  l:'Batal',         i:'',      a:'closeDetailModal()' },
                { c:'md-btn-tolak',   l:'Tolak Laporan', i:'cross', a:"_fromDetailTrigger('tolak')" },
                { c:'md-btn-selesai', l:'Simpan Tindak Lanjut', i:'check', a:"submitFollowUp()" },
            ],
            'laporan-selesai'     : [
                { c:'md-btn-cancel', l:'Tutup', i:'', a:'closeDetailModal()' },
            ],
            'laporan-ditolak'     : [
                { c:'md-btn-cancel',  l:'Tutup',    i:'',     a:'closeDetailModal()' },
                { c:'md-btn-pulihkan',l:'Pulihkan', i:'undo', a:"_fromDetailTrigger('pulihkan')" },
            ],
        };

        function _fromDetailTrigger(action) {
            document.getElementById('modalDetail').style.display = 'none';
            requestAnimationFrame(() => {
                triggerKonfirmasi(action);
            });
        }

        function renderPersonList(persons, elId) {
            const el = document.getElementById(elId);
            if (!el) return;

            if (!persons || persons.length === 0) {
                el.innerHTML = `<span style="color:#9ca3af;font-style:italic;font-size:.78rem;">Pelapor belum mengisi</span>`;
                return;
            }

            el.innerHTML = persons.map((p, i) => {
                // Susun info kelas/jurusan
                const kelasJurusan = p.kelas || p.jurusan
                    ? [p.kelas, p.jurusan].filter(Boolean).join(' · ')
                    : null;

                return `
                    <div style="${i > 0 ? 'margin-top:8px;padding-top:8px;border-top:1px dashed #e5e7eb;' : ''}">
                        <div style="font-weight:600;font-size:.83rem;color:#111827;">${p.nama}</div>
                        ${kelasJurusan ? `
                        <div style="font-size:.75rem;margin-top:2px;color:#6b7280;">
                            🏫 ${kelasJurusan}
                        </div>` : ''}
                        <div style="font-size:.75rem;margin-top:3px;${p.notes ? 'color:#6b7280;' : 'color:#d1d5db;font-style:italic;'}">
                            ${p.notes ? '📝 ' + p.notes : 'Tidak ada catatan'}
                        </div>
                    </div>
                `;
            }).join('');
        }

        function openDetailModal(data, type, rowEl, scrollToTindak = false) {
            _currentRow  = rowEl  || null;
            _currentType = type   || 'laporan-masuk';
            _currentData = data   || {};

            const h = _HDR[_currentType] || _HDR['laporan-masuk'];
            document.getElementById('mdHeader').style.background = h.bg;
            document.getElementById('mdHeaderIcon').innerHTML    = _ICONS[h.icon];
            _T('mdTypeLabel', h.label);
            _T('mdIdBadge',  'ID: ' + (data.kode || '—'));

            const isOrtu = data.reporter_type === 'ortu';
            const NA = '<span style="color:#9ca3af;font-style:italic;font-size:.78rem;">Tidak diisi</span>';

            // Sembunyikan field NIS & Kelas untuk ortu
            const mdNisEl   = document.getElementById('mdNis')?.closest('.md-f');
            const mdKelasEl = document.getElementById('mdKelas')?.closest('.md-f');
            const mdNamaEl  = document.getElementById('mdNama')?.closest('.md-f');
            if (mdNisEl)   mdNisEl.style.display   = isOrtu ? 'none' : '';
            if (mdKelasEl) mdKelasEl.style.display  = isOrtu ? 'none' : '';

            if (isOrtu) {
                // Ubah label NAMA jadi NAMA ORANG TUA / WALI
                if (mdNamaEl) mdNamaEl.querySelector('.md-fl').textContent = 'NAMA ORANG TUA / WALI';
                _T('mdNama',  data.reporter_name  || '');
                if (!data.reporter_name) document.getElementById('mdNama').innerHTML = NA;

                const emailEl = document.getElementById('mdEmail');
                if (emailEl) emailEl.innerHTML = data.email
                    ? data.email
                    : NA;
            } else {
                if (mdNamaEl) mdNamaEl.querySelector('.md-fl').textContent = 'NAMA';
                _T('mdNama',  data.nama);
                _T('mdNis',   data.nis);
                _T('mdKelas', data.kelas);
                _T('mdEmail', data.email);
            }

            // Field khusus ortu
            _V('mdOrtuWrap',       isOrtu);
            _V('mdOrtuPhoneWrap',  isOrtu);
            _V('mdChildNameWrap',  isOrtu);
            _V('mdChildGradeWrap', isOrtu);

            if (isOrtu) {
                const phoneEl = document.getElementById('mdOrtuPhone');
                const childEl = document.getElementById('mdChildName');
                const gradeEl = document.getElementById('mdChildGrade');
                if (phoneEl) phoneEl.innerHTML = data.reporter_phone || NA;
                if (childEl) childEl.innerHTML = data.child_name     || NA;
                if (gradeEl) gradeEl.innerHTML = data.child_grade    || NA;
                // sembunyikan field ortu nama (sudah di nama atas)
                _V('mdOrtuWrap', false);
            }

                    // ── Jenis Laporan ──────────────────────────────────────
            const jenisEl = document.getElementById('mdJenisLaporan');
            if (jenisEl) {
                const cats = data.violation_categories;
                if (cats && cats !== '-') {
                    jenisEl.innerHTML = cats.split(' & ').map(cat => {
                        const isFisik = cat === 'Fisik';
                        return `<span style="
                            display:inline-flex;align-items:center;gap:4px;
                            padding:3px 10px;border-radius:99px;font-size:.75rem;font-weight:600;
                            background:${isFisik ? '#fee2e2' : '#dbeafe'};
                            color:${isFisik ? '#991b1b' : '#1e40af'};
                            border:1px solid ${isFisik ? '#fca5a5' : '#93c5fd'};
                        ">${isFisik ? '⚡' : '💬'} ${cat}</span>`;
                    }).join('');
                } else {
                    jenisEl.innerHTML = '<span style="font-size:.78rem;color:#9ca3af;font-style:italic;">Tidak terdeteksi</span>';
                }
            }

            // ── Urgensi ────────────────────────────────────────────
            const urgensiEl = document.getElementById('mdUrgensiWrap');
            if (urgensiEl) {
                const urg = data.urgensi || '';
                const urgMap = {
                    tinggi : { bg:'#fef2f2', color:'#991b1b', border:'#fca5a5', label:'🔴 Tinggi' },
                    sedang  : { bg:'#fffbeb', color:'#92400e', border:'#fde68a', label:'🟡 Sedang' },
                    rendah  : { bg:'#f0fdf4', color:'#166534', border:'#bbf7d0', label:'🟢 Rendah' },
                };
                const u = urgMap[urg.toLowerCase()] || null;
                urgensiEl.innerHTML = u
                    ? `<span style="
                        display:inline-flex;align-items:center;gap:4px;
                        padding:3px 10px;border-radius:99px;font-size:.75rem;font-weight:600;
                        background:${u.bg};color:${u.color};border:1px solid ${u.border};
                    ">${u.label}</span>`
                    : `<span style="font-size:.78rem;color:#9ca3af;font-style:italic;">—</span>`;
            }

            const isDitolak = _currentType === 'laporan-ditolak';
            const lastType  = isDitolak ? (data.tahapTerakhir || 'laporan-masuk') : _currentType;
            const isLM      = lastType === 'laporan-masuk';

            _V('sectionWaktu', !isLM);
            _V('sectionPihak', !isLM);

            
            // Ganti bagian ini di openDetailModal:
            if (!isLM) {
                const belumIsi = `<span style="color:#9ca3af;font-style:italic;font-size:.78rem;">Pelapor belum mengisi</span>`;

                // Tanggal
                const elTanggal = document.getElementById('mdTanggal');
                if (elTanggal) elTanggal.innerHTML = data.tanggal 
                    ? `<span>${data.tanggal}</span>` 
                    : belumIsi;

                const elJam = document.getElementById('mdJam');
                if (elJam) elJam.innerHTML = data.jam && data.jam !== '-'
                    ? `<span>${data.jam}</span>`
                    : `<span style="color:#9ca3af;font-style:italic;font-size:.78rem;">Pelapor belum mengisi</span>`;

                // Tempat
                const elTempat = document.getElementById('mdTempat');
                if (elTempat) elTempat.innerHTML = data.tempat && data.tempat !== '-'
                    ? `<span>${data.tempat}</span>`
                    : belumIsi;

                renderPersonList(data.pelaku, 'mdPelaku');
                renderPersonList(data.korban, 'mdKorban');
                renderPersonList(data.saksi,  'mdSaksi');
            }

            

            _T('mdDeskripsi', data.deskripsi);
            document.getElementById('dlAllWrapBtn')?.remove();

            const buktiContainer = document.querySelector('.md-bukti-row');
            buktiContainer.innerHTML = ''; // Hapus tulisan statis "Bukti 1", "Bukti 2"


            if (data.files && data.files.length > 0) {
                // Tombol download semua
                const dlAllWrap = document.createElement('div');
                dlAllWrap.id = 'dlAllWrapBtn'; 
                dlAllWrap.style.cssText = 'display:flex;justify-content:flex-end;margin-bottom:8px;';
                dlAllWrap.innerHTML = `
                    <button onclick="downloadAllBukti()" style="
                        display:flex;align-items:center;gap:6px;padding:6px 14px;
                        background:#10b981;color:white;border:none;border-radius:8px;
                        font-family:inherit;font-size:.75rem;font-weight:700;cursor:pointer;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="13" height="13">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Semua Bukti
                    </button>`;
                buktiContainer.before(dlAllWrap);

                // Simpan URL untuk download semua
                window._currentBuktiFiles = data.files;

                data.files.forEach((file) => {
                    const isImage = file.mime.startsWith('image/');
                    const isVideo = file.mime.startsWith('video/');

                    let content = '';
                    if (isImage) {
                        content = `
                            <img src="${file.url}" style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                            <div style="position:absolute;bottom:0;left:0;right:0;
                                background:linear-gradient(transparent,rgba(0,0,0,.5));
                                padding:6px 8px;display:flex;justify-content:flex-end;border-radius:0 0 8px 8px;">
                                <a href="${file.url}" download target="_blank"
                                    onclick="event.stopPropagation()"
                                    style="display:flex;align-items:center;gap:4px;padding:3px 8px;
                                    background:white;color:#111827;border-radius:6px;
                                    font-size:.68rem;font-weight:700;text-decoration:none;">
                                    ⬇ Unduh
                                </a>
                            </div>`;
                    } else if (isVideo) {
                        content = `
                            <video style="width:100%;height:100%;object-fit:cover;border-radius:8px;"
                                preload="metadata" muted>
                                <source src="${file.url}" type="${file.mime}">
                            </video>
                            <div style="position:absolute;inset:0;display:flex;flex-direction:column;
                                align-items:center;justify-content:center;gap:6px;
                                background:rgba(0,0,0,.35);border-radius:8px;">
                                <svg fill="white" viewBox="0 0 24 24" style="width:32px;height:32px;
                                    filter:drop-shadow(0 2px 4px rgba(0,0,0,.4))">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                                <span style="font-size:.65rem;color:white;font-weight:700;
                                    background:rgba(0,0,0,.5);padding:2px 6px;border-radius:4px">
                                    Klik untuk putar
                                </span>
                            </div>
                            <div style="position:absolute;bottom:0;left:0;right:0;
                                padding:6px 8px;display:flex;justify-content:flex-end;">
                                <a href="${file.url}" download target="_blank"
                                    onclick="event.stopPropagation()"
                                    style="display:flex;align-items:center;gap:4px;padding:3px 8px;
                                    background:white;color:#111827;border-radius:6px;
                                    font-size:.68rem;font-weight:700;text-decoration:none;">
                                    ⬇ Unduh
                                </a>
                            </div>`;
                    }

                    const htmlBukti = `
                        <div class="md-bukti" style="cursor:pointer;border:1.5px solid #e5e7eb;
                            background:#fff;overflow:hidden;position:relative;"
                            onclick="openBuktiViewer('${file.url}','${file.mime}')">
                            ${content}
                        </div>`;
                    buktiContainer.insertAdjacentHTML('beforeend', htmlBukti);
                });
            } else {
                buktiContainer.innerHTML = '<p style="font-size:0.8rem;color:#9ca3af;font-style:italic;">Tidak ada bukti terlampir.</p>';
            }

            const hasTindak = lastType === 'proses-laporan' || lastType === 'laporan-selesai';
            _V('sectionTindakLanjut', hasTindak);
            if (hasTindak) {
                const isDisplay = isDitolak || lastType === 'laporan-selesai';
                _V('tindakEditMode',    !isDisplay);
                _V('tindakDisplayMode',  isDisplay);

                if (isDisplay) {
                    _T('mdJenisTindakanText',        data.jenisTindakan);
                    _T('mdTanggalTindakText',        data.tanggalTindak);
                    _T('mdDeskripsiTindakanDisplay', data.deskripsiTindakan);

                    const dokumenEl = document.getElementById('mdDokumenDisplay');
                    if (dokumenEl) {
                        const files = data.followUpFiles || [];
                        if (files.length > 0) {
                            dokumenEl.innerHTML = files.map(f => `
                                <div style="display:flex;align-items:center;gap:8px;flex:1">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span style="font-size:.83rem;font-weight:600;color:#111827">${f.nama}</span>
                                </div>
                                <a href="${f.url}" target="_blank" class="md-dl-btn">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="13" height="13">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Unduh
                                </a>
                            `).join('<div style="border-top:1px dashed #bbf7d0;margin:6px 0;"></div>');
                        } else {
                            dokumenEl.innerHTML = `
                                <span style="color:#9ca3af;font-style:italic;font-size:.78rem;">
                                    Tidak ada bukti pelaksanaan
                                </span>`;
                        }
                    }
                    // Pelaksana
                    const pelaksanaEl = document.getElementById('mdPelaksanaText');
                    if (pelaksanaEl) pelaksanaEl.textContent = data.pelaksana || '—';

                    // Keterlibatan Orang Tua
                    const ortuFv   = document.getElementById('mdKeterlibatanOrtuFv');
                    const ortuText = document.getElementById('mdKeterlibatanOrtuText');
                    if (ortuText && ortuFv) {
                        const ortuVal = data.keterlibatanOrtu;
                        const isYa    = ortuVal === true || ortuVal === 1 || ortuVal === 'ya';
                        const isTidak = ortuVal === false || ortuVal === 0 || ortuVal === 'tidak';

                        if (isYa) {
                            ortuFv.style.background  = '#f0fdf4';
                            ortuFv.style.borderColor = '#bbf7d0';
                            ortuText.textContent     = '✅ Ya, terlibat';
                            ortuText.style.color     = '';
                            ortuText.style.fontStyle = '';
                        } else if (isTidak) {
                            ortuFv.style.background  = '#fef2f2';
                            ortuFv.style.borderColor = '#fecaca';
                            ortuText.textContent     = '❌ Tidak terlibat';
                            ortuText.style.color     = '';
                            ortuText.style.fontStyle = '';
                        } else {
                            ortuFv.style.background  = '#f9fafb';
                            ortuFv.style.borderColor = '#e5e7eb';
                            ortuText.textContent     = '— Tidak diisi';
                            ortuText.style.color     = '#9ca3af';
                            ortuText.style.fontStyle = 'italic';
                        }
                    }

                    const catatanWrap = document.getElementById('mdCatatanTambahanWrap');
                    const catatanDisp = document.getElementById('mdCatatanTambahanDisplay');
                    if (data.catatanTambahan) {
                        if (catatanWrap) catatanWrap.style.display = '';
                        if (catatanDisp) catatanDisp.textContent = data.catatanTambahan;
                    } else {
                        if (catatanWrap) catatanWrap.style.display = 'none';
                    }
                } else {
                    loadDisciplineActions().then(populateTindakanSelect);

                    ['mdDeskripsiTindakan','mdCatatanTambahan'].forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.value = '';
                    });
                    const tgl = document.getElementById('mdTanggalTindak');
                    if (tgl) tgl.value = '';
                    const sel = document.getElementById('mdJenisTindakan');
                    if (sel) sel.value = '';
                    const info = document.getElementById('mdTindakanInfo');
                    if (info) info.style.display = 'none';
                    const prev = document.getElementById('mdFilePreview');
                    if (prev) prev.style.display = 'none';
                }
            }

            // Tambah setelah render footer
            const isSelesai = _currentType === 'laporan-selesai' || _currentType === 'laporan-ditolak';
            _V('sectionFeedback', isSelesai);

            if (isSelesai) {
                const feedbackEl = document.getElementById('feedbackContent');
                if (feedbackEl) {
                    if (data.feedback) {
                        const EMOJI = ['', '😡', '😞', '😐', '😊', '🌟'];
                        const LABEL = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Luar Biasa'];
                        const r = data.feedback.rating;
                        feedbackEl.innerHTML = `
                            <div style="display:flex;align-items:center;gap:12px;margin-bottom:${data.feedback.pesan ? '10px' : '0'}">
                                <span style="font-size:2rem;">${EMOJI[r]}</span>
                                <div>
                                    <div style="font-weight:700;font-size:.9rem;color:#111827;">${LABEL[r]}</div>
                                    <div style="font-size:.75rem;color:#9ca3af;">Rating ${r}/5</div>
                                </div>
                            </div>
                            ${data.feedback.pesan ? `
                            <div class="md-desc" style="margin-top:0;font-style:italic;color:#374151;">
                                "${data.feedback.pesan}"
                            </div>` : ''}
                        `;
                    } else {
                        feedbackEl.innerHTML = `
                            <span style="color:#9ca3af;font-style:italic;font-size:.78rem;">
                                Pelapor belum mengisi penilaian
                            </span>
                        `;
                    }
                }
            }

            const footer = document.getElementById('mdFooter');
            footer.innerHTML = (_FOOTER[_currentType] || []).map(b =>
                `<button class="md-btn ${b.c}" onclick="${b.a}">${b.i ? _ICONS[b.i] : ''} ${b.l}</button>`
            ).join('');

            const overlay = document.getElementById('modalDetail');
            overlay.scrollTop = 0;
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';

            if (scrollToTindak) {
                setTimeout(() => {
                    const tindakEl = document.getElementById('sectionTindakLanjut');
                    if (tindakEl) {
                        tindakEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 300);
            }
        }

        function _renderProgressTrail(tahapTerakhir) {
            const STEPS = [
                { key:'laporan-masuk',       label:'Laporan Masuk' },
                { key:'menunggu-verifikasi', label:'Verifikasi' },
                { key:'proses-laporan',      label:'Proses' },
            ];
            const idx = STEPS.findIndex(s => s.key === tahapTerakhir);
            const wrap = document.getElementById('sectionPenolakan');
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

        var _disciplineActions = [];

        async function loadDisciplineActions() {
            if (_disciplineActions.length > 0) return;
            try {
                const json = await fetchAdminJson('/api/admin/discipline-actions');
                // list() mengembalikan array langsung
                if (Array.isArray(json)) _disciplineActions = json;
            } catch (e) { console.error('Gagal load discipline actions', e); }
        }

        function populateTindakanSelect() {
            const sel = document.getElementById('mdJenisTindakan');
            if (!sel) return;
            // Hapus opsi lama kecuali placeholder
            while (sel.options.length > 1) sel.remove(1);
            _disciplineActions.forEach(a => {
                const opt = document.createElement('option');
                opt.value        = a.id;
                opt.textContent  = `${a.name} (${a.level})`;
                opt.dataset.desc  = a.description || '';
                opt.dataset.level = a.level || '';
                opt.dataset.cond  = a.condition || '';
                sel.appendChild(opt);
            });
        }

        function onTindakanChange(sel) {
            const opt     = sel.options[sel.selectedIndex];
            const desc    = opt.dataset.desc  || '';
            const level   = opt.dataset.level || '';
            const cond    = opt.dataset.cond  || '';
            const textarea = document.getElementById('mdDeskripsiTindakan');
            const infoBox  = document.getElementById('mdTindakanInfo');

            if (textarea) textarea.value = desc;

            if (infoBox && sel.value) {
                const bgMap    = { Ringan:'#d1fae5', Sedang:'#fef3c7', Berat:'#fee2e2' };
                const colorMap = { Ringan:'#065f46', Sedang:'#92400e', Berat:'#7f1d1d' };
                infoBox.style.display    = '';
                infoBox.style.background = bgMap[level]    || '#f3f4f6';
                infoBox.style.color      = colorMap[level] || '#374151';
                infoBox.innerHTML = `<strong>Level: ${level}</strong>${cond ? ' &nbsp;·&nbsp; ' + cond : ''}`;
            } else if (infoBox) {
                infoBox.style.display = 'none';
            }
        }

        function onFollowUpFileSelected(input) {
            const preview = document.getElementById('mdFilePreview');
            if (!preview) return;
            preview.style.display = 'flex';
            preview.innerHTML = '';
            Array.from(input.files).forEach(f => {
                const tag = document.createElement('span');
                tag.style.cssText = 'font-size:.73rem;background:#f0fdf4;color:#166534;padding:4px 10px;border-radius:99px;border:1px solid #bbf7d0;';
                tag.textContent = f.name;
                preview.appendChild(tag);
            });
        }

        async function submitFollowUp() {
            const actionId  = document.getElementById('mdJenisTindakan')?.value;
            const tanggal   = document.getElementById('mdTanggalTindak')?.value;
            const deskripsi = document.getElementById('mdDeskripsiTindakan')?.value?.trim();
            const catatan   = document.getElementById('mdCatatanTambahan')?.value?.trim();
            const files     = document.getElementById('mdFileInput')?.files;

            if (!actionId)  { showAdminToast('Jenis tindakan wajib dipilih.', 'error'); return; }
            if (!tanggal)   { showAdminToast('Tanggal pelaksanaan wajib diisi.', 'error'); return; }
            if (!deskripsi || deskripsi.length < 10) {
                showAdminToast('Deskripsi tindakan wajib diisi (min. 10 karakter).', 'error'); return;
            }

            const formData = new FormData();
            formData.append('discipline_action_id', actionId);
            formData.append('tanggal_pelaksanaan',  tanggal);
            formData.append('deskripsi',            deskripsi);
            if (catatan) formData.append('catatan_tambahan', catatan);
            if (files) Array.from(files).forEach(f => formData.append('files[]', f));

            try {
                const json = await fetchAdminJson(`/api/admin/reports/${_currentData.id}/follow-up`, {
                    method:  'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '' },
                    body:    formData,
                });
                if (json.success) {
                    showAdminToast('Tindak lanjut berhasil disimpan.', 'success');
                    closeDetailModal();
                    if (typeof loadRealData === 'function') loadRealData();
                } else {
                    showAdminToast(json.message || 'Gagal menyimpan.', 'error');
                }
            } catch (e) {
                showAdminToast('Koneksi bermasalah.', 'error');
            }
        }

        function showAdminToast(msg, type = 'success') {
            const tc = document.getElementById('toastContainer') || document.querySelector('.toast-container');
            if (!tc) { alert(msg); return; }
            const t = document.createElement('div');
            t.className = `toast ${type}`;
            t.innerHTML = `<div class="toast-body"><div class="toast-msg">${msg}</div></div>`;
            tc.appendChild(t);
            setTimeout(() => { t.classList.add('leaving'); setTimeout(() => t.remove(), 400); }, 3500);
        }

        function closeDetailModal() {
            document.getElementById('modalDetail').style.display = 'none';
            document.body.style.overflow = '';
        }

        function openBuktiViewer(url, mime) {
            const isVideo = mime.startsWith('video/');
            const overlay = document.createElement('div');
            overlay.style.cssText = `
                position:fixed;inset:0;z-index:9999;
                background:rgba(0,0,0,.9);
                display:flex;align-items:center;justify-content:center;
                padding:20px;`;
            overlay.innerHTML = isVideo
                ? `<video controls autoplay style="max-width:90vw;max-height:85vh;border-radius:12px;outline:none">
                       <source src="${url}" type="${mime}">
                   </video>`
                : `<img src="${url}" style="max-width:90vw;max-height:85vh;border-radius:12px;object-fit:contain">`;

            // Tombol tutup
            const closeBtn = document.createElement('button');
            closeBtn.innerHTML = '✕';
            closeBtn.style.cssText = `
                position:fixed;top:16px;right:20px;
                background:rgba(255,255,255,.15);color:white;border:none;
                width:36px;height:36px;border-radius:50%;font-size:1rem;
                cursor:pointer;font-weight:700;`;
            closeBtn.onclick = () => overlay.remove();
            overlay.appendChild(closeBtn);

            // Tombol download di viewer
            const dlBtn = document.createElement('a');
            dlBtn.href     = url;
            dlBtn.download = '';
            dlBtn.target   = '_blank';
            dlBtn.innerHTML = '⬇ Unduh';
            dlBtn.style.cssText = `
                position:fixed;bottom:20px;left:50%;transform:translateX(-50%);
                background:#10b981;color:white;padding:8px 20px;border-radius:10px;
                font-size:.82rem;font-weight:700;text-decoration:none;`;
            overlay.appendChild(dlBtn);

            overlay.addEventListener('click', (e) => { if (e.target === overlay) overlay.remove(); });
            document.body.appendChild(overlay);
        }

        function downloadAllBukti() {
            const files = window._currentBuktiFiles || [];
            files.forEach((f, i) => {
                setTimeout(() => {
                    const a = document.createElement('a');
                    a.href     = f.url;
                    a.download = '';
                    a.target   = '_blank';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                }, i * 500);
            });
        }

        document.getElementById('modalDetail').addEventListener('click', function(e) {
            if (e.target === this) closeDetailModal();
        });

        function _T(id, v) {
            const e = document.getElementById(id);
            if (e) e.textContent = v || '—';
        }
        function _V(id, show) {
            const e = document.getElementById(id);
            if (e) e.style.display = show ? '' : 'none';
        }
        </script>