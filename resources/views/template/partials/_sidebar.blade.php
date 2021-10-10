<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">SIAPKO</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">SO</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ request()->is('/') || request()->is('agenda/*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('agenda.index') }}"><i class="fas fa-calendar"></i>
                    <span>Agenda</span></a></li>
        </ul>
        <ul class="sidebar-menu">
            <li class="{{ request()->is('riwayat') ? 'active' : '' }}"><a class="nav-link" href="{{ route('riwayat.index') }}"><i class="fas fa-history"></i>
                    <span>Riwayat</span></a></li>
        </ul>
    </aside>
</div>