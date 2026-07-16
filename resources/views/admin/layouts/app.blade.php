<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Back-office</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: 250px; background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            display: flex; flex-direction: column; position: fixed;
            top: 0; left: 0; height: 100vh; z-index: 100;
        }
        .sidebar-brand {
            padding: 25px 20px; border-bottom: 1px solid rgba(255,255,255,0.08);
            color: white; font-size: 1.2em; font-weight: 700;
        }
        .sidebar-brand span { color: #a78bfa; }

        .sidebar-nav { flex: 1; padding: 15px 0; overflow-y: auto; }
        .nav-section { padding: 8px 20px 5px; font-size: 0.7em; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 1.5px; }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 20px; color: rgba(255,255,255,0.65);
            text-decoration: none; font-size: 0.9em; transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .nav-item:hover { background: rgba(255,255,255,0.07); color: white; }
        .nav-item.active { background: rgba(102,126,234,0.2); color: #a78bfa; border-left-color: #a78bfa; }
        .nav-item .icon { width: 20px; text-align: center; font-size: 1.1em; }
        .nav-badge { margin-left: auto; background: #ef4444; color: white; border-radius: 20px; padding: 2px 8px; font-size: 0.75em; }

        .sidebar-footer { padding: 15px 20px; border-top: 1px solid rgba(255,255,255,0.08); }
        .admin-info { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .admin-avatar { width: 36px; height: 36px; background: #667eea; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.9em; }
        .admin-name { color: white; font-size: 0.85em; font-weight: 600; }
        .admin-role { color: rgba(255,255,255,0.4); font-size: 0.75em; }
        .btn-logout { display: block; text-align: center; padding: 8px; background: rgba(239,68,68,0.15); color: #f87171; border-radius: 8px; text-decoration: none; font-size: 0.85em; transition: background 0.2s; }
        .btn-logout:hover { background: rgba(239,68,68,0.3); }

        /* MAIN */
        .main-content { margin-left: 250px; flex: 1; display: flex; flex-direction: column; }

        /* TOPBAR */
        .topbar {
            background: white; padding: 0 30px; height: 65px;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 1.2em; font-weight: 700; color: #1a1a2e; }
        .topbar-actions { display: flex; gap: 10px; align-items: center; }
        .topbar-link { color: #667eea; text-decoration: none; font-size: 0.85em; padding: 7px 14px; border: 1px solid #667eea; border-radius: 8px; transition: all 0.2s; }
        .topbar-link:hover { background: #667eea; color: white; }

        /* ALERTS */
        .alert { padding: 12px 20px; border-radius: 8px; margin: 15px 30px 0; font-size: 0.9em; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* PAGE CONTENT */
        .page-content { padding: 25px 30px; flex: 1; }

        /* CARDS */
        .card { background: white; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .card-header { padding: 18px 25px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between; }
        .card-header h2 { font-size: 1em; color: #1a1a2e; font-weight: 700; }
        .card-body { padding: 25px; }

        /* TABLE */
        .table { width: 100%; border-collapse: collapse; font-size: 0.9em; }
        .table th { padding: 12px 15px; text-align: left; font-size: 0.8em; color: #888; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #f0f0f0; }
        .table td { padding: 13px 15px; border-bottom: 1px solid #f8f8f8; color: #333; vertical-align: middle; }
        .table tr:last-child td { border-bottom: none; }
        .table tr:hover td { background: #fafafa; }

        /* BADGES */
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.78em; font-weight: 600; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger  { background: #fee2e2; color: #991b1b; }
        .badge-info    { background: #dbeafe; color: #1e40af; }

        /* BUTTONS */
        .btn { padding: 8px 16px; border-radius: 8px; border: none; cursor: pointer; font-size: 0.85em; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s; }
        .btn-primary { background: #667eea; color: white; }
        .btn-primary:hover { background: #5a6fd6; }
        .btn-success { background: #10b981; color: white; }
        .btn-success:hover { background: #059669; }
        .btn-warning { background: #f59e0b; color: white; }
        .btn-warning:hover { background: #d97706; }
        .btn-danger  { background: #ef4444; color: white; }
        .btn-danger:hover  { background: #dc2626; }
        .btn-sm { padding: 5px 10px; font-size: 0.8em; }

        /* FORMS */
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 0.85em; color: #555; margin-bottom: 6px; font-weight: 600; }
        .form-control {
            width: 100%; padding: 10px 14px; border: 2px solid #e8e8e8;
            border-radius: 9px; font-size: 0.9em; transition: border-color 0.2s;
        }
        .form-control:focus { outline: none; border-color: #667eea; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .form-error { color: #ef4444; font-size: 0.8em; margin-top: 4px; }
    </style>
    @stack('styles')
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">🛍️ <span>Admin</span> Panel</div>

        <nav class="sidebar-nav">
            <div class="nav-section">Principal</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="icon">📊</span> Dashboard
            </a>

            <div class="nav-section">Catalogue</div>
            <a href="{{ route('admin.produits.index') }}" class="nav-item {{ request()->routeIs('admin.produits*') ? 'active' : '' }}">
                <span class="icon">📦</span> Produits
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <span class="icon">📂</span> Catégories
            </a>

            <div class="nav-section">Ventes</div>
            <a href="{{ route('admin.commandes.index') }}" class="nav-item {{ request()->routeIs('admin.commandes*') ? 'active' : '' }}">
                <span class="icon">🧾</span> Commandes
                @php $enAttente = \App\Models\Commande::where('statut','en_attente')->count(); @endphp
                @if($enAttente > 0)
                    <span class="nav-badge">{{ $enAttente }}</span>
                @endif
            </a>

            <div class="nav-section">Utilisateurs</div>
            <a href="{{ route('admin.utilisateurs.index') }}" class="nav-item {{ request()->routeIs('admin.utilisateurs*') ? 'active' : '' }}">
                <span class="icon">👥</span> Utilisateurs
            </a>

            <div class="nav-section">Boutique</div>
            <a href="{{ route('boutique') }}" class="nav-item" target="_blank">
                <span class="icon">🌐</span> Voir la boutique
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="admin-info">
                <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}</div>
                <div>
                    <div class="admin-name">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</div>
                    <div class="admin-role">Administrateur</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout" style="width:100%; border:none; cursor:pointer;">🚪 Déconnexion</button>
            </form>
        </div>
    </aside>

    <div class="main-content">
        <div class="topbar">
            <div class="topbar-title">@yield('title', 'Dashboard')</div>
            <div class="topbar-actions">
                <a href="{{ route('admin.produits.create') }}" class="topbar-link">+ Nouveau produit</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif

        <div class="page-content">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
