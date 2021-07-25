@extends('layouts.admin.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Permission</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.permissions.index') }}">Permission List</a></li>
                    <li class="breadcrumb-item">Add Permission</li>
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
                                Add new permission
                            </h3>
                        </div>
                    </div>
                    <form action="{{ route('dashboard.permissions.store') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="permissionName">Permission Name</label>
                                <input type="text" name="name" id="permissionName" class="form-control @error('name') is-invalid @enderror" placeholder="Permission Name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add Permission</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- End of Main Content --}}
@endsection