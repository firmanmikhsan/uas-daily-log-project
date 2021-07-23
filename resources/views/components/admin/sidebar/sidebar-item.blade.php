<li class="nav-item">
    <a href="{{ $route }}" class="nav-link {{ request()->is($active ?? '') ? 'active' : ''}}">
        <i class="nav-icon {{ $icon }}"></i>
        <p>
            {{ $title }}
            @isset($badge)
                <span class="right badge badge-danger">{{ $badge }}</span>
            @endisset
        </p>
    </a>
</li>