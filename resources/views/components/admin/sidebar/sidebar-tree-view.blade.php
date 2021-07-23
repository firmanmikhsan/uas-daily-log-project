<li class="nav-item {{ request()->is($actives ?? '') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->is($actives ?? '') ? 'active' : '' }}">
        <i class="nav-icon {{ $icon }}"></i>
        <p>
            {{ $title }}
            <i class="fas fa-angle-left right"></i>
            @isset($badge)
                <span class="badge badge-info right">{{ $badge }}</span>
            @endisset
        </p>
    </a>
    <ul class="nav nav-treeview">
        {{ $slot }}
    </ul>
</li>