@extends('layouts.admin.app')

@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@php
    $permissionNames = $permissions->pluck('name');
@endphp

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Role</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.roles.index') }}">Role List</a></li>
                    <li class="breadcrumb-item">Add Role</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center">
                            <h3 class="card-title">
                                Add new role
                            </h3>
                        </div>
                    </div>
                    <form action="{{ route('dashboard.roles.store') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="roleName">Role Name</label>
                                <input type="text" name="name" id="roleName" class="form-control @error('name') is-invalid @enderror" placeholder="Role Name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Role Permissions</label>
                                <select class="roles @error('role_permissions') is-invalid @enderror" multiple="multiple" data-placeholder="Select permissions" style="width: 100%;" name="role_permissions[]" id="role_permissions">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}" {{ in_array($permission->name, old('role_permissions', [])) ? 'selected="selected"' : '' }}>{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_permissions')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="select_all_permissions" name="select_all_permissions" {{ old('select_all_permissions') == 'on' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="select_all_permissions">Select All</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- End of Main Content --}}
@endsection

@push('js')
    <!-- Select2 -->
    <script src="{{ asset('adminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function(){
            $('.roles').select2({
                theme: 'bootstrap4'
            })

            $('#role_permissions').on('change', function () {
                if ($('#role_permissions').find('option:selected').length == "{{ $permissionNames->count() }}") {
                    $('#select_all_permissions').prop('checked', true);
                } else {
                    $('#select_all_permissions').prop('checked', false);
                }
            });

            $('#select_all_permissions').on('click', function () {
                if ($(this).is(':checked')) {
                    $('#role_permissions').val({!! $permissionNames !!}).trigger('change');
                } else {
                    $('#role_permissions').val(null).trigger('change');
                }
            })
        })
    </script>
@endpush