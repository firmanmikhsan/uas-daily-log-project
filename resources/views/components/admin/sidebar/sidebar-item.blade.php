<li class="nav-item">
    <a href="{{ $route }}" class="nav-link">
        <i class="nav-icon {{ $icon }}"></i>
        <p>
            {{ $title }}
            @isset($badge)
                <span class="right badge badge-danger">{{ $badge }}</span>
            @endisset
        </p>
    </a>
</li>