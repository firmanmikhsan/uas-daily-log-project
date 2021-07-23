@extends('layouts.admin.app')

@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@php
    $roleNames = $roles->pluck('name');
@endphp

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.users.index') }}">User List</a></li>
                    <li class="breadcrumb-item">Add Project</li>
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
                                Add new User
                            </h3>
                        </div>
                    </div>
                    <form action="{{ route('dashboard.users.store') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="fullName">Fullname</label>
                                <input type="text" name="name" id="fullName" class="form-control @error('name') is-invalid @enderror" placeholder="User Name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" value="{{ old('password') }}">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password Confirmation</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Password Confirmation" value="{{ old('password_confirmation') }}">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>User Role</label>
                                <select class="roles @error('role_names') is-invalid @enderror" multiple="multiple" data-placeholder="Select roles" style="width: 100%;" name="role_names[]" id="role_names">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ in_array($role->name, old('role_names', [])) ? 'selected="selected"' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_names')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="sellect_all_roles" name="sellect_all_roles" {{ old('sellect_all_roles') == 'on' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="sellect_all_roles">Select All</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add User</button>
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

            $('#role_names').on('change', function () {
                if ($('#role_names').find('option:selected').length == "{{ $roleNames->count() }}") {
                    $('#sellect_all_roles').prop('checked', true);
                } else {
                    $('#sellect_all_roles').prop('checked', false);
                }
            });

            $('#sellect_all_roles').on('click', function () {
                if ($(this).is(':checked')) {
                    $('#role_names').val({!! $roleNames !!}).trigger('change');
                } else {
                    $('#role_names').val(null).trigger('change');
                }
            })
        })
    </script>
@endpush