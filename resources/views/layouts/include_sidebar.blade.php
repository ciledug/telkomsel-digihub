<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- dashboard -->
        <li class="nav-item">
            @if (Route::currentRouteName() === 'dashboard')
            <a class="nav-link" href="{{ url('/dashboard') }}">
            @else
            <a class="nav-link collapsed" href="{{ url('/dashboard') }}">
            @endif
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        
        <!-- telco -->
        <li class="nav-item">
            @if (Route::currentRouteName() !== 'telco')
            <a class="nav-link collapsed" href="{{ route('telco') }}">
                <i class="bi bi-menu-button-wide"></i>
                <span>Telco API</span>
            </a>
            @else
            <a class="nav-link" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>Telco API</span>
            </a>
            @endif
        </li>
    </ul>
</aside>