@extends('layouts.admin.app')

@push('css')
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/ekko-lightbox/ekko-lightbox.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Role List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Role List</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center">
                            <h3 class="card-title">
                                Roles list table
                            </h3>
                            <a href="{{ route('dashboard.roles.create') }}" class="btn btn-primary">
                                Add new role
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                {{ session('status') }}
                            </div>
                        @endif
                        <table id="project-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Guard</th>
                                    <th>Permission</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->guard_name }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($role->permissions as $permission)
                                                    <li>{{ $permission->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.roles.edit', ['role' => $role->id]) }}" class="text-white btn btn-warning">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button class="btn btn-danger btn-delete" title="Delete Role" data-role-id="{{ $role->id }}">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Guard</th>
                                    <th>Permission</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <form id="delete-form" method="post" class="d-none">
                        @csrf
                        @method('delete')
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- End of Main Content --}}
@endsection

@push('js')
    <!-- Ekko Lightbox -->
    <script src="{{ asset('adminLTE/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminLTE/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminLTE/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminLTE/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminLTE/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminLTE/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    {{-- sweet alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function () {
            $('.btn-delete').on('click', function () {
                let roleId = $(this).data('roleId');
                Swal.fire({
                    title: 'Delete Role',
                    text: 'Are you sure want to delete this role?',
                    type: 'question',
                    showCancelButton: true,
                }).then(result => {
                    if (result.value) {
                        let deleteUrl = "{{ route('dashboard.roles.destroy', ':id') }}";
                        deleteUrl = deleteUrl.replace(':id', roleId);

                        let deleteForm = $('#delete-form');
                        deleteForm.attr('action', deleteUrl)
                        deleteForm.submit();
                    }
                });
        });
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });
            $("#project-table").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#project-table_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush