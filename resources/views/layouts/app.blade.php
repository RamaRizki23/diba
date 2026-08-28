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
        .shell { display:flex; min-height:100vh; }
        .sidebar { width:224px; padding:0 8px; background:var(--sidebar); color:#dce1e4; display:flex; flex-direction:column; }
        .brand { display:flex; gap:10px; align-items:center; padding:18px 10px; color:#fff; font-family:'Space Grotesk'; font-size:19px; font-weight:500; border-bottom:1px solid #4b5156; }
        .brand-mark { width:31px; height:31px; border-radius:50%; background:#e9ecef; color:#59636b; display:grid; place-items:center; font-family:Arial,sans-serif; font-weight:700; }
        .nav-label { padding:23px 9px 10px; color:#aeb6bb; font-size:11px; letter-spacing:1px; text-transform:lowercase; }
        .nav a { display:flex; align-items:flex-start; gap:10px; padding:10px 9px; color:#d5dade; margin-bottom:2px; font-size:13px; line-height:1.3; }
        .nav a:hover,.nav a.active { color:#fff; background:#41484e; }
        .nav-icon { width:21px; color:#e4e8ea; font-weight:400; text-align:center; font-size:16px; }
        .sidebar-footer { margin-top:auto; border-top:1px solid #4b5156; padding:15px 9px; color:#aeb6bb; font-size:11px; }
        .user-chip { display:flex; gap:10px; align-items:center; margin-top:10px; color:#fff; font-size:13px; }
        .avatar { width:30px; height:30px; border-radius:50%; background:var(--orange); color:var(--ink); display:grid; place-items:center; font-weight:700; }
        .main { flex:1; min-width:0; padding:0 28px 45px; }
        .main:before { content:''; display:block; height:64px; margin:0 -28px 26px; background:#fff; border-bottom:1px solid var(--line); }
        .main:after { content:'☰'; position:absolute; top:20px; left:244px; color:#77838a; font-size:18px; }
        .topbar { display:flex; justify-content:space-between; gap:20px; align-items:center; margin-bottom:24px; }
        .eyebrow { color:var(--teal); font-size:11px; font-weight:700; letter-spacing:1.1px; text-transform:uppercase; margin-bottom:7px; }
        .page-title { font-size:29px; letter-spacing:-.5px; }
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
        @media(max-width:900px){ .sidebar{width:205px}.main{padding:0 20px 35px}.main:before{margin-left:-20px;margin-right:-20px}.main:after{left:224px}.site-footer{margin-left:-20px;margin-right:-20px}.stat-grid{grid-template-columns:repeat(2,1fr)} } @media(max-width:650px){ .shell{display:block}.sidebar{width:100%; padding:0 8px}.brand{padding-bottom:12px}.nav{display:flex; overflow:auto; gap:4px}.nav-label,.sidebar-footer{display:none}.nav a{white-space:nowrap}.main{padding:0 15px 25px}.main:before{margin-left:-15px;margin-right:-15px}.main:after{left:18px;top:20px}.topbar{align-items:flex-start; flex-direction:column}.top-actions{width:100%}.search,.search input,.search select{width:100%}.search{flex-wrap:wrap}.table-tools{align-items:flex-start;flex-direction:column}.table-tools-right{width:100%}.table-tools-right input{flex:1}.form-grid{grid-template-columns:1fr}.full{grid-column:auto}.stat-grid{gap:9px}.stat{padding:15px}.stat-value{font-size:24px}.pagination-bar{align-items:flex-start;flex-direction:column}.pagination{flex-wrap:wrap}.site-footer{margin-left:-15px;margin-right:-15px;padding-left:15px;padding-right:15px} }
    </style>
</head>
<body class="{{ auth()->user()?->role === 'admin' ? 'admin-role' : 'user-role' }}">
<div class="shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('dashboard') }}"><span class="brand-mark">A</span>Katalog Aplikasi</a>
        <div class="nav-label">menu utama</div>
        <nav class="nav">
            <a class="{{ request()->routeIs('applications.*') ? 'active' : '' }}" href="{{ route('applications.index') }}"><span class="nav-icon"><i class="bi bi-grid-3x3-gap-fill"></i></span>Daftar Aplikasi</a>
            @if(auth()->user()?->role === 'admin')<a class="{{ request()->routeIs('master-data.*') ? 'active' : '' }}" href="{{ route('master-data.index') }}"><span class="nav-icon"><i class="bi bi-database-fill-gear"></i></span>Master Data</a>@endif
            <form method="POST" action="{{ route('logout') }}" style="margin:0">@csrf<button type="submit" style="display:flex;align-items:flex-start;gap:10px;width:100%;padding:10px 9px;border:0;background:none;color:#d5dade;font:13px 'DM Sans';text-align:left;cursor:pointer"><span class="nav-icon"><i class="bi bi-box-arrow-right"></i></span>Logout</button></form>
        </nav>
        <div class="sidebar-footer">Sistem Inventaris Digital<div class="user-chip"><span class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span><span>{{ auth()->user()->name ?? 'Administrator' }}</span></div></div>
    </aside>
    <main class="main">
        @yield('content')
    </main>
</div>
</body>
</html>
