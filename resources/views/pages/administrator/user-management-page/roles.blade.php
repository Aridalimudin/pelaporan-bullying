@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">

@include('components.sidebar-admin', ['activePage' => 'daftar-roles'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Manajemen Role',
        'breadcrumbs' => [['label' => 'Administrasi'], ['label' => 'Role']],
    ])

    <main class="admin-main">

        <div class="content-heading animate-fade-in">
            <div>
                <h2 class="content-title">Daftar Role</h2>
                <p class="content-sub">Kelola role pengguna dan atur hak akses yang dimiliki setiap role.</p>
            </div>
            <div class="heading-actions">
                <div class="search-wrap">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari nama role...">
                </div>
                <button class="btn-tambah" onclick="openRoleModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Role
                </button>
            </div>
        </div>

        {{-- Role Cards Grid --}}
        <div class="role-grid animate-fade-in" id="roleGrid" style="animation-delay:.05s"></div>

        <div class="no-results hidden" id="noResults" style="margin-top:40px">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p>Tidak ada role ditemukan</p>
        </div>

    </main>
    @include('components.toast')
</div>

{{-- Modal Role --}}
<div class="um-overlay" id="modalRole" style="display:none">
    <div class="um-panel" style="max-width:500px">
        <div class="um-header" id="roleHeader">
            <div class="um-header-left">
                <div class="um-header-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <p class="um-sublabel">Manajemen Role</p>
                    <h3 class="um-title" id="roleTitleModal">Tambah Role Baru</h3>
                </div>
            </div>
            <button class="um-close" onclick="closeRoleModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="um-body">
            <div class="um-grid2">
                <div class="um-field">
                    <label class="um-label">Nama Role <span class="um-req">*</span></label>
                    <input class="um-input" type="text" id="roleNama" placeholder="Contoh: Guru BK">
                </div>
                <div class="um-field">
                    <label class="um-label">Slug <span class="um-req">*</span></label>
                    <input class="um-input" type="text" id="roleSlug" placeholder="Contoh: guru-bk">
                </div>
            </div>
            <div class="um-field">
                <label class="um-label">Deskripsi</label>
                <textarea class="um-input" id="roleDeskripsi" rows="2" placeholder="Deskripsi singkat tentang role ini..." style="resize:vertical"></textarea>
            </div>
            <div class="um-field">
                <label class="um-label">Warna Role</label>
                <div class="color-picker-row" id="colorPickerRow">
                    <div class="color-opt selected" data-bg="#f0fdf4" data-c="#16a34a" style="background:#16a34a" onclick="selectColor(this)"></div>
                    <div class="color-opt" data-bg="#fdf4ff" data-c="#9333ea" style="background:#9333ea" onclick="selectColor(this)"></div>
                    <div class="color-opt" data-bg="#eff6ff" data-c="#3b82f6" style="background:#3b82f6" onclick="selectColor(this)"></div>
                    <div class="color-opt" data-bg="#fff7ed" data-c="#ea580c" style="background:#ea580c" onclick="selectColor(this)"></div>
                    <div class="color-opt" data-bg="#fef9c3" data-c="#ca8a04" style="background:#ca8a04" onclick="selectColor(this)"></div>
                    <div class="color-opt" data-bg="#fce7f3" data-c="#db2777" style="background:#db2777" onclick="selectColor(this)"></div>
                    <div class="color-opt" data-bg="#f1f5f9" data-c="#475569" style="background:#475569" onclick="selectColor(this)"></div>
                    <div class="color-opt" data-bg="#ecfdf5" data-c="#059669" style="background:#059669" onclick="selectColor(this)"></div>
                </div>
            </div>
            <div class="um-field">
                <label class="um-label">Permissions yang Diberikan</label>
                <div class="perm-check-grid" id="permCheckGrid"></div>
            </div>
        </div>
        <div class="um-footer">
            <button class="um-btn-cancel" onclick="closeRoleModal()">Batal</button>
            <button class="um-btn-save" onclick="saveRole()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Simpan Role
            </button>
        </div>
    </div>
</div>

