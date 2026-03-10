function makePagBtn(label, disabled, fn) {
    const b = document.createElement('button');
    b.className   = 'page-btn';
    b.textContent = label;
    b.disabled    = disabled;
    if (disabled) b.style.opacity = '.4';
    b.addEventListener('click', fn);
    return b;
}

function getPageNumbers(total, currentPage) {
    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
    const p = [];
    if (currentPage <= 4) {
        for (let i = 1; i <= 5; i++) p.push(i);
        p.push('...'); p.push(total);
    } else if (currentPage >= total - 3) {
        p.push(1); p.push('...');
        for (let i = total - 4; i <= total; i++) p.push(i);
    } else {
        p.push(1); p.push('...');
        for (let i = currentPage - 1; i <= currentPage + 1; i++) p.push(i);
        p.push('...'); p.push(total);
    }
    return p;
}

function buildPagination(wrap, currentPage, filteredCount, perPage, goPageFn) {
    if (!wrap) return;
    const total = Math.ceil(filteredCount / perPage);
    wrap.innerHTML = '';
    if (total <= 1) return;

    wrap.appendChild(makePagBtn('‹', currentPage === 1, () => goPageFn(currentPage - 1)));
    getPageNumbers(total, currentPage).forEach(p => {
        if (p === '...') {
            const s = document.createElement('span');
            s.className   = 'page-ellipsis';
            s.textContent = '...';
            wrap.appendChild(s);
        } else {
            const b = makePagBtn(p, false, () => goPageFn(p));
            if (p === currentPage) b.classList.add('active');
            wrap.appendChild(b);
        }
    });
    wrap.appendChild(makePagBtn('›', currentPage === total, () => goPageFn(currentPage + 1)));
}

function buildTableInfo(el, currentPage, filteredRows, perPage, satuan = 'data') {
    if (!el) return;
    const s = (currentPage - 1) * perPage + 1;
    const e = Math.min(currentPage * perPage, filteredRows.length);
    el.textContent = filteredRows.length === 0
        ? `Tidak ada ${satuan} ditemukan`
        : `Menampilkan ${s}–${e} dari ${filteredRows.length} ${satuan}`;
}

function mdOpenOverlay(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function mdCloseOverlay(id) {
    document.getElementById(id).style.display = 'none';
    document.body.style.overflow = '';
}

function ucfirst(str) { return str.charAt(0).toUpperCase() + str.slice(1); }