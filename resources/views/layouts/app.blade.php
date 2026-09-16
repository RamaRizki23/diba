<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'DIBA Console' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --ink:#263238; --muted:#71808a; --line:#dfe4e7; --paper:#f1f3f6; --white:#fff; --teal:#119db4; --lime:#c7ee73; --orange:#ffb454; --red:#df6b5f; --sidebar:#343a40; }
        * { box-sizing:border-box; }
        body { margin:0; color:var(--ink); background:var(--paper); font-family:'DM Sans',sans-serif; }
        h1,h2,h3 { font-family:'Space Grotesk',sans-serif; margin:0; }
        a { color:inherit; text-decoration:none; }
        .shell { display:flex; align-items:stretch; min-height:100vh; }
        .sidebar { order:1; flex:0 0 250px; width:250px; padding:0 8px; background:var(--sidebar); color:#dce1e4; display:flex; flex-direction:column; position:sticky; top:0; height:100vh; }
        .brand { display:flex; gap:10px; align-items:center; padding:18px 10px; color:#fff; font-family:'Space Grotesk'; font-size:24px; font-weight:500; white-space:nowrap; border-bottom:1px solid #4b5156; margin:0; }
        .brand-mark { width:31px; height:31px; border-radius:50%; background:#e9ecef; color:#59636b; display:grid; place-items:center; font-family:Arial,sans-serif; font-weight:700; }
        .role-label { padding:22px 12px 8px; color:#d5dade; font-size:17px; font-weight:600; text-transform:lowercase; }
        .nav-label { padding:23px 9px 10px; color:#aeb6bb; font-size:13px; letter-spacing:1px; text-transform:lowercase; }
        .nav { display:flex; flex-direction:column; }
        .nav a { display:flex; align-items:flex-start; gap:10px; padding:10px 9px; color:#d5dade; margin-bottom:2px; font-size:18px; line-height:1.3; }
        .nav a:hover,.nav a.active { color:#fff; background:#41484e; }
        .nav .login-link { margin-top:12px; background:#1fa0b5; color:#fff; border-radius:8px; font-weight:600; }
        .nav .login-link:hover { background:#168aa1; color:#fff; }
        .nav-icon { width:21px; color:#e4e8ea; font-weight:400; text-align:center; font-size:18px; }
        .logout-button { font-size:18px !important; }
        .logout-button .nav-icon { font-size:21px; }
        .sidebar-footer { margin-top:auto; border-top:1px solid #4b5156; padding:15px 9px; color:#aeb6bb; font-size:11px; }
        .nav-section { margin-top:14px; }
        .nav-section-label { padding:10px 9px 6px; font-size:11px; color:#aeb6bb; letter-spacing:0.1em; text-transform:uppercase; }
        .user-chip { display:flex; gap:10px; align-items:center; margin-top:10px; color:#fff; font-size:13px; }
        .avatar { width:30px; height:30px; border-radius:50%; background:var(--orange); color:var(--ink); display:grid; place-items:center; font-weight:700; }
        .main { order:2; flex:1 1 auto; min-width:0; padding:0 28px 45px; background:#f3f5f6; }
        .main:before { content:''; display:none; }
        .main:after { display:none; }
        .main > * { max-width:100%; }
        .menu-toggle { position:absolute; top:15px; left:268px; z-index:5; width:34px; height:34px; display:grid; place-items:center; border:0; border-radius:5px; background:#fff; color:#77838a; font-size:18px; cursor:pointer; }
        .menu-toggle:hover { color:var(--teal); background:#eef6f3; }
        .shell.sidebar-collapsed .sidebar { flex-basis:86px; width:86px; padding-left:4px; padding-right:4px; }
        .shell.sidebar-collapsed .brand { justify-content:center; padding-left:4px; padding-right:4px; }
        .shell.sidebar-collapsed .brand-text,.shell.sidebar-collapsed .nav-label,.shell.sidebar-collapsed .nav-text,.shell.sidebar-collapsed .sidebar-footer { display:none; }
        .shell.sidebar-collapsed .role-label { display:none; }
        .shell.sidebar-collapsed .nav a { justify-content:center; padding-left:8px; padding-right:8px; }
        .shell.sidebar-collapsed .nav-icon { width:auto; font-size:20px; }
        .shell.sidebar-collapsed .nav .login-link { justify-content:center; }
        .shell.sidebar-collapsed .menu-toggle { left:104px; }
        .topbar { display:flex; justify-content:space-between; gap:20px; align-items:center; margin-top:82px; margin-bottom:24px; }
        .eyebrow { color:var(--teal); font-size:14px; font-weight:700; letter-spacing:1.1px; text-transform:uppercase; margin-bottom:7px; }
        .page-title { font-size:36px; letter-spacing:-.5px; }
        .top-actions { display:flex; align-items:center; gap:14px; }
        .button { display:inline-flex; align-items:center; justify-content:center; gap:8px; border:0; border-radius:4px; padding:10px 14px; background:var(--teal); color:#fff; font:600 13px 'DM Sans'; cursor:pointer; }
        .button:hover { background:#06675f; }
        .button.secondary { background:#e5efec; color:var(--teal); }
        .button.danger { background:#fae9e6; color:#a8443b; }
        .stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:28px; }
        .stat { background:#fff; border:1px solid var(--line); border-radius:13px; padding:20px; position:relative; overflow:hidden; }
        .stat:after { content:''; position:absolute; width:55px; height:55px; border-radius:50%; right:-15px; top:-15px; background:var(--lime); opacity:.55; }
        .stat:nth-child(2):after { background:#9ee3d8; } .stat:nth-child(3):after { background:var(--orange); } .stat:nth-child(4):after { background:#d7c7ff; }
        .stat-label { color:var(--muted); font-size:12px; } .stat-value { font:700 30px 'Space Grotesk'; margin-top:10px; }
        .panel { background:#fff; border:1px solid var(--line); border-radius:3px; padding:0 16px 16px; }
        .panel-head { display:flex; justify-content:space-between; align-items:center; gap:15px; margin-bottom:18px; } .panel-head h2 { font-size:19px; }
        .table-wrap { overflow:auto; } table { width:100%; border-collapse:collapse; font-size:13px; } th { color:#8a9998; text-align:left; font-size:11px; letter-spacing:.7px; text-transform:uppercase; padding:11px 12px; border-bottom:1px solid var(--line); } td { padding:15px 12px; border-bottom:1px solid #edf2f0; vertical-align:middle; } tr:last-child td { border-bottom:0; }
        .code { color:var(--teal); font-size:11px; font-weight:700; } .app-name { font-weight:700; margin-top:3px; } .muted { color:var(--muted); }
        .status { display:inline-flex; padding:5px 9px; border-radius:20px; font-size:11px; font-weight:700; background:#e4f5d0; color:#4d761d; } .status.nonaktif { background:#f8e5e1; color:#a8443b; } .status.dalam { background:#fff0d5; color:#9a6618; }
        .actions { display:flex; gap:7px; } .icon-button { border:0; background:#eff5f2; color:var(--teal); border-radius:7px; padding:7px 9px; cursor:pointer; font-size:12px; } .icon-button.delete { color:#a8443b; background:#fff0ee; }
        .search { display:flex; gap:8px; } .search input { width:220px; } .search select { width:180px; }
        .table-tools { display:flex; justify-content:space-between; align-items:center; padding:14px 0 12px; gap:12px; color:#44545e; font-size:13px; }
        .table-tools-left,.table-tools-right { display:flex; align-items:center; gap:6px; }
        .table-tools select { width:73px; padding:7px 8px; }
        .tool-button { border:0; border-radius:3px; padding:7px 10px; color:#fff; font:12px 'DM Sans'; cursor:pointer; }
        .tool-button.copy { background:#15a5b6; } .tool-button.pdf { background:#ed5361; } .tool-button.print { background:#f5bd12; color:#27333a; } .tool-button.columns { background:#68747c; }
        .table-tools-right input { width:145px; padding:7px 9px; }
        .filter-bar { display:flex; justify-content:flex-end; gap:0; padding:11px 0 15px; border-top:1px solid #f0f2f3; }
        .filter-bar select { width:min(620px, 65%); border-radius:3px 0 0 3px; background:#fff; }
        .filter-bar .button { border-radius:0 3px 3px 0; padding-left:13px; padding-right:13px; background:#13a3ba; }
        .form-panel { max-width:980px; } .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px 22px; } .full { grid-column:1/-1; }
        label { display:block; font-size:12px; font-weight:700; margin-bottom:7px; } input, select, textarea { width:100%; border:1px solid #d9e4e0; border-radius:8px; background:#fbfdfc; padding:11px 12px; color:var(--ink); font:14px 'DM Sans'; outline:none; } input:focus,select:focus,textarea:focus { border-color:var(--teal); box-shadow:0 0 0 3px #dff2ee; } textarea { min-height:100px; resize:vertical; }
        .form-actions { display:flex; justify-content:flex-end; gap:10px; padding-top:22px; margin-top:22px; border-top:1px solid var(--line); }
        .alert { padding:12px 15px; border-radius:9px; margin-bottom:18px; font-size:13px; background:#e5f5df; color:#397226; } .errors { background:#fce9e7; color:#9d4038; } .errors li { margin:3px 0; }
        .pagination-bar { display:flex; justify-content:space-between; align-items:center; gap:16px; padding:18px 0 5px; font-size:13px; color:var(--muted); }
        .pagination { display:flex; align-items:center; gap:7px; }
        .pagination a,.pagination span { min-width:36px; height:36px; padding:0 10px; display:inline-flex; align-items:center; justify-content:center; border:1px solid var(--line); background:#fff; color:#1769c2; border-radius:2px; }
        .pagination .current { background:#087cf0; border-color:#087cf0; color:#fff; }
        .pagination .disabled { color:#9ba6ad; background:#fafafa; }
        .site-footer { margin:20px -28px -45px; padding:24px 28px; border-top:1px solid var(--line); background:#fff; color:#778895; font-size:14px; font-weight:700; }
        @media(max-width:900px){ .sidebar{width:250px;flex-basis:250px}.main{padding:0 20px 35px}.main:before{margin-left:-20px;margin-right:-20px}.menu-toggle{left:268px}.shell.sidebar-collapsed .menu-toggle{left:104px}.site-footer{margin-left:-20px;margin-right:-20px}.stat-grid{grid-template-columns:repeat(2,1fr)} } @media(max-width:650px){ .shell{display:block}.sidebar{width:100%; padding:0 8px}.shell.sidebar-collapsed .sidebar{width:86px;padding:0 4px}.brand{padding-bottom:12px}.nav{display:flex; overflow:auto; gap:4px}.nav-label,.sidebar-footer{display:none}.nav a{white-space:nowrap}.main{padding:0 15px 25px}.main:before{margin-left:-15px;margin-right:-15px}.menu-toggle{left:18px}.topbar{align-items:flex-start; flex-direction:column}.top-actions{width:100%}.search,.search input,.search select{width:100%}.search{flex-wrap:wrap}.table-tools{align-items:flex-start;flex-direction:column}.table-tools-right{width:100%}.table-tools-right input{flex:1}.form-grid{grid-template-columns:1fr}.full{grid-column:auto}.stat-grid{gap:9px}.stat{padding:15px}.stat-value{font-size:24px}.pagination-bar{align-items:flex-start;flex-direction:column}.pagination{flex-wrap:wrap}.site-footer{margin-left:-15px;margin-right:-15px;padding-left:15px;padding-right:15px} }
    </style>
    <style>
        body { font-size:20px; }
        .button,.tool-button { font-size:17px; }
        label,.table-tools,.filter-bar,.pagination-bar,.sidebar-footer { font-size:16px; }
        input,select,textarea { font-size:18px; }
        table { font-size:17px; }
        th { font-size:15px; }
        .code,.status,.icon-button { font-size:15px; }
    </style>
    <style>
        .main h1,.main .page-title { font-size:36px !important; }
        .main h2,.main .panel-head h2 { font-size:24px !important; }
        .main h3 { font-size:22px !important; }
        .main p,.main .muted,.main .eyebrow,.main .alert,.main .pagination-bar { font-size:17px !important; }
        .main label,.main .detail-row>label { font-size:17px !important; }
        .main input,.main select,.main textarea { font-size:18px !important; }
        .main button,.main .button,.main .tool-button,.main .icon-button { font-size:18px !important; }
        .main table,.main table td,.main .dashboard-table td { font-size:17px !important; }
        .main table th,.main .dashboard-table th { font-size:16px !important; }
        .main .stat-label,.main .role-label { font-size:17px !important; }
        .main .stat-value { font-size:30px !important; }
    </style>
</head>
<body class="{{ auth()->user()?->role === 'admin' ? 'admin-role' : 'user-role' }}">
<div class="shell">
    <button class="menu-toggle" type="button" aria-label="Buka atau tutup menu" aria-expanded="true"><i class="bi bi-list"></i></button>
    <aside class="sidebar">
        <a class="brand" href="{{ route('dashboard') }}"><span class="brand-mark">A</span><span class="brand-text">Katalog Aplikasi</span></a>
        @auth
            <div class="role-label">{{ auth()->user()->role === 'admin' ? 'admin' : 'viewer' }}</div>
        @endauth
        <div class="nav-label">menu utama</div>
        <nav class="nav">
            <a class="{{ request()->routeIs('dashboard') && request('scope', 'provinsi') === 'provinsi' ? 'active' : '' }}" href="{{ route('dashboard', ['scope' => 'provinsi']) }}"><span class="nav-icon"><i class="bi bi-bar-chart-fill"></i></span><span class="nav-text">Dashboard Provinsi</span></a>
            <a class="{{ request()->routeIs('dashboard') && request('scope') === 'kabupaten-kota' ? 'active' : '' }}" href="{{ route('dashboard', ['scope' => 'kabupaten-kota']) }}"><span class="nav-icon"><i class="bi bi-pie-chart-fill"></i></span><span class="nav-text">Dashboard Kabupaten/Kota</span></a>
            @auth
                <a class="{{ request()->routeIs('applications.*') ? 'active' : '' }}" href="{{ route('applications.index') }}"><span class="nav-icon"><i class="bi bi-grid-3x3-gap-fill"></i></span><span class="nav-text">Daftar Aplikasi</span></a>
                @if(auth()->user()?->role === 'admin')
                    <a class="{{ request()->routeIs('master-data.*') ? 'active' : '' }}" href="{{ route('master-data.index') }}"><span class="nav-icon"><i class="bi bi-database-fill-gear"></i></span><span class="nav-text">Master Data</span></a>
                @endif
                <a class="{{ request()->routeIs('password.*') ? 'active' : '' }}" href="{{ route('password.edit') }}"><span class="nav-icon"><i class="bi bi-key-fill"></i></span><span class="nav-text">Ganti Password</span></a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0">@csrf<button class="logout-button" type="submit" style="display:flex;align-items:flex-start;gap:10px;width:100%;padding:10px 9px;border:0;background:none;color:#d5dade;font:13px 'DM Sans';text-align:left;cursor:pointer"><span class="nav-icon"><i class="bi bi-box-arrow-right"></i></span><span class="nav-text">Logout</span></button></form>
            @endauth
            @guest
                <a class="login-link" href="{{ route('login') }}"><span class="nav-icon"><i class="bi bi-box-arrow-in-right"></i></span><span class="nav-text">Login</span></a>
            @endguest
        </nav>
        <div class="sidebar-footer">Sistem Inventaris Digital
            @auth
                <div class="user-chip"><span class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span><span>{{ auth()->user()->name ?? 'Administrator' }}</span></div>
            @endauth
        </div>
    </aside>
    <main class="main">
        @yield('content')
    </main>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const shell = document.querySelector('.shell');
    const toggle = document.querySelector('.menu-toggle');
    toggle.addEventListener('click', function () {
        const collapsed = shell.classList.toggle('sidebar-collapsed');
        toggle.setAttribute('aria-expanded', String(!collapsed));
        toggle.querySelector('i').className = collapsed ? 'bi bi-layout-sidebar' : 'bi bi-list';
    });
});
</script>
</body>
</html>
