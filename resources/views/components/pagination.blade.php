

<div class="table-footer">
    <p class="table-info" id="{{ $tableInfoId ?? 'tableInfo' }}">Memuat data...</p>
    <div class="pagination" id="{{ $paginationId ?? 'paginationWrap' }}">
    </div>
</div>

<style>
.table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    border-top: 1px solid var(--gray-100, #f3f4f6);
    flex-wrap: wrap;
    gap: 10px;
    background: #fafafa;
    border-radius: 0 0 16px 16px;
}

.table-info {
    font-size: .75rem;
    color: var(--gray-500, #6b7280);
}

.pagination {
    display: flex;
    align-items: center;
    gap: 4px;
}

.page-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1.5px solid var(--gray-200, #e5e7eb);
    background: white;
    font-family: inherit;
    font-size: .78rem;
    font-weight: 600;
    color: var(--gray-700, #374151);
    cursor: pointer;
    transition: all .15s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-btn:hover:not(:disabled):not(.active) {
    border-color: var(--green, #10b981);
    color: var(--green-dark, #059669);
    background: var(--green-faint, #f0fdf4);
}

.page-btn.active {
    background: var(--green, #10b981);
    border-color: var(--green, #10b981);
    color: white;
    cursor: default;
}

.page-btn:disabled {
    cursor: not-allowed;
}

.page-ellipsis {
    font-size: .78rem;
    color: var(--gray-400, #9ca3af);
    padding: 0 2px;
    line-height: 32px;
}
</style>