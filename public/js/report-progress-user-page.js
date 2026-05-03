    /**
     * report-progress-user-page.js
     * Sistem lengkap 5 tahap + Reminder 2x/hari + Toast pojok kanan atas
     */

    /* ══════════════════════════════════════════════
    STATE
    ══════════════════════════════════════════════ */
    let _reportData  = null;
    let _currentCode = null;
    let _searchTimeout = null;
    let _emojiRating = 0;
    let _gradeOptions = [];
    let _majorOptions = [];
    let _majorsFull = [];
    let _allPairs = []; // Menyimpan daftar kelas dari API

    const EMOJI_OPTIONS = [
        { emoji: '😡', label: 'Sangat Buruk', val: 1 },
        { emoji: '😞', label: 'Buruk',        val: 2 },
        { emoji: '😐', label: 'Cukup',        val: 3 },
        { emoji: '😊', label: 'Baik',         val: 4 },
        { emoji: '🌟', label: 'Luar Biasa',   val: 5 },
    ];

    const REMINDER_MAX = 2;           // batas per hari
    const REMINDER_KEY = 'reminder_'; // prefix localStorage

    /* ══════════════════════════════════════════════
    INIT
    ══════════════════════════════════════════════ */
    document.addEventListener('DOMContentLoaded', async () => {
        const params = new URLSearchParams(window.location.search);
        _currentCode = params.get('code') || sessionStorage.getItem('lacak_code');
        if (!_currentCode) { window.location.href = '/lacak'; return; }

        // ✅ pairs & majors dulu sebelum loadReport
        await fetchPairs();
        await fetchMajors();

        await loadReport(_currentCode);

        document.querySelector('.back-btn')?.addEventListener('click', e => {
            e.preventDefault();
            window.location.href = '/lacak';
        });

        if (!document.getElementById('toastContainer')) {
            const tc = document.createElement('div');
            tc.id = 'toastContainer';
            tc.className = 'toast-container';
            document.body.appendChild(tc);
        }
    });

    /* ══════════════════════════════════════════════
    FETCH GRADES – simpan ke _gradeOptions
    (tidak lagi menggunakan <datalist>)
    ══════════════════════════════════════════════ */
    async function fetchGrades() {
        try {
            const res  = await fetch('/api/students/grades');
            const json = await res.json();
            
            console.log("Data Kelas Diterima:", json); 

            // CEK APAKAH DATANYA ARRAY (karena sudah tidak pakai json.success)
            if (Array.isArray(json)) {
                _gradeOptions = json; // Langsung masukkan json-nya
                updateAllKelasSelects();
            }
        } catch (e) { 
            console.error("Gagal memuat daftar kelas", e); 
        }
    }

    /**
     * Membangun HTML <option> dari _gradeOptions.
     */
    function buildKelasOptions() {
        return _gradeOptions.map(g => `<option value="${esc(g)}">${esc(g)}</option>`).join('');
    }

    /**
     * Setelah fetchGrades() selesai, perbarui semua <select> kelas
     * yang sudah ada di DOM agar opsi terisi.
     */
    function updateAllKelasSelects() {
        // Mencari semua select dengan class 'kelas-select'
        document.querySelectorAll('select.kelas-select').forEach(sel => {
            const current = sel.value; // Simpan pilihan lama jika ada
            
            // Isi ulang opsinya
            sel.innerHTML = `<option value="" disabled selected>Pilih Kelas</option>${buildKelasOptions()}`;
            
            // Kembalikan pilihan lama jika memang sudah dipilih
            if (current) sel.value = current;
        });
    }

    /* ══════════════════════════════════════════════
    LOAD REPORT
    ══════════════════════════════════════════════ */
    async function loadReport(code) {
        showSkeleton(true);
        try {
            const res  = await fetch(`/api/reports/track?code=${encodeURIComponent(code)}`, {
                headers: { 'Accept': 'application/json' },
            });
            const json = await res.json();

            if (!res.ok || !json.success) {
                showError(json.message || 'Laporan tidak ditemukan.');
                return;
            }

            _reportData = json.data;
            renderAll(_reportData);
            showSkeleton(false);
        } catch (e) {
            console.error(e);
            showError('Koneksi bermasalah. Silakan refresh halaman.');
        }
    }

    /* ══════════════════════════════════════════════
    RENDER ALL
    ══════════════════════════════════════════════ */
    function renderAll(d) {
        console.log('incident_time:', d.incident_time, '| incident_date:', d.incident_date);
        renderHeader(d);
        renderStepper(d);
        renderSidebar(d);
        renderActivities(d);
        renderMainContent(d);
        renderReminderBtn(d);
        renderGlobalActionBanner(d);

        if (['selesai', 'ditolak'].includes(d.status)) {
            setTimeout(() => {
                const panelId = d.status === 'selesai' ? 'panelSelesai' : 'panelDitolak';
                const body    = document.getElementById(
                    d.status === 'selesai' ? 'bodySelesai' : 'bodyDitolak'
                );
                const btn = document.querySelector(`#${panelId} .btn-toggle-detail`);
                if (body && !body.classList.contains('open')) {
                    body.classList.add('open');
                    btn?.classList.add('open');
                }
            }, 300);
        }
        document.querySelector('.demo-switcher')?.remove();
    }

    /* ─── Header ─────────────────────────── */
    function renderHeader(d) {
        setText('displayKode',    d.ticket_code);
        setText('displayTanggal', d.created_at);
        setText('sideKode',       d.ticket_code);

        const pill = document.getElementById('statusPill');
        if (pill) {
            pill.textContent = d.status_label?.toUpperCase() ?? d.status.toUpperCase();
            pill.className   = `status-pill status-${d.status_color}`;
        }
    }

    /* ─── Sidebar ─────────────────────────── */
    function renderSidebar(d) {
        setText('sideNama',    d.student_name  || '(anonim)');
        setText('sideNis',     d.student_nis   || '-');
        setText('sideKelas',   d.student_grade || '-');
        setText('sideTanggal', d.created_at);
        const urg = document.getElementById('sideUrgensi');
        if (urg) {
            urg.innerHTML = d.urgency
                ? `<span class="urg-badge ${d.urgency}">${d.urgency_label}</span>`
                : '-';
        }
    }

    /* ─── Stepper ─────────────────────────── */
    function renderStepper(d) {
        const track = document.getElementById('stepperTrack');
        if (!track) return;

        const allSteps = [
            { number: 1, label: 'Laporan<br>Masuk',      status: 'masuk'    },
            { number: 2, label: 'Menunggu<br>Verifikasi', status: 'menunggu' },
            { number: 3, label: 'Sedang<br>Diproses',     status: 'diproses' },
            { number: 4, label: 'Penanganan<br>Selesai',  status: 'selesai'  },
        ];

        // Urutan status normal (index untuk perbandingan)
        const statusOrder = ['masuk', 'menunggu', 'diproses', 'selesai'];

        let steps;

        if (d.status === 'ditolak') {
            // Tentukan sampai mana laporan sudah berjalan sebelum ditolak
            // tahapTerakhir dari API: 'laporan-masuk', 'menunggu-verifikasi', 'proses-laporan'
            const tahapMap = {
                'laporan-masuk'      : 0,
                'menunggu-verifikasi': 1,
                'proses-laporan'     : 2,
            };
            const rejectedAtIdx = tahapMap[d.tahap_terakhir] ?? tahapMap[d.rejected_from_stage] ?? 0;

            // Ambil step yang sudah dilewati + step "Ditolak" di akhir
            const passedSteps = allSteps.slice(0, rejectedAtIdx + 1);
            steps = [
                ...passedSteps.map((s, i) => ({
                    ...s,
                    state: i < rejectedAtIdx ? 'done' : 'done', // semua passed = done
                })),
                {
                    number : passedSteps.length + 1,
                    label  : 'Laporan<br>Ditolak',
                    state  : 'rejected',
                },
            ];
        } else {
            const currentIdx = statusOrder.indexOf(d.status);
            steps = allSteps.map((s, i) => ({
                ...s,
                state: i < currentIdx ? 'done' : i === currentIdx ? 'active' : '',
            }));
        }

        track.innerHTML = steps.map((step, i) => {
            let circle;
            if (step.state === 'done')     circle = icoCheck();
            else if (step.state === 'rejected') circle = icoX();
            else                           circle = `<span>${step.number}</span>`;

            const isLast    = i === steps.length - 1;
            const connClass = (step.state === 'done' || step.state === 'rejected') ? ' done' : '';

            return `
                <div class="stepper-step ${step.state}">
                    <div class="step-circle">${circle}</div>
                    <div class="step-label">${step.label}</div>
                </div>
                ${!isLast ? `<div class="step-connector${connClass}"></div>` : ''}
            `;
        }).join('');
    }

    /* ─── Activities ──────────────────────── */
    function renderActivities(d) {
        const list = document.getElementById('activityList');
        if (!list) return;

        if (!d.activities || d.activities.length === 0) {
            list.innerHTML = `<div style="text-align:center;padding:24px 0;color:var(--gray-400);font-size:.84rem;">Belum ada aktivitas tercatat.</div>`;
            return;
        }

        list.innerHTML = d.activities.map((a, i) => `
            <div class="activity-item" style="animation-delay:${i * .06}s">
                <div class="act-dot-wrap">
                    <div class="act-dot ${a.dot_color || (i === 0 ? 'green' : 'gray')}"></div>
                    ${i < d.activities.length - 1 ? '<div class="act-line"></div>' : ''}
                </div>
                <div class="act-body">
                    <div><span class="act-name">${esc(a.actor)}</span><span class="act-time">${esc(a.created_at)}</span></div>
                    <p class="act-desc">${esc(a.description)}</p>
                    ${a.notes ? `<p class="activity-notes">${esc(a.notes)}</p>` : ''}
                </div>
            </div>
        `).join('');
    }

    /* ══════════════════════════════════════════════
    RENDER MAIN CONTENT (router per status)
    ══════════════════════════════════════════════ */
    function renderMainContent(d) {
        const c = document.getElementById('mainContent');
        if (!c) return;
        const s = d.status;
        if (['masuk','terkirim'].includes(s))           renderStageTerkirim(c, d);
        else if (['menunggu','verifikasi'].includes(s)) renderStageVerifikasi(c, d);
        else if (['diproses','proses'].includes(s))     renderStageProses(c, d);
        else if (s === 'selesai')                       renderStageSelesai(c, d);
        else if (s === 'ditolak')                       renderStageDitolak(c, d);
    }

    /* ══════════════════════════════════════════════
    TAHAP 1 – TERKIRIM
    ══════════════════════════════════════════════ */
    function renderStageTerkirim(c, d) {
        c.innerHTML = `
            <div class="detail-panel" id="panelTerkirim">
                <button class="btn-toggle-detail" id="btnToggleTerkirim" onclick="togglePanel('panelTerkirim', this)">
                    <div class="btn-toggle-detail-left">
                        <div class="icon-wrap">${icoDoc()}</div>
                        <div>
                            <div class="btn-toggle-detail-text">Lihat Detail Laporan</div>
                            <div class="btn-toggle-detail-sub">Identitas, deskripsi, dan bukti foto</div>
                        </div>
                    </div>
                    ${icoChevron()}
                </button>
                <div class="detail-panel-body" id="bodyTerkirim">
                    <div class="detail-panel-inner">${buildDetailAwal(d)}</div>
                </div>
            </div>
        `;
    }

    /* ══════════════════════════════════════════════
    TAHAP 2 – MENUNGGU VERIFIKASI
    ══════════════════════════════════════════════ */
    function renderStageVerifikasi(c, d) {
        c.innerHTML = `
            <!-- Tombol Isi Detail -->
            <button class="btn-isi-detail" id="btnIsiDetail" onclick="toggleFormIsi()">
                <div class="btn-isi-detail-left">
                    <div class="btn-isi-detail-icon">${icoEdit()}</div>
                    <div>
                        <div class="btn-isi-detail-text">Isi Detail Laporan</div>
                        <div class="btn-isi-detail-sub">Waktu, lokasi, dan pihak yang terlibat</div>
                    </div>
                </div>
                <svg class="btn-isi-detail-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            <!-- Form Isi Detail (accordion) -->
            <div class="form-detail-card" id="formIsiDetail">
                <div class="form-detail-header">
                    <div class="icon">${icoEdit()}</div>
                    <div>
                        <h3>Lengkapi Detail Laporan</h3>
                        <p>Informasi ini membantu petugas menangani laporan Anda</p>
                    </div>
                </div>
                <div class="form-detail-body">

                    <!-- Waktu & Lokasi -->
                    <div class="detail-section-title purple" style="margin-bottom:16px;">📍 Waktu &amp; Lokasi Kejadian</div>
                    <div class="form-grid-3" style="margin-bottom:16px;">
                        <div class="form-group" style="margin:0;">
                            <label class="form-label">Tanggal Kejadian <span class="required">*</span></label>
                            <input type="date" class="form-input" id="inp_tgl">
                        </div>
                        <div class="form-group" style="margin:0;">
                            <label class="form-label">Jam Kejadian <span class="optional">(opsional)</span></label>
                            <input type="time" class="form-input" id="inp_jam">
                        </div>
                        <div class="form-group" style="margin:0;">
                            <label class="form-label">Tempat Kejadian <span class="required">*</span></label>
                            <input type="text" class="form-input" id="inp_lokasi" placeholder="cth: Ruang kelas X-A">
                        </div>
                    </div>

                    <div class="detail-divider"></div>

                    <!-- Pelaku -->
                    <div class="detail-section-title amber" style="margin-bottom:10px;">⚠️ Pelaku <span style="font-weight:500;text-transform:none;letter-spacing:0;color:var(--gray-400);font-size:.68rem;">(minimal 1)</span></div>
                    <div class="person-rows" id="pelakuRows"></div>
                    <button class="btn-add-person" onclick="addRow('pelaku')" type="button">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Pelaku
                    </button>

                    <!-- Korban -->
                    <div class="detail-section-title red" style="margin-top:20px;margin-bottom:10px;">🛡️ Korban <span style="font-weight:500;text-transform:none;letter-spacing:0;color:var(--gray-400);font-size:.68rem;">(minimal 1)</span></div>
                    <div class="person-rows" id="korbanRows"></div>
                    <button class="btn-add-person" onclick="addRow('korban')" type="button">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Korban
                    </button>

                    <!-- Saksi -->
                    <div class="detail-section-title blue" style="margin-top:20px;margin-bottom:10px;">👁️ Saksi <span style="font-weight:500;text-transform:none;letter-spacing:0;color:var(--gray-400);font-size:.68rem;">(opsional)</span></div>
                    <div class="person-rows" id="saksiRows"></div>
                    <button class="btn-add-person" onclick="addRow('saksi')" type="button">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Saksi
                    </button>

                    <div class="detail-divider"></div>

                    <!-- Checklist -->
                    <div class="detail-section-title" style="margin-bottom:12px;">✅ Konfirmasi &amp; Verifikasi</div>
                    <div class="checklist-wrap">
                        <label class="check-item" onclick="toggleCheck(this)">
                            <input type="checkbox" id="chk1">
                            <label>Saya menyatakan bahwa informasi yang disampaikan adalah benar dan dapat dipertanggungjawabkan.</label>
                        </label>
                        <label class="check-item" onclick="toggleCheck(this)">
                            <input type="checkbox" id="chk2">
                            <label>Saya bersedia dipanggil untuk memberikan keterangan lebih lanjut jika diperlukan.</label>
                        </label>
                        <label class="check-item" onclick="toggleCheck(this)">
                            <input type="checkbox" id="chk3">
                            <label>Saya memahami bahwa laporan ini akan ditangani secara rahasia oleh pihak sekolah.</label>
                        </label>
                    </div>

                    <button class="btn-simpan" onclick="simpanDetail()" id="btnSimpan" type="button">
                        ${icoCheck()} Simpan &amp; Kirim Detail
                    </button>
                </div>
            </div>

            <!-- Lihat laporan awal (accordion) -->
            <div class="detail-panel" id="panelAwal">
                <button class="btn-toggle-detail" onclick="togglePanel('panelAwal', this)">
                    <div class="btn-toggle-detail-left">
                        <div class="icon-wrap">${icoDoc()}</div>
                        <div>
                            <div class="btn-toggle-detail-text">Lihat Laporan Awal</div>
                            <div class="btn-toggle-detail-sub">Identitas pelapor, deskripsi, dan bukti foto</div>
                        </div>
                    </div>
                    ${icoChevron()}
                </button>
                <div class="detail-panel-body" id="bodyAwal">
                    <div class="detail-panel-inner">${buildDetailAwal(d)}</div>
                </div>
            </div>
        `;

        addRow('pelaku');
        addRow('korban');
    }

    /* ══════════════════════════════════════════════
    TAHAP 3 – SEDANG DIPROSES
    ══════════════════════════════════════════════ */
    function renderStageProses(c, d) {
        c.innerHTML = `
            <!-- Card 1: Tindak Lanjut (paling atas) -->
            ${buildTindakLanjutCard(d)}

            <!-- Card 2: Detail Laporan readonly -->
            <div class="detail-panel" id="panelDetailReadonly">
                <button class="btn-toggle-detail" onclick="togglePanel('panelDetailReadonly', this)">
                    <div class="btn-toggle-detail-left">
                        <div class="btn-isi-detail-icon">${icoEdit()}</div>
                        <div>
                            <div class="btn-toggle-detail-text">Detail Laporan</div>
                            <div class="btn-toggle-detail-sub">Waktu, lokasi, dan pihak yang terlibat</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="font-size:.72rem;font-weight:600;background:#dcfce7;color:#166534;
                                    padding:4px 12px;border-radius:99px;white-space:nowrap;">
                            ✅ Sudah Diisi
                        </span>
                        ${icoChevron()}
                    </div>
                </button>
                <div class="detail-panel-body" id="bodyDetailReadonly">
                    <div class="detail-panel-inner">
                        ${buildFormDetailReadonly(d)}
                    </div>
                </div>
            </div>

            <!-- Card 3: Lihat Laporan Awal -->
            <div class="detail-panel" id="panelProses">
                <button class="btn-toggle-detail" onclick="togglePanel('panelProses', this)">
                    <div class="btn-toggle-detail-left">
                        <div class="icon-wrap">${icoDoc()}</div>
                        <div>
                            <div class="btn-toggle-detail-text">Lihat Laporan Awal</div>
                            <div class="btn-toggle-detail-sub">Identitas pelapor, deskripsi, dan bukti foto</div>
                        </div>
                    </div>
                    ${icoChevron()}
                </button>
                <div class="detail-panel-body" id="bodyProses">
                    <div class="detail-panel-inner">${buildDetailAwal(d)}</div>
                </div>
            </div>
        `;
    }

    function buildTindakLanjutCard(d) {
        const tl = d.tindak_lanjut;

        if (!tl) {
            return `
                <div class="detail-panel" id="panelTindakLanjut">
                    <button class="btn-toggle-detail" onclick="togglePanel('panelTindakLanjut', this)">
                        <div class="btn-toggle-detail-left">
                            <div class="icon-wrap" style="background:#fef3c7;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#d97706">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="btn-toggle-detail-text">Tindak Lanjut</div>
                                <div class="btn-toggle-detail-sub">Penanganan oleh petugas sekolah</div>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span style="font-size:.72rem;font-weight:600;background:#fef3c7;color:#92400e;
                                        padding:4px 12px;border-radius:99px;white-space:nowrap;">
                                ⏳ Menunggu
                            </span>
                            ${icoChevron()}
                        </div>
                    </button>
                    <div class="detail-panel-body" id="bodyTindakLanjut">
                        <div class="detail-panel-inner">

                            <!-- Placeholder informatif -->
                            <div style="
                                display:flex;flex-direction:column;align-items:center;
                                gap:12px;padding:32px 20px;text-align:center;
                            ">
                                <div style="
                                    width:56px;height:56px;border-radius:50%;
                                    background:#fef3c7;display:flex;align-items:center;
                                    justify-content:center;
                                ">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#d97706">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div style="font-size:.92rem;font-weight:600;color:#92400e;margin-bottom:6px;">
                                        Laporan Sedang Ditinjau
                                    </div>
                                    <div style="font-size:.8rem;color:#78716c;line-height:1.6;max-width:340px;">
                                        Petugas sekolah sedang mempelajari laporan Anda dan akan segera menentukan 
                                        tindakan yang tepat. Informasi tindak lanjut akan muncul di sini setelah 
                                        petugas melakukan penanganan.
                                    </div>
                                </div>
                                <div style="
                                    display:flex;gap:8px;flex-wrap:wrap;justify-content:center;
                                    margin-top:4px;
                                ">
                                    <span style="
                                        font-size:.74rem;background:#f0fdf4;color:#166534;
                                        padding:4px 12px;border-radius:99px;border:1px solid #bbf7d0;
                                    ">✓ Laporan diterima</span>
                                    <span style="
                                        font-size:.74rem;background:#fef3c7;color:#92400e;
                                        padding:4px 12px;border-radius:99px;border:1px solid #fde68a;
                                    ">⏳ Menunggu tindakan</span>
                                    <span style="
                                        font-size:.74rem;background:#f1f5f9;color:#64748b;
                                        padding:4px 12px;border-radius:99px;border:1px solid #e2e8f0;
                                    ">○ Bukti & keterangan</span>
                                </div>
                            </div>

                            <div style="
                                margin-top:8px;padding:14px 16px;
                                background:#fffbeb;border:1px solid #fde68a;
                                border-radius:10px;font-size:.79rem;color:#92400e;
                                display:flex;gap:10px;align-items:flex-start;
                            ">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#d97706"
                                    style="flex-shrink:0;margin-top:1px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Jika laporan tidak kunjung ditindaklanjuti, gunakan tombol 
                                <strong>Kirim Reminder</strong> di bagian atas halaman untuk 
                                mengingatkan petugas.</span>
                            </div>

                        </div>
                    </div>
                </div>
            `;
        }

        // Kalau sudah ada data tindak lanjut
        return `
            <div class="detail-panel" id="panelTindakLanjut">
                <button class="btn-toggle-detail" onclick="togglePanel('panelTindakLanjut', this)">
                    <div class="btn-toggle-detail-left">
                        <div class="icon-wrap" style="background:#dcfce7;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="btn-toggle-detail-text">Tindak Lanjut</div>
                            <div class="btn-toggle-detail-sub">Penanganan telah dijadwalkan oleh petugas</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="font-size:.72rem;font-weight:600;background:#dcfce7;color:#166534;
                                    padding:4px 12px;border-radius:99px;white-space:nowrap;">
                            ✅ Tersedia
                        </span>
                        ${icoChevron()}
                    </div>
                </button>
                <div class="detail-panel-body" id="bodyTindakLanjut">
                    <div class="detail-panel-inner">
                        <div class="detail-section-title teal" style="margin-bottom:16px;">⚖️ Tindak Lanjut</div>
                        <div class="form-grid-3" style="margin-bottom:16px;">
                            <div class="form-group" style="margin:0;">
                                <label class="form-label">Jenis Tindakan</label>
                                <input type="text" class="form-input" value="${esc(tl.jenis_tindakan || '-')}" disabled>
                            </div>
                            <div class="form-group" style="margin:0;">
                                <label class="form-label">Tanggal Pelaksanaan</label>
                                <input type="text" class="form-input" value="${esc(tl.tanggal_pelaksanaan || '-')}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Deskripsi Tindakan</label>
                            <div class="field-value text-area" style="min-height:80px;">${esc(tl.deskripsi || '-')}</div>
                        </div>
                        ${tl.files?.length > 0 ? `
                        <div class="detail-divider"></div>
                        <div class="detail-section-title teal" style="margin-bottom:12px;">📎 Bukti Pelaksanaan</div>
                        <div class="bukti-pelaksanaan">
                            ${tl.files.map(f => {
                                const isImage = f.mime?.startsWith('image/');
                                if (isImage) return `
                                    <div class="photo-item" onclick="openPhoto('${esc(f.url)}')">
                                        <img src="${esc(f.url)}" alt="${esc(f.nama)}" loading="lazy">
                                    </div>`;
                                return `
                                    <a href="${esc(f.url)}" target="_blank" class="bukti-item">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                        </svg>
                                        ${esc(f.nama)}
                                    </a>`;
                            }).join('')}
                        </div>` : ''}
                    </div>
                </div>
            </div>
        `;
    }

    function buildFormDetailReadonly(d) {
        const pelaku = d.pelaku || [];
        const korban = d.korban || [];
        const saksi  = d.saksi  || [];

        function buildPersonRowsReadonly(list, role, icon, label) {
            if (list.length === 0) return '';
            const colorMap = { pelaku: 'amber', korban: 'red', saksi: 'blue' };
            const color = colorMap[role] || 'blue';
            return `
                <div class="detail-section-title ${color}" style="margin-top:20px;margin-bottom:10px;">
                    ${icon} ${label}
                </div>
                <div class="person-rows">
                    ${list.map(p => `
                        <div class="person-row" style="opacity:.85;">
                            <div class="person-row-top" style="display:flex;gap:10px;align-items:flex-end;">
                                <div class="form-group" style="margin:0;flex:2;">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-input"
                                        value="${esc(p.display_name || p.name_manual || '')}" disabled>
                                </div>
                                <div class="form-group" style="margin:0;flex:1;">
                                    <label class="form-label">Kelas</label>
                                    <input type="text" class="form-input"
                                        value="${esc(p.student_grade ? p.student_grade.split(' ')[0] : (p.grade_manual || '-'))}" disabled>
                                </div>
                                <div class="form-group" style="margin:0;flex:1.2;">
                                    <label class="form-label">Jurusan</label>
                                    <input type="text" class="form-input"
                                        value="${esc(p.student_grade ? p.student_grade.split(' ').slice(1).join(' ') : (p.major_manual || '-'))}" disabled>
                                </div>
                            </div>
                            <div class="person-row-note" style="margin-top:10px;">
                                <div class="form-label" style="margin-bottom:5px;">
                                    Catatan <span style="font-weight:400;color:#9ca3af;">(opsional)</span>
                                </div>
                                <input type="text" class="form-input"
                                    value="${esc(p.notes || '')}"
                                    placeholder="Pelapor tidak mengisi catatan"
                                    disabled
                                    style="${!p.notes ? 'color:#9ca3af;font-style:italic;' : ''}">
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
        }

        return `
            <!-- Waktu & Lokasi -->
            <div class="detail-section-title purple" style="margin-bottom:16px;">📍 Waktu &amp; Lokasi Kejadian</div>
            <div class="form-grid-3" style="margin-bottom:16px;">
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Tanggal Kejadian</label>
                    <input type="text" class="form-input"
                        value="${esc(d.incident_date || '-')}" disabled>
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Jam Kejadian</label>
                    <input type="text" class="form-input"
                        value="${esc(d.incident_time || 'Tidak diisi')}" disabled>
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Tempat Kejadian</label>
                    <input type="text" class="form-input"
                        value="${esc(d.incident_location || '-')}" disabled>
                </div>
            </div>

            <div class="detail-divider"></div>

            ${buildPersonRowsReadonly(pelaku, 'pelaku', '⚠️', 'Pelaku')}
            ${buildPersonRowsReadonly(korban, 'korban', '🛡️', 'Korban')}
            ${buildPersonRowsReadonly(saksi,  'saksi',  '👁️', 'Saksi')}

            <div class="detail-divider"></div>

            <!-- Checklist readonly -->
            <div class="detail-section-title" style="margin-bottom:12px;">✅ Konfirmasi &amp; Verifikasi</div>
            <div class="checklist-wrap">
                <label class="check-item checked" style="pointer-events:none;">
                    <input type="checkbox" checked disabled>
                    <label>Saya menyatakan bahwa informasi yang disampaikan adalah benar dan dapat dipertanggungjawabkan.</label>
                </label>
                <label class="check-item checked" style="pointer-events:none;">
                    <input type="checkbox" checked disabled>
                    <label>Saya bersedia dipanggil untuk memberikan keterangan lebih lanjut jika diperlukan.</label>
                </label>
                <label class="check-item checked" style="pointer-events:none;">
                    <input type="checkbox" checked disabled>
                    <label>Saya memahami bahwa laporan ini akan ditangani secara rahasia oleh pihak sekolah.</label>
                </label>
            </div>
        `;
    }

    /* ══════════════════════════════════════════════
    TAHAP 4 – SELESAI
    ══════════════════════════════════════════════ */
    function renderStageSelesai(c, d) {
        c.innerHTML = `
            <div class="detail-panel" id="panelSelesai">
                <button class="btn-toggle-detail" onclick="togglePanel('panelSelesai', this)">
                    <div class="btn-toggle-detail-left">
                        <div class="icon-wrap">${icoDoc()}</div>
                        <div>
                            <div class="btn-toggle-detail-text">Lihat Detail Laporan</div>
                            <div class="btn-toggle-detail-sub">Seluruh data dari awal hingga tindak lanjut</div>
                        </div>
                    </div>
                    ${icoChevron()}
                </button>
                <div class="detail-panel-body" id="bodySelesai">
                    <div class="detail-panel-inner">
                        ${buildDetailAwal(d)}
                        ${d.incident_date || d.incident_location ? `<div class="detail-divider"></div>${buildDetailKejadian(d)}` : ''}
                        ${buildDetailPihak(d)}
                        ${d.tindak_lanjut ? `<div class="detail-divider"></div>${buildTindakLanjut(d)}` : ''}
                    </div>
                </div>
            </div>
            ${buildFeedbackSection(d)}
        `;
    }

    /* ══════════════════════════════════════════════
    TAHAP 5 – DITOLAK
    ══════════════════════════════════════════════ */
    function renderStageDitolak(c, d) {
        const rejStage = d.rejected_from_stage || 'masuk';
        const showKej  = ['diproses','proses','selesai'].includes(rejStage);

        c.innerHTML = `
            <div class="rejection-card">
                <div class="rejection-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <h3 class="rejection-title">Laporan Ditolak</h3>
                    <div class="rejection-meta">
                        <div class="rejection-meta-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Ditolak dari tahap: <strong>${esc(d.rejected_from_label || 'Tidak diketahui')}</strong>
                        </div>
                        <div class="rejection-meta-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            ${esc(d.rejected_at || d.updated_at)}
                        </div>
                    </div>
                    <div class="rejection-reason">
                        <strong style="display:block;margin-bottom:6px;font-size:.75rem;color:#9f1239;text-transform:uppercase;letter-spacing:.06em;">Alasan Penolakan</strong>
                        ${esc(d.rejection_reason || d.catatan_admin || 'Tidak ada catatan dari admin.')}
                    </div>
                </div>
            </div>

            <div class="detail-panel" id="panelDitolak">
                <button class="btn-toggle-detail" onclick="togglePanel('panelDitolak', this)">
                    <div class="btn-toggle-detail-left">
                        <div class="icon-wrap">${icoDoc()}</div>
                        <div>
                            <div class="btn-toggle-detail-text">Lihat Detail Laporan</div>
                            <div class="btn-toggle-detail-sub">Data yang tersimpan sebelum penolakan</div>
                        </div>
                    </div>
                    ${icoChevron()}
                </button>
                <div class="detail-panel-body" id="bodyDitolak">
                    <div class="detail-panel-inner">
                        ${buildDetailAwal(d)}
                        ${showKej && (d.incident_date || d.incident_location) ? `<div class="detail-divider"></div>${buildDetailKejadian(d)}` : ''}
                        ${showKej ? buildDetailPihak(d) : ''}
                    </div>
                </div>
            </div>
            ${buildFeedbackSection(d)}
        `;
    }

    /* ══════════════════════════════════════════════
    BUILDERS – BLOK KONTEN
    ══════════════════════════════════════════════ */

    function buildDetailAwal(d) {
        const files = d.files || [];

        return `
            <div class="detail-section">
                <div class="detail-section-title">👤 Identitas Pelapor</div>
                <div class="field-grid">
                    <div class="field-item">
                        <div class="field-label">Nama Pelapor</div>
                        <div class="field-value">${esc(d.student_name || '(anonim)')}</div>
                    </div>
                    <div class="field-item">
                        <div class="field-label">NIS</div>
                        <div class="field-value mono">${esc(d.student_nis || '-')}</div>
                    </div>
                    <div class="field-item">
                        <div class="field-label">Kelas</div>
                        <div class="field-value">${esc(d.student_grade || '-')}</div>
                    </div>
                    <div class="field-item">
                        <div class="field-label">Jenis Laporan</div>
                        <div class="field-value">-</div>
                    </div>
                </div>
            </div>
            <div class="detail-divider"></div>
            <div class="detail-section">
                <div class="detail-section-title">📝 Deskripsi Laporan</div>
                <div class="field-item">
                    <div class="field-label">Isi Laporan</div>
                    <div class="field-value text-area">${esc(d.deskripsi || '-')}</div>
                </div>
            </div>
            <div class="detail-divider"></div>
            <div class="detail-section">
                <div class="detail-section-title">🖼️ Bukti Foto / Video</div>
                ${files.length > 0 ? `
                    <div class="photo-grid">
                        ${files.map(f => {
                            const isImage = f.mime_type?.startsWith('image/');
                            const url = f.url || `/storage/reports/${d.ticket_code}/${f.original_name}`;
                            if (isImage) {
                                return `
                                    <div class="photo-item" onclick="openPhoto('${esc(url)}')">
                                        <img src="${esc(url)}" alt="${esc(f.original_name)}" loading="lazy">
                                    </div>`;
                            } else {
                                return `
                                    <a href="${esc(url)}" target="_blank" class="bukti-item">
                                        🎬 ${esc(f.original_name)}
                                    </a>`;
                            }
                        }).join('')}
                    </div>
                ` : `
                    <div style="
                        display:flex;
                        flex-direction:column;
                        align-items:center;
                        justify-content:center;
                        gap:8px;
                        padding:28px 20px;
                        background:var(--gray-50, #f9fafb);
                        border:1.5px dashed var(--gray-200, #e5e7eb);
                        border-radius:12px;
                        color:var(--gray-400, #9ca3af);
                        text-align:center;
                    ">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" opacity=".4">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span style="font-size:.82rem;font-weight:500;">Tidak ada bukti yang dilampirkan</span>
                        <span style="font-size:.76rem;">Pelapor tidak mengirimkan foto atau video pendukung</span>
                    </div>
                `}
            </div>
        `;
    }

    function buildDetailKejadian(d) {
        return `
            <div class="detail-section">
                <div class="detail-section-title purple">📍 Waktu &amp; Lokasi Kejadian</div>
                <div class="field-grid cols-3">
                    <div class="field-item">
                        <div class="field-label">Tanggal</div>
                        <div class="field-value">${esc(d.incident_date || '-')}</div>
                    </div>
                    <div class="field-item">
                        <div class="field-label">Jam</div>
                        <div class="field-value">${esc(d.incident_time) || '<span style="color:#9ca3af;font-style:italic;">Tidak diisi</span>'}</div>
                    </div>
                    <div class="field-item">
                        <div class="field-label">Tempat</div>
                        <div class="field-value">${esc(d.incident_location || '-')}</div>
                    </div>
                </div>
            </div>
        `;
    }

    function buildDetailPihak(d) {
        const pelaku = d.pelaku || [];
        const korban = d.korban || [];
        const saksi  = d.saksi  || [];

        const groups = [
            { key: pelaku, label: 'Pelaku', role: 'pelaku', icon: '⚠️' },
            { key: korban, label: 'Korban', role: 'korban', icon: '🛡️' },
            { key: saksi,  label: 'Saksi',  role: 'saksi',  icon: '👁️' },
        ];

        const hasAny = groups.some(g => g.key.length > 0);
        if (!hasAny) return '';

        return `
            <div class="detail-divider"></div>
            <div class="detail-section">
                <div class="detail-section-title blue">👥 Pihak yang Terlibat</div>
                <div class="person-cards">
                    ${groups.filter(g => g.key.length > 0).map(g =>
                        g.key.map(x => `
                            <div class="person-card">
                                <div class="person-avatar ${g.role}">${esc(x.display_name?.charAt(0)?.toUpperCase() || '?')}</div>
                                <div style="min-width:0;">
                                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                        <span class="person-info-name">${esc(x.display_name)}</span>
                                        <span class="person-role-badge ${g.role}">${g.icon} ${g.label}</span>
                                    </div>
                                    ${x.student_grade ? `<div class="person-info-meta">${esc(x.student_grade)}${x.student_nis ? ' · NIS: ' + esc(x.student_nis) : ''}</div>` : ''}
                                    ${x.notes ? `<div class="person-info-note">${esc(x.notes)}</div>` : ''}
                                </div>
                            </div>
                        `).join('')
                    ).join('')}
                </div>
            </div>
        `;
    }

    function buildTindakLanjut(d) {
        const tl     = d.tindak_lanjut || {};
        const buktis = tl.files || tl.bukti || [];
        return `
            <div class="tindaklanjut-card">
                <div class="tindaklanjut-header">
                    <div class="icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3>Tindak Lanjut</h3>
                        <p>Informasi penanganan yang telah dilakukan</p>
                    </div>
                </div>
                <div class="detail-section">
                    <div class="detail-section-title teal">📋 Informasi Tindakan</div>
                    <div class="field-grid cols-3">
                        <div class="field-item">
                            <div class="field-label">Jenis Tindakan</div>
                            <div class="field-value">${esc(tl.jenis_tindakan || '-')}</div>
                        </div>
                        <div class="field-item">
                            <div class="field-label">Tanggal Pelaksanaan</div>
                            <div class="field-value">${esc(tl.tanggal_pelaksanaan || '-')}</div>
                        </div>
                        <div class="field-item">
                            <div class="field-label">Durasi</div>
                            <div class="field-value">${esc(tl.durasi || '-')}</div>
                        </div>
                        <div class="field-item full">
                            <div class="field-label">Deskripsi Tindakan</div>
                            <div class="field-value text-area">${esc(tl.deskripsi || '-')}</div>
                        </div>
                        ${tl.catatan_tambahan ? `
                        <div class="field-item full">
                            <div class="field-label">Catatan</div>
                            <div class="field-value" style="font-style:italic;color:#4b5563;">
                                ${esc(tl.catatan_tambahan)}
                            </div>
                        </div>` : `
                        <div class="field-item full">
                            <div class="field-label">Catatan</div>
                            <div class="field-value" style="font-style:italic;color:#9ca3af;">
                                Tidak ada catatan dari penindak
                            </div>
                        </div>`}
                    </div>
                </div>
                ${(tl.pelaksana || tl.keterlibatan_ortu !== undefined) ? `
                <div class="detail-divider" style="background:var(--green-light);"></div>
                <div class="detail-section">
                    <div class="detail-section-title teal">👤 Pelaksana &amp; Orang Tua</div>
                    <div class="field-grid">
                        <div class="field-item">
                            <div class="field-label">Pelaksana</div>
                            <div class="field-value">
                                ${esc(tl.pelaksana || '-')}
                            </div>
                        </div>
                        <div class="field-item">
                            <div class="field-label">Keterlibatan Orang Tua</div>
                            <div class="field-value" style="background:transparent;border:none;padding:8px 0;">
                                <span class="ortu-badge ${(tl.keterlibatan_ortu === true || tl.keterlibatan_ortu === 1 || tl.keterlibatan_ortu === 'ya') ? 'ya' : 'tidak'}">
                                    ${(tl.keterlibatan_ortu === true || tl.keterlibatan_ortu === 1 || tl.keterlibatan_ortu === 'ya')
                                        ? '✅ Ya, terlibat'
                                        : '❌ Tidak terlibat'}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>` : ''}
                <div class="detail-divider" style="background:var(--green-light);"></div>
            <div class="detail-section">
                <div class="detail-section-title teal">📎 Bukti Dokumentasi Penindak</div>
                <div class="detail-divider" style="background:var(--green-light);"></div>
            <div class="detail-section">
                <div class="detail-section-title teal">📎 Bukti Dokumentasi Penindak</div>
                ${buktis.length > 0 ? `
                <div style="display:flex;flex-direction:column;gap:8px;margin-top:8px;">
                    ${buktis.map(b => {
                        const isImage = b.mime?.startsWith('image/');
                        const isPdf   = b.mime === 'application/pdf';
                        const ext     = b.nama?.split('.').pop()?.toUpperCase() || 'FILE';
                        const icon    = isPdf
                            ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc2626"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>`
                            : isImage
                            ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>`
                            : `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6b7280"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>`;
                        const bgColor = isPdf ? '#fef2f2' : isImage ? '#eff6ff' : '#f9fafb';
                        return `
                            <div style="
                                display:flex;align-items:center;justify-content:space-between;gap:12px;
                                padding:10px 14px;background:${bgColor};
                                border:1.5px solid ${isPdf ? '#fca5a5' : isImage ? '#bfdbfe' : '#e5e7eb'};
                                border-radius:10px;
                            ">
                                <div style="display:flex;align-items:center;gap:10px;min-width:0;">
                                    <div style="
                                        width:36px;height:36px;border-radius:8px;flex-shrink:0;
                                        background:white;display:flex;align-items:center;justify-content:center;
                                        border:1px solid ${isPdf ? '#fca5a5' : isImage ? '#bfdbfe' : '#e5e7eb'};
                                    ">
                                        ${icon}
                                    </div>
                                    <div style="min-width:0;">
                                        <div style="font-size:.82rem;font-weight:600;color:#111827;
                                            white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">
                                            ${esc(b.nama || 'File')}
                                        </div>
                                        <div style="font-size:.72rem;color:#6b7280;margin-top:1px;">${ext}</div>
                                    </div>
                                </div>
                                <a href="${esc(b.url)}" target="_blank" style="
                                    display:inline-flex;align-items:center;gap:6px;
                                    padding:6px 14px;border-radius:8px;font-size:.78rem;font-weight:600;
                                    background:#10b981;color:white;text-decoration:none;white-space:nowrap;
                                    flex-shrink:0;
                                ">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Unduh
                                </a>
                            </div>`;
                    }).join('')}
                </div>` : `
                <div style="
                    display:flex;flex-direction:column;align-items:center;gap:8px;
                    padding:20px;background:#f9fafb;border:1.5px dashed #e5e7eb;
                    border-radius:10px;text-align:center;color:#9ca3af;margin-top:8px;
                ">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" opacity=".4">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span style="font-size:.82rem;font-weight:500;">Tidak ada berkas yang dilampirkan</span>
                    <span style="font-size:.76rem;">Petugas tidak mengunggah dokumen pendukung tindak lanjut</span>
                </div>`}
            </div>
        `;
    }

    function buildFeedbackSection(d) {
        const isDitolak = d.status === 'ditolak';

        // Sudah pernah feedback → tampilkan hasil saja
        if (d.feedback) {
            const EMOJI = ['', '😡', '😞', '😐', '😊', '🌟'];
            const LABEL = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Luar Biasa'];
            const r = d.feedback.rating;
            return `
                <div class="feedback-card" id="feedbackCard">
                    <h3 class="feedback-title">${isDitolak ? '📝 Feedback Anda' : 'Penilaian Anda'}</h3>
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:${d.feedback.pesan ? '14px' : '0'}">
                        <span style="font-size:2.4rem;">${EMOJI[r] || ''}</span>
                        <div>
                            <div style="font-weight:600;font-size:1rem;color:var(--color-text-primary, #111827);">
                                ${LABEL[r] || '—'}
                            </div>
                            <div style="font-size:.78rem;color:var(--color-text-secondary, #6b7280);">
                                Rating ${r}/5
                            </div>
                        </div>
                    </div>
                    ${d.feedback.pesan ? `
                    <div style="padding:10px 14px;background:var(--gray-50,#f9fafb);
                        border:1.5px solid var(--gray-200,#e5e7eb);border-radius:10px;
                        font-size:.85rem;font-style:italic;color:var(--gray-600,#4b5563);line-height:1.6;">
                        "${esc(d.feedback.pesan)}"
                    </div>` : ''}
                </div>`;
        }

        // Belum feedback → tampilkan form, beda style untuk ditolak
        return `
            <div class="feedback-card ${isDitolak ? 'feedback-ditolak' : ''}" id="feedbackCard"
                style="${isDitolak ? 'border-color:#fca5a5;background:linear-gradient(135deg,#fff5f5 0%,#fff 100%);' : ''}">
                
                ${isDitolak ? `
                <div style="
                    display:flex;align-items:flex-start;gap:10px;
                    padding:12px 14px;background:#fee2e2;border:1.5px solid #fca5a5;
                    border-radius:10px;margin-bottom:16px;
                ">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc2626"
                        style="flex-shrink:0;margin-top:1px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <div style="font-weight:700;color:#dc2626;font-size:.85rem;margin-bottom:3px;">
                            Mohon Maaf, Laporan Anda Ditolak
                        </div>
                        <div style="font-size:.78rem;color:#991b1b;line-height:1.5;">
                            Kami mohon maaf atas ketidaknyamanan ini. Sebagai bentuk evaluasi layanan kami, 
                            kami sangat menghargai masukan Anda agar penanganan laporan ke depan bisa lebih baik.
                        </div>
                    </div>
                </div>` : ''}

                <h3 class="feedback-title" style="${isDitolak ? 'color:#dc2626;' : ''}">
                    ${isDitolak ? '📝 Bantu Kami Evaluasi' : 'Rating Penyelesaian'}
                </h3>
                <p class="feedback-sub" style="${isDitolak ? 'color:#b91c1c;' : ''}">
                    ${isDitolak 
                        ? 'Pendapat Anda sangat berarti bagi kami untuk meningkatkan kualitas penanganan laporan di masa mendatang.'
                        : 'Bagaimana kepuasan Anda terhadap penanganan laporan ini? Penilaian Anda membantu kami meningkatkan layanan.'}
                </p>
                <div id="feedbackFormSection">
                    <div class="emoji-rating-wrap">
                        ${EMOJI_OPTIONS.map(o => `
                            <button class="emoji-btn" data-val="${o.val}" onclick="setEmojiRating(${o.val})" type="button">
                                <span class="emoji">${o.emoji}</span>
                                <span class="elabel">${o.label}</span>
                            </button>
                        `).join('')}
                    </div>
                    <div class="rating-desc" id="ratingDesc">Pilih emoji untuk memberi penilaian</div>
                    <textarea class="feedback-textarea" id="feedbackText" 
                        placeholder="${isDitolak 
                            ? 'Ceritakan kendala atau saran Anda terkait proses penanganan laporan...' 
                            : 'Saran atau masukan Anda... (opsional)'}"></textarea>
                    <button class="btn-submit-feedback" onclick="submitFeedback()" type="button"
                        style="${isDitolak ? 'background:linear-gradient(135deg,#dc2626,#b91c1c);' : ''}">
                        ${isDitolak ? '📤 Kirim Feedback' : 'Kirim Penilaian'}
                    </button>
                </div>
            </div>`;
    }


    /* ══════════════════════════════════════════════
    TOGGLE PANEL (accordion detail)
    ══════════════════════════════════════════════ */
    function togglePanel(panelId, btn) {
        const panel = document.getElementById(panelId);
        if (!panel) return;

        const body   = btn.nextElementSibling;
        const isOpen = body.classList.contains('open');

        body.classList.toggle('open', !isOpen);
        btn.classList.toggle('open', !isOpen);

        if (!isOpen) {
            setTimeout(() => panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 80);
        }
    }

    /* ══════════════════════════════════════════════
    TOGGLE FORM ISI DETAIL
    ══════════════════════════════════════════════ */
    function toggleFormIsi() {
        const form = document.getElementById('formIsiDetail');
        const btn  = document.getElementById('btnIsiDetail');
        if (!form) return;
        const willOpen = !form.classList.contains('open');
        form.classList.toggle('open', willOpen);
        btn?.classList.toggle('open', willOpen);
        if (willOpen) setTimeout(() => form.scrollIntoView({ behavior: 'smooth', block: 'start' }), 80);
    }

    function bannerScrollToForm() {
        // Buka form jika belum terbuka
        const form = document.getElementById('formIsiDetail');
        const btn  = document.getElementById('btnIsiDetail');
        if (form && !form.classList.contains('open')) {
            form.classList.add('open');
            btn?.classList.add('open');
        }
        // Scroll ke form
        setTimeout(() => {
            form?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 80);
    }

    /* ══════════════════════════════════════════════
    PERSON ROWS – SELECT KELAS
    Kolom Kelas menggunakan <select> dengan opsi
    dari API /api/students/grades (_gradeOptions).
    Berlaku untuk: pelaku, korban, saksi.
    ══════════════════════════════════════════════ */
    const _counters = { pelaku: 0, korban: 0, saksi: 0 };

    function addRow(type) {
        const container = document.getElementById(`${type}Rows`);
        if (!container) return;
        const id  = ++_counters[type];
        const div = document.createElement('div');
        div.className = 'person-row';
        div.id = `${type}Row${id}`;

        const uniqueGrades = [...new Set(_allPairs.map(p => p.grade))].sort();
        const kelasOptions = uniqueGrades
            .map(g => `<option value="${esc(g)}">${esc(g)}</option>`)
            .join('');

        // Tombol "Saya Sendiri" hanya untuk korban
        const saSendiriBtn = type === 'korban' ? `
            <button class="btn-add-person" type="button"
                    onclick="fillSelfAsKorban('${type}', ${id})"
                    style="margin-bottom:10px;background:#eff6ff;color:#1d4ed8;border:1.5px solid #bfdbfe;">
                👤 Saya Sendiri
            </button>` : '';

        div.innerHTML = `
            ${saSendiriBtn}
            <div class="person-row-top" style="display:flex;gap:10px;align-items:flex-end;">
                <div class="form-group" style="margin:0;position:relative;flex:2;">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-input" id="${type}_nama_${id}"
                        placeholder="Cari nama atau isi manual..." autocomplete="off"
                        oninput="handleSearchStudent(this, '${type}', ${id})">
                    <div id="results_${type}_${id}" class="autocomplete-results hidden"></div>
                    <input type="hidden" id="${type}_student_id_${id}">
                </div>

                <div class="form-group" style="margin:0;flex:1;">
                    <label class="form-label">Kelas</label>
                    <select class="form-input" id="${type}_kelas_${id}"
                            onchange="onKelasChange('${type}', ${id})">
                        <option value="" disabled selected>Pilih</option>
                        ${[...new Set(_allPairs.map(p => p.grade))].sort()
                            .map(g => `<option value="${esc(g)}">${esc(g)}</option>`).join('')}
                    </select>
                </div>

                <div class="form-group" style="margin:0;flex:1.2;">
                    <label class="form-label">Jurusan</label>
                    <select class="form-input" id="${type}_jurusan_${id}" disabled>
                        <option value="" disabled selected>Pilih kelas dulu</option>
                    </select>
                </div>

                <button class="btn-remove-person" onclick="removeRow('${type}Row${id}')" 
                        type="button" style="margin-bottom:5px;">
                    ${icoX()}
                </button>
            </div>
            <div class="person-row-note" style="margin-top:10px;">
                <div class="form-label" style="margin-bottom:5px;">
                    Catatan <span class="optional">(opsional)</span>
                </div>
                <input type="text" class="form-input" id="${type}_catatan_${id}" 
                    placeholder="Keterangan tambahan...">
            </div>
        `;
        container.appendChild(div);
    }

    /**
     * Dipanggil saat user memilih kelas secara manual.
     * Filter jurusan berdasarkan kelas yang dipilih dari _allPairs.
     */
    function onKelasChange(type, id) {
        const grade   = document.getElementById(`${type}_kelas_${id}`)?.value;
        const juruSel = document.getElementById(`${type}_jurusan_${id}`);
        if (!juruSel) return;

        if (!grade) {
            juruSel.innerHTML = `<option value="" disabled selected>Pilih kelas dulu</option>`;
            juruSel.disabled  = true;
            return;
        }

        const matchedCodes = _allPairs
            .filter(p => p.grade === grade)
            .map(p => p.major);

        juruSel.innerHTML = `<option value="" disabled selected>Pilih Jurusan</option>` +
            matchedCodes.map(code => {
                const name = getMajorName(code);
                return `<option value="${esc(code)}">${esc(name)}</option>`;
            }).join('');
        juruSel.disabled = false;

        if (matchedCodes.length === 1) juruSel.value = matchedCodes[0];
    }
    /**
     * Kunci field kelas & jurusan (setelah autocomplete dipilih).
     */
    function lockPersonRow(type, id, grade, majorCode) {
        const kelasSel = document.getElementById(`${type}_kelas_${id}`);
        const juruSel  = document.getElementById(`${type}_jurusan_${id}`);

        if (kelasSel) {
            // Tambah opsi kalau belum ada
            if (!Array.from(kelasSel.options).find(o => o.value === grade)) {
                kelasSel.add(new Option(grade, grade));
            }
            kelasSel.value    = grade;
            kelasSel.disabled = true;
        }

        if (juruSel) {
            const majorName = getMajorName(majorCode) || majorCode;
            juruSel.innerHTML = `<option value="${esc(majorCode)}" selected>${esc(majorName)}</option>`;
            juruSel.value     = majorCode;
            juruSel.disabled  = true;
        }
    }

    function unlockPersonRow(type, id) {
        const kelasSel = document.getElementById(`${type}_kelas_${id}`);
        const juruSel  = document.getElementById(`${type}_jurusan_${id}`);

        if (kelasSel) {
            const uniqueGrades = [...new Set(_allPairs.map(p => p.grade))].sort();
            kelasSel.innerHTML = `<option value="" disabled selected>Pilih</option>` +
                uniqueGrades.map(g => `<option value="${esc(g)}">${esc(g)}</option>`).join('');
            kelasSel.disabled = false;
            kelasSel.value    = '';
        }

        if (juruSel) {
            juruSel.innerHTML = `<option value="" disabled selected>Pilih kelas dulu</option>`;
            juruSel.disabled  = true;
        }

        const hiddenId = document.getElementById(`${type}_student_id_${id}`);
        if (hiddenId) hiddenId.value = '';
    }



    /**
     * Khusus korban: isi dengan data pelapor sendiri, semua field disabled.
     */
    function fillSelfAsKorban(type, id) {
        if (!_reportData) return;

        const namaEl = document.getElementById(`${type}_nama_${id}`);
        if (namaEl) { namaEl.value = _reportData.student_name || ''; namaEl.disabled = true; }

        const hiddenId = document.getElementById(`${type}_student_id_${id}`);
        if (hiddenId) hiddenId.value = _reportData.student_id || '';

        const studentGrade = _reportData.student_grade || '';
        const parts        = studentGrade.split(' ');
        const grade        = parts[0] || '';
        const majorCode    = parts.slice(1).join(' ');

        lockPersonRow(type, id, grade, majorCode);
    }

    async function fetchPairs() {
        try {
            const res  = await fetch('/api/data-siswa/grade-majors');
            const json = await res.json();
            if (Array.isArray(json)) {
                _allPairs = json;
                console.log('_allPairs loaded:', _allPairs);
            }
        } catch (e) {
            console.error('Gagal memuat grade-major pairs', e);
        }
    }

    async function fetchMajors() {
        try {
            const res  = await fetch('/api/data-siswa/majors/full');
            const json = await res.json();
            if (Array.isArray(json)) {
                _majorsFull   = json;
                _majorOptions = json.map(m => m.code);
            }
        } catch (e) {
            console.error("Gagal memuat jurusan", e);
        }
    }

    function getMajorName(code) {
        const found = _majorsFull.find(m => m.code === code);
        return found ? found.name : code;
    }

    function getMajorCode(name) {
        const found = _majorsFull.find(m => m.name === name);
        return found ? found.code : name;
    }

    /* ══════════════════════════════════════════════
    AUTOCOMPLETE SISWA
    ══════════════════════════════════════════════ */
    async function handleSearchStudent(input, type, id) {
        clearTimeout(_searchTimeout);
        const q = input.value.trim();
        const resultBox = document.getElementById(`results_${type}_${id}`);
        
        if (q.length === 0) {
            unlockPersonRow(type, id);
        }

        if (q.length < 2) {
            resultBox.classList.add('hidden');
            return;
        }

        _searchTimeout = setTimeout(async () => {
            try {
                const res  = await fetch(`/api/students/autocomplete?q=${encodeURIComponent(q)}`);
                const json = await res.json();

                if (json.success && json.data.length > 0) {
                    resultBox.innerHTML = json.data.map(s => {
                        // Simpan data dalam string aman untuk attribute
                        const dataStr = JSON.stringify(s).replace(/'/g, "&apos;");
                        return `
                            <div class="result-item" onclick='selectStudent("${type}", ${id}, ${dataStr})'>
                                <strong>${esc(s.fullname)}</strong><br>
                                <small>${esc(s.nis)} - ${esc(s.grade)} ${esc(s.major || '')}</small>
                            </div>
                        `;
                    }).join('');
                    resultBox.classList.remove('hidden');
                } else {
                    resultBox.classList.add('hidden');
                }
            } catch (e) { console.error(e); }
        }, 400); // Tunggu 400ms setelah berhenti mengetik
    }

    function selectStudent(type, rowId, data) {
        const namaEl = document.getElementById(`${type}_nama_${rowId}`);
        if (namaEl) { namaEl.value = data.fullname; namaEl.disabled = true; }

        const hiddenId = document.getElementById(`${type}_student_id_${rowId}`);
        if (hiddenId) hiddenId.value = data.id;

        lockPersonRow(type, rowId, data.grade, data.major);

        document.getElementById(`results_${type}_${rowId}`)?.classList.add('hidden');
    }

    // Tutup dropdown autocomplete jika klik di luar
    document.addEventListener('click', (e) => {
        if (!e.target.classList.contains('form-input')) {
            document.querySelectorAll('.autocomplete-results').forEach(el => el.classList.add('hidden'));
        }
    });

    function removeRow(rowId) {
        document.getElementById(rowId)?.remove();
    }

    function collectRows(type) {
        const rows = document.querySelectorAll(`#${type}Rows .person-row`);
        const res  = [];
        rows.forEach(row => {
            const id        = row.id.replace(`${type}Row`, '');
            const nama      = document.getElementById(`${type}_nama_${id}`)?.value?.trim();
            const studentId = document.getElementById(`${type}_student_id_${id}`)?.value || null;
            const kelas     = document.getElementById(`${type}_kelas_${id}`)?.value?.trim();
            const jurusan   = document.getElementById(`${type}_jurusan_${id}`)?.value?.trim();
            const catatan   = document.getElementById(`${type}_catatan_${id}`)?.value?.trim();

            if (nama) {
                res.push({
                    nama,
                    student_id : studentId ? parseInt(studentId) : null,
                    kelas      : kelas    || null,
                    jurusan    : jurusan  || null,
                    catatan    : catatan  || null,
                });
            }
        });
        return res;
    }

    /* ══════════════════════════════════════════════
    CHECKLIST
    ══════════════════════════════════════════════ */
    function toggleCheck(el) {
        const cb = el.querySelector('input[type="checkbox"]');
        if (cb) { cb.checked = !cb.checked; el.classList.toggle('checked', cb.checked); }
    }

    function validateNoDuplicates(pelaku, korban, saksi) {
        const checkGroup = (arr, label) => {
            const names = arr.map(p => p.nama.toLowerCase().trim());
            const dupe  = names.find((n, i) => names.indexOf(n) !== i);
            if (dupe) return `Nama "${dupe}" muncul lebih dari sekali di daftar ${label}.`;
            return null;
        };

        let err = checkGroup(pelaku, 'Pelaku');
        if (err) return err;
        err = checkGroup(korban, 'Korban');
        if (err) return err;
        err = checkGroup(saksi, 'Saksi');
        if (err) return err;

        const all  = [
            ...pelaku.map(p => ({ nama: p.nama.toLowerCase().trim(), role: 'Pelaku' })),
            ...korban.map(p => ({ nama: p.nama.toLowerCase().trim(), role: 'Korban' })),
            ...saksi.map(p  => ({ nama: p.nama.toLowerCase().trim(), role: 'Saksi'  })),
        ];
        const seen = {};
        for (const entry of all) {
            if (seen[entry.nama]) {
                return `"${entry.nama}" tidak boleh ada di ${seen[entry.nama]} sekaligus ${entry.role}.`;
            }
            seen[entry.nama] = entry.role;
        }
        return null;
    }

    /* ══════════════════════════════════════════════
    SIMPAN DETAIL (Tahap Verifikasi)
    ══════════════════════════════════════════════ */
    async function simpanDetail() {
        const tgl    = document.getElementById('inp_tgl')?.value;
        const jam    = document.getElementById('inp_jam')?.value;
        const lokasi = document.getElementById('inp_lokasi')?.value?.trim();

        // ── Validasi Waktu & Lokasi ──
        if (!tgl)    { showUserToast('Tanggal kejadian wajib diisi.', 'error', 'Validasi'); return; }
        if (!lokasi) { showUserToast('Tempat kejadian wajib diisi.', 'error', 'Validasi'); return; }

        const pelaku = collectRows('pelaku');
        const korban = collectRows('korban');
        const saksi  = collectRows('saksi');

        // ── Validasi Minimal 1 Pelaku & Korban ──
        if (pelaku.length === 0) { showUserToast('Minimal 1 pelaku harus diisi.', 'error', 'Validasi'); return; }
        if (korban.length === 0) { showUserToast('Minimal 1 korban harus diisi.', 'error', 'Validasi'); return; }

        // ── Validasi Kelas & Jurusan per Row ──
        const validatePersonFields = (list, label) => {
            for (let i = 0; i < list.length; i++) {
                const p   = list[i];
                const num = i + 1;

                // Kalau sudah autocomplete (student_id ada), skip validasi kelas/jurusan
                if (p.student_id) continue;

                if (!p.kelas || p.kelas.trim() === '') {
                    showUserToast(`${label} ke-${num}: Kelas wajib diisi.`, 'error', 'Validasi');
                    return false;
                }
                if (!p.jurusan || p.jurusan.trim() === '') {
                    showUserToast(`${label} ke-${num}: Jurusan wajib diisi.`, 'error', 'Validasi');
                    return false;
                }
            }
            return true;
        };

        if (!validatePersonFields(pelaku, 'Pelaku')) return;
        if (!validatePersonFields(korban, 'Korban')) return;
        if (!validatePersonFields(saksi,  'Saksi'))  return;

        // ── Validasi Duplikat ──
        const dupErr = validateNoDuplicates(pelaku, korban, saksi);
        if (dupErr) { showUserToast(dupErr, 'error', 'Data Duplikat'); return; }

        // ── Validasi Checklist ──
        const chk1 = document.getElementById('chk1')?.checked;
        const chk2 = document.getElementById('chk2')?.checked;
        const chk3 = document.getElementById('chk3')?.checked;
        if (!chk1) { showUserToast('Harap centang konfirmasi kebenaran data.', 'warning', 'Konfirmasi'); return; }
        if (!chk2) { showUserToast('Harap centang kesediaan dipanggil untuk keterangan.', 'warning', 'Konfirmasi'); return; }
        if (!chk3) { showUserToast('Harap centang pernyataan kerahasiaan laporan.', 'warning', 'Konfirmasi'); return; }

        // ── Kirim ke API ──
        const btn = document.getElementById('btnSimpan');
        if (btn) { 
            btn.disabled = true; 
            btn.innerHTML = '<div class="loading-spinner" style="width:18px;height:18px;border-width:3px;"></div> Menyimpan...'; 
        }
        showLoadingOverlay(true);

        try {
            const res  = await fetch('/api/reports/detail', {
                method:  'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json', 
                    'X-CSRF-TOKEN': csrfToken() 
                },
                body: JSON.stringify({ 
                    code: _currentCode, 
                    tanggal: tgl, 
                    jam, 
                    lokasi, 
                    pelaku, 
                    korban, 
                    saksi 
                }),
            });
            const data = await res.json();
            showLoadingOverlay(false);

            if (res.ok && data.success) {
                showUserToast('Detail berhasil disimpan! Status laporan diperbarui.', 'success', 'Berhasil');
                // Delay sedikit lebih lama agar DB commit selesai sebelum fetch ulang
                setTimeout(() => loadReport(_currentCode), 2200);
            } else {
                showUserToast(data.message || 'Gagal menyimpan detail.', 'error', 'Gagal');
                if (btn) { btn.disabled = false; btn.innerHTML = icoCheck() + ' Simpan &amp; Kirim Detail'; }
            }
        } catch (e) {
            console.error(e);
            showLoadingOverlay(false);
            showUserToast('Koneksi bermasalah. Coba lagi.', 'error', 'Error');
            if (btn) { btn.disabled = false; btn.innerHTML = icoCheck() + ' Simpan &amp; Kirim Detail'; }
        }
    }

    /* ══════════════════════════════════════════════
    REMINDER — BATAS 2x PER HARI
    ══════════════════════════════════════════════ */

    function getReminderUsed() {
        const key   = REMINDER_KEY + _currentCode;
        const today = new Date().toDateString();
        try {
            const raw  = localStorage.getItem(key);
            const data = raw ? JSON.parse(raw) : null;
            if (data && data.date === today) return data.count;
        } catch {}
        return 0;
    }

    function setReminderUsed(count) {
        const key   = REMINDER_KEY + _currentCode;
        const today = new Date().toDateString();
        try { localStorage.setItem(key, JSON.stringify({ date: today, count })); } catch {}
    }

    function renderReminderBtn(d) {
        const wrap  = document.getElementById('reminderBtnWrap');
        const btn   = document.getElementById('btnReminder');
        const badge = document.getElementById('reminderCounter');
        if (!btn) return;

        const isTerminal = ['selesai','ditolak'].includes(d.status);
        if (isTerminal) { wrap?.classList.add('hidden'); return; }
        wrap?.classList.remove('hidden');

        const used = getReminderUsed();
        const sisa = REMINDER_MAX - used;

        if (badge) {
            badge.textContent = sisa;
            badge.className   = 'reminder-counter ' + (sisa >= 2 ? 'ok' : sisa === 1 ? 'warn' : 'out');
        }

        if (sisa <= 0) {
            btn.disabled = true;
            btn.title    = 'Batas pengiriman reminder (2x) telah tercapai hari ini.';
        } else {
            btn.disabled = false;
            btn.title    = `Kirim reminder (sisa ${sisa}x hari ini)`;
        }
    }

    function renderGlobalActionBanner(d) {
        const banner = document.getElementById('globalActionBanner');
        if (!banner) return;

        const isVerifikasi = ['menunggu', 'verifikasi'].includes(d.status);
        const isFinal      = ['selesai', 'ditolak'].includes(d.status);
        const sudahFeedback = !!d.feedback;

        if (isVerifikasi) {
            // Banner lama: isi detail laporan
            banner.classList.remove('hidden');
            banner.onclick = bannerScrollToForm;
            const gabTitle = banner.querySelector('.gab-title');
            const gabDesc  = banner.querySelector('.gab-desc');
            const gabIcon  = banner.querySelector('.gab-icon');
            if (gabTitle) gabTitle.textContent = 'Tindakan Diperlukan';
            if (gabDesc)  gabDesc.textContent  = 'Lengkapi detail kejadian agar laporan segera ditindaklanjuti';
            if (gabIcon)  gabIcon.textContent  = '📋';
            banner.style.background = '';
            return;
        }

       if (isFinal && !sudahFeedback) {
            banner.classList.remove('hidden');
            banner.onclick = () => {
                const el = document.getElementById('feedbackFormSection');
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            };
            const gabTitle = banner.querySelector('.gab-title');
            const gabDesc  = banner.querySelector('.gab-desc');
            const gabIcon  = banner.querySelector('.gab-icon');

            if (d.status === 'ditolak') {
                if (gabTitle) gabTitle.textContent = 'Bantu Kami Evaluasi';
                if (gabDesc)  gabDesc.textContent  = 'Mohon maaf laporan Anda ditolak — feedback Anda sangat berarti untuk perbaikan kami';
                if (gabIcon)  gabIcon.textContent  = '📝';
                banner.style.background = 'linear-gradient(135deg, #dc2626 0%, #991b1b 100%)';
            } else {
                if (gabTitle) gabTitle.textContent = 'Berikan Penilaian Anda';
                if (gabDesc)  gabDesc.textContent  = 'Bantu kami meningkatkan layanan dengan mengisi feedback laporan Anda';
                if (gabIcon)  gabIcon.textContent  = '⭐';
                banner.style.background = 'linear-gradient(135deg, #059669 0%, #047857 100%)';
            }
            return;
        }
    }

    function openReminderModal() {
        const used = getReminderUsed();
        const sisa = REMINDER_MAX - used;

        if (sisa <= 0) {
            showModal({
                iconClass: 'red',
                iconSvg:   `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>`,
                title:     'Batas Tercapai',
                desc:      'Anda telah mengirim reminder sebanyak 2 kali hari ini. Silakan coba kembali besok.',
                btnLabel:  'Mengerti',
                onConfirm: closeModal,
            });
            return;
        }

        showModal({
            iconClass: 'amber',
            iconSvg:   `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>`,
            title:     'Kirim Reminder?',
            desc:      `Notifikasi akan dikirim ke petugas. Anda masih punya <strong>${sisa}</strong> kali pengiriman reminder hari ini (maks. 2x/hari).`,
            btnLabel:  'Ya, Kirim Sekarang',
            onConfirm: doSendReminder,
        });
    }

    async function doSendReminder() {
        const used = getReminderUsed();
        if (used >= REMINDER_MAX) {
            closeModal();
            showUserToast('Batas pengiriman reminder adalah 2 kali dalam sehari.', 'error', 'Batas Tercapai');
            return;
        }

        const btn = document.getElementById('modalConfirmBtn');
        if (btn) { btn.disabled = true; btn.textContent = 'Mengirim...'; }

        try {
            const res  = await fetch('/api/reports/reminder', {
                method:  'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken() },
                body:    JSON.stringify({ code: _currentCode }),
            });
            const data = await res.json();
            closeModal();

            if (res.ok && data.success) {
                const newUsed = used + 1;
                setReminderUsed(newUsed);
                const sisa = REMINDER_MAX - newUsed;

                showUserToast(
                    sisa > 0
                        ? `Reminder berhasil dikirim ke petugas. Sisa ${sisa}x pengiriman hari ini.`
                        : `Reminder berhasil dikirim. Anda telah mencapai batas pengiriman hari ini.`,
                    'success',
                    'Reminder Terkirim'
                );
                renderReminderBtn(_reportData);
            } else {
                showUserToast(data.message || 'Gagal mengirim reminder.', 'error', 'Gagal');
            }
        } catch (e) {
            console.error(e);
            closeModal();
            showUserToast('Koneksi bermasalah. Coba lagi.', 'error', 'Error Koneksi');
        } finally {
            if (btn) { btn.disabled = false; btn.textContent = 'Ya, Kirim Sekarang'; }
        }
    }

    /* ══════════════════════════════════════════════
    MODAL HELPER (fleksibel)
    ══════════════════════════════════════════════ */
    let _modalConfirm = null;

    function showModal({ iconClass, iconSvg, title, desc, btnLabel, onConfirm }) {
        _modalConfirm = onConfirm;
        const box = document.getElementById('modalBox');
        if (!box) return;
        box.querySelector('.modal-icon').className    = `modal-icon ${iconClass}`;
        box.querySelector('.modal-icon').innerHTML    = iconSvg;
        box.querySelector('.modal-title').textContent = title;
        box.querySelector('.modal-desc').innerHTML    = desc;
        const confirmBtn = box.querySelector('#modalConfirmBtn');
        confirmBtn.textContent = btnLabel;
        document.getElementById('reminderModal')?.classList.remove('hidden');
    }

    function confirmModal() { _modalConfirm?.(); }

    function closeModal(e) {
        if (!e || e.target === e.currentTarget) {
            document.getElementById('reminderModal')?.classList.add('hidden');
        }
    }

    /* ══════════════════════════════════════════════
    FEEDBACK EMOJI
    ══════════════════════════════════════════════ */
    function setEmojiRating(val) {
        _emojiRating = val;
        document.querySelectorAll('.emoji-btn').forEach(b => b.classList.toggle('active', +b.dataset.val === val));
        const found = EMOJI_OPTIONS.find(o => o.val === val);
        setText('ratingDesc', found ? `${found.emoji} ${found.label}` : '');
    }

    async function submitFeedback() {
        if (_emojiRating === 0) { 
            showUserToast('Pilih emoji penilaian terlebih dahulu.', 'warning', 'Penilaian'); 
            return; 
        }

        const pesan = document.getElementById('feedbackText')?.value?.trim();
        const btn   = document.querySelector('.btn-submit-feedback');
        if (btn) { btn.disabled = true; btn.textContent = 'Mengirim...'; }

        try {
            const res  = await fetch('/api/reports/feedback', {
                method:  'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json', 
                    'X-CSRF-TOKEN': csrfToken() 
                },
                body: JSON.stringify({ 
                    code:   _currentCode, 
                    rating: _emojiRating, 
                    pesan:  pesan || null 
                }),
            });
            const data = await res.json();

            if (res.ok && data.success) {
                showUserToast('Terima kasih! Penilaian Anda telah dikirim.', 'success', 'Berhasil');

                // Simpan feedback ke _reportData supaya tidak bisa submit lagi
                if (_reportData) {
                    _reportData.feedback = { rating: _emojiRating, pesan: pesan || null };
                }

                // Sembunyikan banner feedback
                const banner = document.getElementById('globalActionBanner');
                if (banner) banner.classList.add('hidden');

                // Ganti form dengan tampilan hasil (tanpa reload halaman)
                const card = document.getElementById('feedbackCard');
                if (card) {
                    const EMOJI = ['', '😡', '😞', '😐', '😊', '🌟'];
                    const LABEL = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Luar Biasa'];
                    card.innerHTML = `
                        <h3 class="feedback-title">Penilaian Anda</h3>
                        <div style="display:flex;align-items:center;gap:14px;margin-bottom:${pesan ? '14px' : '0'}">
                            <span style="font-size:2.4rem;">${EMOJI[_emojiRating]}</span>
                            <div>
                                <div style="font-weight:600;font-size:1rem;">${LABEL[_emojiRating]}</div>
                                <div style="font-size:.78rem;color:#6b7280;">Rating ${_emojiRating}/5 — Terima kasih!</div>
                            </div>
                        </div>
                        ${pesan ? `<div style="padding:10px 14px;background:#f9fafb;
                            border:1.5px solid #e5e7eb;border-radius:10px;
                            font-size:.85rem;font-style:italic;color:#4b5563;line-height:1.6;">
                            "${esc(pesan)}"</div>` : ''}
                    `;
                }
            } else {
                showUserToast(data.message || 'Gagal mengirim penilaian.', 'error', 'Gagal');
                if (btn) { btn.disabled = false; btn.textContent = 'Kirim Penilaian'; }
            }
        } catch (e) {
            console.error(e);
            showUserToast('Koneksi bermasalah. Coba lagi.', 'error', 'Error');
            if (btn) { btn.disabled = false; btn.textContent = 'Kirim Penilaian'; }
        }
    }

    /* ══════════════════════════════════════════════
    PHOTO VIEWER
    ══════════════════════════════════════════════ */
    function openPhoto(url) {
        const overlay = document.createElement('div');
        overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,.88);z-index:800;display:flex;align-items:center;justify-content:center;padding:20px;cursor:zoom-out;animation:fadeIn .2s ease;';
        overlay.innerHTML = `<img src="${esc(url)}" style="max-width:100%;max-height:90vh;border-radius:12px;box-shadow:0 24px 60px rgba(0,0,0,.5);">`;
        overlay.onclick = () => overlay.remove();
        document.body.appendChild(overlay);
    }

    /* ══════════════════════════════════════════════
    TOAST (pojok kanan atas)
    ══════════════════════════════════════════════ */
    function showUserToast(msg, type = 'success', title = null) {
        const tc = document.getElementById('toastContainer');
        if (!tc) return;
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <div class="toast-body">
                <div class="toast-title">${title || 'Notifikasi'}</div>
                <div class="toast-msg">${esc(msg)}</div>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">✕</button>
        `;
        tc.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('leaving');
            setTimeout(() => toast.remove(), 400);
        }, 4000);
    }

    /* ══════════════════════════════════════════════
    LOADING OVERLAY
    ══════════════════════════════════════════════ */
    function showLoadingOverlay(on) {
        let el = document.getElementById('loadingOverlay');
        if (on) {
            if (!el) {
                el = document.createElement('div');
                el.id = 'loadingOverlay';
                el.className = 'loading-overlay';
                el.innerHTML = '<div class="loading-spinner"></div><div class="loading-text">Menyimpan data...</div>';
                document.body.appendChild(el);
            }
        } else {
            el?.remove();
        }
    }

    /* ══════════════════════════════════════════════
    SKELETON / ERROR
    ══════════════════════════════════════════════ */
    function showSkeleton(on) {
        document.getElementById('skeletonWrap')?.classList.toggle('hidden', !on);
        document.getElementById('contentWrap')?.classList.toggle('hidden',  on);
    }

    function showError(msg) {
        showSkeleton(false);
        const wrap = document.getElementById('contentWrap');
        if (wrap) {
            wrap.classList.remove('hidden');
            wrap.innerHTML = `
                <div class="error-wrap">
                    <div class="error-icon">⚠️</div>
                    <h2 class="error-title">Laporan Tidak Ditemukan</h2>
                    <p class="error-desc">${esc(msg)}</p>
                    <a href="/lacak" class="btn-back-lacak">← Kembali ke Halaman Lacak</a>
                </div>`;
        }
    }

    /* ══════════════════════════════════════════════
    MINI SVG ICONS
    ══════════════════════════════════════════════ */
    function icoCheck()  { return `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>`; }
    function icoX()      { return `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>`; }
    function icoDoc()    { return `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>`; }
    function icoEdit()   { return `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>`; }
    function icoChevron(){ return `<svg class="btn-toggle-detail-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>`; }

    /* ══════════════════════════════════════════════
    HELPERS
    ══════════════════════════════════════════════ */
    function setText(id, val) {
        const el = document.getElementById(id);
        if (el) el.textContent = val ?? '-';
    }

    function esc(str) {
        if (!str) return '';
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function csrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    }

    function updateAllJurusanSelects() {
        document.querySelectorAll('select.jurusan-select').forEach(sel => {
            const current = sel.value;
            const options = _majorOptions.map(m => `<option value="${esc(m)}">${esc(m)}</option>`).join('');
            sel.innerHTML = `<option value="" disabled selected>Pilih Jurusan</option>${options}`;
            if (current) sel.value = current;
        });
    }