{{-- Modal Hapus Role --}}
<div class="um-overlay" id="modalHapusRole" style="display:none">
    <div class="um-panel" style="max-width:380px">
        <div class="um-header" style="background:linear-gradient(135deg,#ef4444,#b91c1c)">
            <div class="um-header-left">
                <div class="um-header-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div><p class="um-sublabel">Konfirmasi</p><h3 class="um-title">Hapus Role?</h3></div>
            </div>
            <button class="um-close" onclick="document.getElementById('modalHapusRole').style.display='none';document.body.style.overflow=''">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="um-body">
            <p style="font-size:13.5px;color:#374151;line-height:1.7">Role <strong id="hapusRoleNama">—</strong> akan dihapus. User yang memiliki role ini harus dipindahkan ke role lain terlebih dahulu.</p>
        </div>
        <div class="um-footer">
            <button class="um-btn-cancel" onclick="document.getElementById('modalHapusRole').style.display='none';document.body.style.overflow=''">Batal</button>
            <button class="um-btn-hapus" onclick="doHapusRole()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

@include('components.toast')

<style>
html,body{height:100%;overflow:auto;}
.admin-wrapper{min-height:100vh;overflow-y:auto;}
.admin-main{overflow:visible;padding-bottom:40px;}

.btn-tambah{display:flex;align-items:center;gap:7px;padding:9px 16px;background:#16a34a;color:white;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;transition:background .15s;flex-shrink:0;}
.btn-tambah svg{width:15px;height:15px;}
.btn-tambah:hover{background:#15803d;}

/* Role Grid */
.role-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;margin-bottom:20px;}

/* Role Card */
.role-card{background:white;border:1.5px solid #f3f4f6;border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.04);transition:box-shadow .2s,transform .2s;animation:fadeInUp .3s ease both;}
.role-card:hover{box-shadow:0 8px 24px rgba(0,0,0,.08);transform:translateY(-2px);}
@keyframes fadeInUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}

.role-card-header{padding:16px 18px 14px;display:flex;align-items:flex-start;justify-content:space-between;border-bottom:1px solid #f9fafb;}
.role-card-icon-wrap{display:flex;align-items:center;gap:12px;}
.role-card-icon{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.role-card-icon svg{width:20px;height:20px;}
.role-card-name{font-size:14px;font-weight:700;color:#111827;margin-bottom:2px;}
.role-card-slug{font-size:11px;color:#9ca3af;font-family:monospace;}
.role-card-actions{display:flex;gap:6px;flex-shrink:0;}

.role-card-body{padding:14px 18px;}
.role-card-desc{font-size:12.5px;color:#6b7280;line-height:1.6;margin-bottom:12px;}
.role-card-perms{display:flex;flex-wrap:wrap;gap:5px;margin-bottom:12px;}
.perm-tag{font-size:10.5px;font-weight:600;padding:3px 8px;border-radius:6px;background:#f3f4f6;color:#374151;}
.perm-more{font-size:10.5px;color:#9ca3af;padding:3px 6px;}

.role-card-footer{display:flex;align-items:center;justify-content:space-between;padding-top:10px;border-top:1px solid #f9fafb;margin-top:4px;}
.role-user-count{display:flex;align-items:center;gap:6px;font-size:12px;color:#6b7280;}
.role-user-count svg{width:14px;height:14px;}
.role-is-system{font-size:10px;font-weight:700;padding:2px 8px;border-radius:6px;background:#fef9c3;color:#92400e;letter-spacing:.04em;}

.btn-aksi.edit{background:#eff6ff;color:#3b82f6;border:1.5px solid #bfdbfe;}
.btn-aksi.edit:hover{background:#dbeafe;}
.btn-aksi.delete{background:#fef2f2;color:#ef4444;border:1.5px solid #fecaca;}
.btn-aksi.delete:hover{background:#fee2e2;}

/* Color picker */
.color-picker-row{display:flex;gap:8px;flex-wrap:wrap;}
.color-opt{width:28px;height:28px;border-radius:8px;cursor:pointer;border:2px solid transparent;transition:all .15s;position:relative;}
.color-opt.selected::after{content:'✓';position:absolute;inset:0;display:flex;align-items:center;justify-content:center;color:white;font-size:13px;font-weight:700;}
.color-opt:hover{transform:scale(1.15);}

/* Perm checkbox grid */
.perm-check-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:6px;max-height:160px;overflow-y:auto;padding:4px;}
.perm-check-item{display:flex;align-items:center;gap:8px;padding:7px 10px;border:1.5px solid #e5e7eb;border-radius:8px;cursor:pointer;transition:all .15s;}
.perm-check-item:hover{border-color:#86efac;background:#f0fdf4;}
.perm-check-item.checked{border-color:#16a34a;background:#f0fdf4;}
.perm-check-item input{width:15px;height:15px;accent-color:#16a34a;cursor:pointer;flex-shrink:0;}
.perm-check-label{font-size:12px;font-weight:500;color:#374151;}

/* Modal shared */
.um-overlay{position:fixed;left:var(--sidebar-width,260px);top:0;right:0;bottom:0;z-index:700;background:rgba(15,23,42,.5);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;padding:20px;}
@media(max-width:768px){.um-overlay{left:0;}}
.um-panel{background:white;border-radius:20px;width:100%;max-width:520px;box-shadow:0 32px 80px rgba(0,0,0,.22);overflow:hidden;animation:umIn .3s cubic-bezier(.16,1,.3,1) both;max-height:90vh;display:flex;flex-direction:column;}
@keyframes umIn{from{opacity:0;transform:translateY(20px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
.um-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;background:linear-gradient(135deg,#7c3aed,#5b21b6);flex-shrink:0;}
.um-header-left{display:flex;align-items:center;gap:12px;}
.um-header-icon{width:42px;height:42px;border-radius:12px;background:rgba(255,255,255,.2);border:1.5px solid rgba(255,255,255,.28);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.um-header-icon svg{width:20px;height:20px;color:white;}
.um-sublabel{font-size:.6rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.72);margin-bottom:3px;}
.um-title{font-size:1.05rem;font-weight:800;color:white;}
.um-close{width:32px;height:32px;border-radius:9px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.22);cursor:pointer;display:flex;align-items:center;justify-content:center;color:white;transition:background .15s;}
.um-close:hover{background:rgba(255,255,255,.28);}
.um-close svg{width:15px;height:15px;}
.um-body{padding:18px 20px;overflow-y:auto;display:flex;flex-direction:column;gap:14px;}
.um-grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
@media(max-width:480px){.um-grid2{grid-template-columns:1fr;}}
.um-field{display:flex;flex-direction:column;gap:5px;}
.um-label{font-size:11.5px;font-weight:700;color:#374151;letter-spacing:.02em;}
.um-req{color:#ef4444;}
.um-input,.um-select{padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:9px;font-family:inherit;font-size:13px;color:#111827;background:white;outline:none;transition:border-color .2s,box-shadow .2s;width:100%;box-sizing:border-box;}
.um-input:focus,.um-select:focus{border-color:#7c3aed;box-shadow:0 0 0 3px rgba(124,58,237,.1);}
.um-footer{display:flex;gap:8px;padding:14px 20px;border-top:1px solid #f3f4f6;background:#fafafa;flex-shrink:0;}
.um-btn-cancel{padding:10px 20px;border-radius:10px;border:1.5px solid #d1d5db;background:white;color:#374151;font-family:inherit;font-size:13px;font-weight:600;cursor:pointer;transition:background .15s;}
.um-btn-cancel:hover{background:#f9fafb;}
.um-btn-save{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:10px;border:none;background:#7c3aed;color:white;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.um-btn-save svg{width:15px;height:15px;}
.um-btn-save:hover{background:#6d28d9;}
.um-btn-hapus{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:10px;border:none;background:#ef4444;color:white;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.um-btn-hapus:hover{background:#dc2626;}
.um-btn-hapus svg{width:15px;height:15px;}
</style>

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script>
const ROLE_DATA = {
    'r1': { nama:'Super Admin',  slug:'superadmin',  deskripsi:'Akses penuh ke seluruh fitur sistem tanpa batasan.',                  bg:'#fdf4ff', c:'#9333ea', icon:'#9333ea', perms:['p1','p2','p3','p4','p5','p6','p7','p8'], userCount:1, system:true  },
    'r2': { nama:'Kesiswaan',    slug:'kesiswaan',   deskripsi:'Mengelola laporan bullying, verifikasi, dan proses tindak lanjut.',   bg:'#f0fdf4', c:'#16a34a', icon:'#16a34a', perms:['p1','p2','p3','p4','p5'],             userCount:2, system:false },
    'r3': { nama:'Guru BK',      slug:'guru-bk',     deskripsi:'Memproses dan memberikan tindak lanjut pada laporan yang masuk.',     bg:'#eff6ff', c:'#3b82f6', icon:'#3b82f6', perms:['p1','p3','p4'],                        userCount:2, system:false },
    'r4': { nama:'Wali Kelas',   slug:'wali-kelas',  deskripsi:'Melihat laporan terkait kelas yang diampu dan menerima notifikasi.', bg:'#fff7ed', c:'#ea580c', icon:'#ea580c', perms:['p1','p2'],                             userCount:3, system:false },
};

const PERM_DATA = {
    'p1':{ nama:'Lihat Laporan',        group:'Laporan' },
    'p2':{ nama:'Buat Laporan',         group:'Laporan' },
    'p3':{ nama:'Proses Laporan',       group:'Laporan' },
    'p4':{ nama:'Kelola User',          group:'User' },
    'p5':{ nama:'Kelola Role',          group:'User' },
    'p6':{ nama:'Kelola Permission',    group:'User' },
    'p7':{ nama:'Lihat Rekapitulasi',   group:'Analitik' },
    'p8':{ nama:'Export Data',          group:'Analitik' },
};

let _editRoleId=null, _hapusRoleId=null, _selectedColor={bg:'#f0fdf4',c:'#16a34a'}, _checkedPerms=new Set();

function renderCards(){
    const q=(document.getElementById('searchInput')?.value||'').toLowerCase();
    const grid=document.getElementById('roleGrid');
    const noRes=document.getElementById('noResults');
    const filtered=Object.entries(ROLE_DATA).filter(([,d])=>!q||d.nama.toLowerCase().includes(q)||d.slug.toLowerCase().includes(q));
    if(!filtered.length){grid.innerHTML='';noRes.classList.remove('hidden');return;}
    noRes.classList.add('hidden');
    grid.innerHTML=filtered.map(([id,d])=>{
        const permTags=d.perms.slice(0,3).map(pid=>`<span class="perm-tag">${PERM_DATA[pid]?.nama||pid}</span>`).join('');
        const more=d.perms.length>3?`<span class="perm-more">+${d.perms.length-3} lagi</span>`:'';
        const deleteBtn=d.system?'':`<button class="btn-aksi delete" title="Hapus" onclick="openHapusRole('${id}')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>`;
        return `<div class="role-card" id="rc-${id}">
            <div class="role-card-header">
                <div class="role-card-icon-wrap">
                    <div class="role-card-icon" style="background:${d.bg}">
                        <svg fill="none" stroke="${d.c}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <div class="role-card-name" style="color:${d.c}">${d.nama}</div>
                        <div class="role-card-slug">${d.slug}</div>
                    </div>
                </div>
                <div class="role-card-actions">
                    <button class="btn-aksi edit" title="Edit" onclick="openRoleModal('${id}')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                    ${deleteBtn}
                </div>
            </div>
            <div class="role-card-body">
                <p class="role-card-desc">${d.deskripsi}</p>
                <div class="role-card-perms">${permTags}${more}</div>
                <div class="role-card-footer">
                    <span class="role-user-count"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>${d.userCount} user</span>
                    ${d.system?'<span class="role-is-system">SYSTEM</span>':''}
                </div>
            </div>
        </div>`;
    }).join('');
}

function buildPermChecks(checked=[]){
    const grid=document.getElementById('permCheckGrid'); if(!grid)return;
    _checkedPerms=new Set(checked);
    grid.innerHTML=Object.entries(PERM_DATA).map(([id,p])=>{
        const isChk=checked.includes(id);
        return `<label class="perm-check-item ${isChk?'checked':''}" id="pci-${id}">
            <input type="checkbox" value="${id}" ${isChk?'checked':''} onchange="togglePerm(this,'${id}')">
            <span class="perm-check-label">${p.nama}</span>
        </label>`;
    }).join('');
}

function togglePerm(el,id){const item=document.getElementById('pci-'+id);if(el.checked){_checkedPerms.add(id);item.classList.add('checked');}else{_checkedPerms.delete(id);item.classList.remove('checked');}}
function selectColor(el){document.querySelectorAll('.color-opt').forEach(e=>e.classList.remove('selected'));el.classList.add('selected');_selectedColor={bg:el.dataset.bg,c:el.dataset.c};}

function openRoleModal(id=null){
    _editRoleId=id;
    document.getElementById('roleTitleModal').textContent=id?'Edit Role':'Tambah Role Baru';
    if(id){
        const d=ROLE_DATA[id];
        document.getElementById('roleNama').value=d.nama;
        document.getElementById('roleSlug').value=d.slug;
        document.getElementById('roleDeskripsi').value=d.deskripsi;
        _selectedColor={bg:d.bg,c:d.c};
        const opt=document.querySelector(`.color-opt[data-c="${d.c}"]`);
        document.querySelectorAll('.color-opt').forEach(e=>e.classList.remove('selected'));
        if(opt)opt.classList.add('selected');
        buildPermChecks(d.perms);
    } else {
        ['roleNama','roleSlug','roleDeskripsi'].forEach(i=>document.getElementById(i).value='');
        document.querySelectorAll('.color-opt').forEach((e,i)=>{e.classList.toggle('selected',i===0);});
        _selectedColor={bg:'#f0fdf4',c:'#16a34a'};
        buildPermChecks([]);
    }
    document.getElementById('modalRole').style.display='flex';
    document.body.style.overflow='hidden';
}
function closeRoleModal(){document.getElementById('modalRole').style.display='none';document.body.style.overflow='';}

function saveRole(){
    const nama=document.getElementById('roleNama').value.trim();
    const slug=document.getElementById('roleSlug').value.trim();
    if(!nama||!slug){alert('Nama dan Slug wajib diisi.');return;}
    if(_editRoleId){
        Object.assign(ROLE_DATA[_editRoleId],{nama,slug,deskripsi:document.getElementById('roleDeskripsi').value.trim(),bg:_selectedColor.bg,c:_selectedColor.c,perms:[..._checkedPerms]});
    } else {
        const newId='r'+(Object.keys(ROLE_DATA).length+1);
        ROLE_DATA[newId]={nama,slug,deskripsi:document.getElementById('roleDeskripsi').value.trim(),bg:_selectedColor.bg,c:_selectedColor.c,perms:[..._checkedPerms],userCount:0,system:false};
    }
    closeRoleModal(); renderCards();
    if(typeof Toast!=='undefined')Toast.show('success','Berhasil',_editRoleId?'Role berhasil diperbarui.':'Role baru berhasil ditambahkan.');
}

function openHapusRole(id){_hapusRoleId=id;document.getElementById('hapusRoleNama').textContent=ROLE_DATA[id]?.nama||id;document.getElementById('modalHapusRole').style.display='flex';document.body.style.overflow='hidden';}
function doHapusRole(){if(!_hapusRoleId||ROLE_DATA[_hapusRoleId]?.system)return;delete ROLE_DATA[_hapusRoleId];document.getElementById('modalHapusRole').style.display='none';document.body.style.overflow='';renderCards();if(typeof Toast!=='undefined')Toast.show('success','Dihapus','Role berhasil dihapus.');}

document.getElementById('searchInput')?.addEventListener('input',renderCards);
document.getElementById('modalRole').addEventListener('click',function(e){if(e.target===this)closeRoleModal();});
document.getElementById('modalHapusRole').addEventListener('click',function(e){if(e.target===this){this.style.display='none';document.body.style.overflow='';}});
document.addEventListener('DOMContentLoaded',()=>renderCards());
</script>
@endsection