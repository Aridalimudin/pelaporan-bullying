@extends('layouts.app-admin')

@section('content')

@include('components.sidebar-admin', ['activePage' => 'notifications'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Notifikasi',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('administrator.dashboard')],
            ['label' => 'Notifikasi'],
        ],
    ])

    <main class="admin-main">

        <div class="notif-page-header animate-fade-in">
            <div class="notif-page-header-left">
                <h2 class="notif-page-title">Semua Notifikasi</h2>
                <p class="notif-page-sub">Riwayat seluruh notifikasi yang masuk</p>
            </div>
            <div class="notif-page-actions">
                <div class="notif-filter-tabs" id="notifFilterTabs">
                    <button class="notif-tab active" data-filter="all"    onclick="setFilter('all')">Semua</button>
                    <button class="notif-tab"         data-filter="unread" onclick="setFilter('unread')">Belum Dibaca</button>
                </div>
                <button class="notif-page-readall-btn" onclick="pageMarkAllRead()">
                    Tandai semua dibaca
                </button>
            </div>
        </div>

        <div class="notif-page-list animate-fade-in" id="notifPageList">
            <div class="notif-page-loading">Memuat notifikasi...</div>
        </div>

        <div class="notif-page-pagination" id="notifPagePagination"></div>

    </main>

    @include('components.footer', ['type' => 'admin'])
    @include('components.toast')
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/notification-page.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/notification-page.js') }}"></script>
@endpush