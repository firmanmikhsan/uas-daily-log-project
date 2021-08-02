@extends('layouts.admin.app')

@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@php
    $projectIds = $projects->pluck('id');
    $userprojectIds = $assigned_projects->projects->pluck('id');
@endphp

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Assign Project</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.assignments.index') }}">Assignment List</a></li>
                    <li class="breadcrumb-item">Assign Project</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center">
                            <h3 class="card-title">
                                Assign Project
                            </h3>
                        </div>
                    </div>
                    <form action="{{ route('dashboard.assignments.update', ['assignment' => $assigned_projects->id]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="userName">User name</label>
                                <input type="text" name="name" id="userName" class="form-control @error('name') is-invalid @enderror" placeholder="Positon name" value="{{ old('name', $assigned_projects->name) }}" readonly>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                            <div class="form-group">
                                <label>Assign projects</label>
                                <select class="projects @error('project_ids') is-invalid @enderror" multiple="multiple" data-placeholder="Select projects" style="width: 100%;" name="project_ids[]" id="project_ids">
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}" {{ in_array($project->id, old('project_ids', $userprojectIds->toArray())) ? 'selected="selected"' : '' }}>{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                @error('project_ids')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="select_all_project" name="select_all_project" {{ old('select_all_project') == 'on' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="select_all_project">Select All</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Position</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
    <script src="{{ asset('adminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
    <!-- Select2 -->
    <script src="{{ asset('adminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function(){
            $('.projects').select2({
                theme: 'bootstrap4'
            })

            $('#project_ids').on('change', function () {
                if ($('#project_ids').find('option:selected').length == "{{ $projectIds->count() }}") {
                    console.log('asd');
                    $('#select_all_project').prop('checked', true);
                } else {
                    $('#select_all_project').prop('checked', false);
                }
            });

            $('#select_all_project').on('click', function () {
                if ($(this).is(':checked')) {
                    $('#project_ids').val({{ $projectIds }}).trigger('change');
                } else {
                    $('#project_ids').val(null).trigger('change');
                }
            })
        })
    </script>
@endpush