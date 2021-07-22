<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
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