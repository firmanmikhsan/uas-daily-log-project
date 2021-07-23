<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.index') }}" class="brand-link">
        <img src="{{ asset('adminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">DailyLog</span>
    </a>
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
              <img src="{{ asset('adminLTE/dist/img/avatar2.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        {{-- Sidebar menu --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @component('components.admin.sidebar.sidebar-tree-view', [
                    "route" => "#",
                    "title" => "Master Data",
                    "icon" => "fas fa-archive",
                    "actives" => [
                        "dashboard/users*",
                        "dashboard/projects*",
                    ]
                ])
                    @include('components.admin.sidebar.sidebar-item', [
                        "icon" => "far fa-circle",
                        "route" => route('dashboard.users.index'),
                        'title' => "Users"
                    ])
                    @include('components.admin.sidebar.sidebar-item', [
                        "icon" => "far fa-circle",
                        "route" => route('dashboard.users.index'),
                        'title' => "Employee"
                    ])
                    @include('components.admin.sidebar.sidebar-item', [
                        "icon" => "far fa-circle",
                        "route" => route('dashboard.projects.index'),
                        'title' => "Project",
                        "active" => "dashboard/projects*",
                    ])
                @endcomponent
                @component('components.admin.sidebar.sidebar-tree-view', [
                    "route" => "#",
                    "title" => "Project",
                    "icon" => "fas fa-project-diagram",
                ])
                    @include('components.admin.sidebar.sidebar-item', [
                        "icon" => "far fa-circle",
                        "route" => route('dashboard.users.index'),
                        'title' => "Project Assignment"
                    ])
                    @include('components.admin.sidebar.sidebar-item', [
                        "icon" => "far fa-circle",
                        "route" => route('dashboard.projects.index'),
                        'title' => "Project Report"
                    ])
                @endcomponent
                @component('components.admin.sidebar.sidebar-tree-view', [
                    "route" => "#",
                    "title" => "Employes",
                    "icon" => "fas fa-user-cog",
                ])
                    @include('components.admin.sidebar.sidebar-item', [
                        "icon" => "far fa-circle",
                        "route" => route('dashboard.users.index'),
                        'title' => "Project Manager"
                    ])
                    @include('components.admin.sidebar.sidebar-item', [
                        "icon" => "far fa-circle",
                        "route" => route('dashboard.projects.index'),
                        'title' => "Developer"
                    ])
                @endcomponent
                {{-- @include('components.admin.sidebar.sidebar-item', [
                    "icon" => "fas fa-user",
                    "route" => route('dashboard.users.index'),
                    'title' => "Users"
                ]) --}}
            </ul>
        </nav>
        {{-- End of Sidebar menu --}}
    </div>
</aside>