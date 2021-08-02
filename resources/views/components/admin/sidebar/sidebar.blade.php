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
                @role('super-admin')
                    @component('components.admin.sidebar.sidebar-tree-view', [
                        "route" => "#",
                        "title" => "Master Data",
                        "icon" => "fas fa-archive",
                        "actives" => [
                            "dashboard/users*",
                            "dashboard/projects*",
                            "dashboard/roles*",
                            "dashboard/permissions*",
                            "dashboard/positions*"
                        ]
                    ])
                        @include('components.admin.sidebar.sidebar-item', [
                            "icon" => "far fa-circle",
                            "route" => route('dashboard.users.index'),
                            'title' => "Users",
                            "active" => "dashboard/users*",
                        ])
                        @include('components.admin.sidebar.sidebar-item', [
                            "icon" => "far fa-circle",
                            "route" => route('dashboard.projects.index'),
                            'title' => "Project",
                            "active" => "dashboard/projects*",
                        ])
                        @include('components.admin.sidebar.sidebar-item', [
                            "icon" => "far fa-circle",
                            "route" => route('dashboard.roles.index'),
                            'title' => "Roles",
                            "active" => "dashboard/roles*",
                        ])
                        @include('components.admin.sidebar.sidebar-item', [
                            "icon" => "far fa-circle",
                            "route" => route('dashboard.permissions.index'),
                            'title' => "Permission",
                            "active" => "dashboard/permissions*",
                        ])
                        @include('components.admin.sidebar.sidebar-item', [
                            "icon" => "far fa-circle",
                            "route" => route('dashboard.positions.index'),
                            'title' => "Job Position",
                            "active" => "dashboard/positions*",
                        ])
                    @endcomponent
                @endunlessrole
                @component('components.admin.sidebar.sidebar-tree-view', [
                    "route" => "#",
                    "title" => "Project",
                    "icon" => "fas fa-project-diagram",
                    "actives" => [
                        "dashboard/assignments*",
                        "dashboard/reports*",
                    ]
                ])
                    @include('components.admin.sidebar.sidebar-item', [
                        "icon" => "far fa-circle",
                        "route" => route('dashboard.assignments.index'),
                        'title' => "Project Assignment",
                        "active" => "dashboard/assignments*"
                    ])
                    @include('components.admin.sidebar.sidebar-item', [
                        "icon" => "far fa-circle",
                        "route" => route('dashboard.reports.index'),
                        'title' => "Project Report",
                        "active" => "dashboard/reports*"
                    ])
                @endcomponent
                @include('components.admin.sidebar.sidebar-item', [
                    "icon" => "fas fa-sign-out-alt",
                    "route" => "#",
                    'title' => "Logout",
                    "id" => "logout"
                ])
            </ul>
        </nav>
        {{-- End of Sidebar menu --}}
    </div>
</aside>
<form id="logout-form" method="post" class="d-none" action="{{ route('logout') }}">
    @csrf
</form>
@push('js')
    <script>
        $(function() {
            $("#logout").click(function (e) { 
                let logoutForm = $('#logout-form');
                logoutForm.submit();
            });
        })
    </script>
@endpush