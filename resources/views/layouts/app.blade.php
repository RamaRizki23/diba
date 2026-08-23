<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'DIBA Console' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#152528; --muted:#718083; --line:#e5ecea; --paper:#f5f8f6; --white:#fff; --teal:#087f75; --lime:#c7ee73; --orange:#ffb454; --red:#df6b5f; }
        * { box-sizing:border-box; }
        body { margin:0; color:var(--ink); background:var(--paper); font-family:'DM Sans',sans-serif; }
        h1,h2,h3 { font-family:'Space Grotesk',sans-serif; margin:0; }
        a { color:inherit; text-decoration:none; }
        .shell { display:flex; min-height:100vh; }
        .sidebar { width:250px; padding:28px 18px; background:#102e2d; color:#d5e5dc; display:flex; flex-direction:column; }
        .brand { display:flex; gap:11px; align-items:center; padding:0 12px 38px; color:#fff; font-family:'Space Grotesk'; font-size:22px; font-weight:700; }
        .brand-mark { width:34px; height:34px; border-radius:10px 10px 3px 10px; background:var(--lime); color:var(--ink); display:grid; place-items:center; }
        .nav-label { padding:0 12px 12px; color:#71928b; font-size:11px; letter-spacing:1.4px; text-transform:uppercase; }
        .nav a { display:flex; align-items:center; gap:12px; padding:12px; border-radius:10px; color:#b5cbc4; margin-bottom:4px; font-size:14px; }
        .nav a:hover,.nav a.active { color:#fff; background:#194541; }
        .nav-icon { width:22px; color:var(--lime); font-weight:700; text-align:center; }
        .sidebar-footer { margin-top:auto; border-top:1px solid #29504a; padding:18px 12px 0; color:#8fabaa; font-size:12px; }
        .user-chip { display:flex; gap:10px; align-items:center; margin-top:10px; color:#fff; font-size:13px; }
        .avatar { width:30px; height:30px; border-radius:50%; background:var(--orange); color:var(--ink); display:grid; place-items:center; font-weight:700; }
        .main { flex:1; min-width:0; padding:28px 42px 50px; }
        .topbar { display:flex; justify-content:space-between; gap:20px; align-items:center; margin-bottom:32px; }
        .eyebrow { color:var(--teal); font-size:12px; font-weight:700; letter-spacing:1.3px; text-transform:uppercase; margin-bottom:7px; }
        .page-title { font-size:31px; letter-spacing:-.5px; }
        .top-actions { display:flex; align-items:center; gap:14px; }
        .button { display:inline-flex; align-items:center; justify-content:center; gap:8px; border:0; border-radius:9px; padding:11px 16px; background:var(--teal); color:#fff; font:600 13px 'DM Sans'; cursor:pointer; }
        .button:hover { background:#06675f; }
        .button.secondary { background:#e5efec; color:var(--teal); }
        .button.danger { background:#fae9e6; color:#a8443b; }
        .stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:28px; }
        .stat { background:#fff; border:1px solid var(--line); border-radius:13px; padding:20px; position:relative; overflow:hidden; }
        .stat:after { content:''; position:absolute; width:55px; height:55px; border-radius:50%; right:-15px; top:-15px; background:var(--lime); opacity:.55; }
        .stat:nth-child(2):after { background:#9ee3d8; } .stat:nth-child(3):after { background:var(--orange); } .stat:nth-child(4):after { background:#d7c7ff; }
        .stat-label { color:var(--muted); font-size:12px; } .stat-value { font:700 30px 'Space Grotesk'; margin-top:10px; }
        .panel { background:#fff; border:1px solid var(--line); border-radius:13px; padding:22px; }
        .panel-head { display:flex; justify-content:space-between; align-items:center; gap:15px; margin-bottom:18px; } .panel-head h2 { font-size:19px; }
        .table-wrap { overflow:auto; } table { width:100%; border-collapse:collapse; font-size:13px; } th { color:#8a9998; text-align:left; font-size:11px; letter-spacing:.7px; text-transform:uppercase; padding:11px 12px; border-bottom:1px solid var(--line); } td { padding:15px 12px; border-bottom:1px solid #edf2f0; vertical-align:middle; } tr:last-child td { border-bottom:0; }
        .code { color:var(--teal); font-size:11px; font-weight:700; } .app-name { font-weight:700; margin-top:3px; } .muted { color:var(--muted); }
        .status { display:inline-flex; padding:5px 9px; border-radius:20px; font-size:11px; font-weight:700; background:#e4f5d0; color:#4d761d; } .status.nonaktif { background:#f8e5e1; color:#a8443b; } .status.dalam { background:#fff0d5; color:#9a6618; }
        .actions { display:flex; gap:7px; } .icon-button { border:0; background:#eff5f2; color:var(--teal); border-radius:7px; padding:7px 9px; cursor:pointer; font-size:12px; } .icon-button.delete { color:#a8443b; background:#fff0ee; }
        .search { display:flex; gap:8px; } .search input { width:240px; }
        .form-panel { max-width:980px; } .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px 22px; } .full { grid-column:1/-1; }
        label { display:block; font-size:12px; font-weight:700; margin-bottom:7px; } input, select, textarea { width:100%; border:1px solid #d9e4e0; border-radius:8px; background:#fbfdfc; padding:11px 12px; color:var(--ink); font:14px 'DM Sans'; outline:none; } input:focus,select:focus,textarea:focus { border-color:var(--teal); box-shadow:0 0 0 3px #dff2ee; } textarea { min-height:100px; resize:vertical; }
        .form-actions { display:flex; justify-content:flex-end; gap:10px; padding-top:22px; margin-top:22px; border-top:1px solid var(--line); }
        .alert { padding:12px 15px; border-radius:9px; margin-bottom:18px; font-size:13px; background:#e5f5df; color:#397226; } .errors { background:#fce9e7; color:#9d4038; } .errors li { margin:3px 0; }
        @media(max-width:900px){ .sidebar{width:205px}.main{padding:25px}.stat-grid{grid-template-columns:repeat(2,1fr)} } @media(max-width:650px){ .shell{display:block}.sidebar{width:100%; padding:16px}.brand{padding-bottom:17px}.nav{display:flex; overflow:auto; gap:4px}.nav-label,.sidebar-footer{display:none}.nav a{white-space:nowrap}.main{padding:22px 15px}.topbar{align-items:flex-start; flex-direction:column}.top-actions{width:100%}.search,.search input{width:100%}.form-grid{grid-template-columns:1fr}.full{grid-column:auto}.stat-grid{gap:9px}.stat{padding:15px}.stat-value{font-size:24px} }
    </style>
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('dashboard') }}"><span class="brand-mark">D</span>DIBA Console</a>
        <div class="nav-label">Workspace</div>
        <nav class="nav">
            <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon">~</span>Ringkasan</a>
            <a class="{{ request()->routeIs('applications.*') ? 'active' : '' }}" href="{{ route('applications.index') }}"><span class="nav-icon">▦</span>Katalog Aplikasi</a>
        </nav>
        <div class="sidebar-footer">Sistem Inventaris Digital<div class="user-chip"><span class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span><span>{{ auth()->user()->name ?? 'Administrator' }}</span></div></div>
    </aside>
    <main class="main">
        @yield('content')
    </main>
</div>
</body>
</html>
