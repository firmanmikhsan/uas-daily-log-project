@extends('layouts.admin.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Project</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.projects.index') }}">Project List</a></li>
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
                                Add new Project
                            </h3>
                        </div>
                    </div>
                    <form action="{{ route('dashboard.projects.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="projectName">Project Name</label>
                                <input type="text" name="name" id="projectName" class="form-control @error('name') is-invalid @enderror" placeholder="Project Name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="projectDescription">Project Description</label>
                                <textarea name="description" id="projectDescription" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror" placeholder="Project Description...">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="projectImage">Project Image</label>
                                <div class="text-left my-3">
                                    <img src="{{ Storage::url('images/default/placeholder.png') }}" alt="{{ Storage::url('images/default/placeholder.png') }}" class="img-fluid" style="max-height: 250px" id="project-image-preview">
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="projectImage" name="image">
                                        <label class="custom-file-label" for="projectImage">Choose file</label>
                                    </div>
                                </div>
                                @error('image')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- End of Main Content --}}
@endsection

@include('components.admin.image-uploader.image-upload-preview', [
    "uploader" => "projectImage",
    "previewer" => "project-image-preview"
])

@push('js')
    <script src="{{ asset('adminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush