@extends('layouts.app')

@push('css')
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/summernote/summernote-bs4.min.css') }}">
@endpush

@section('content')
<div class="container my-3">
    <div class="col-12">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <form action="{{ route('home.reports.store') }}" method="post">
                        <div class="card-header">
                            <h3 class="card-title">
                                Form Reporting
                            </h3>
                        </div>
                        <div class="card-body">
                            @csrf
                            <div class="form-group">
                                <select name="project_id" id="project_id" class="form-control @error('project_id') is-invalid @enderror">
                                    <option value="">Pilih Project</option>
                                    @foreach ($projects as $project)
                                        <option {{ old('project_id') == $project->id ? "selected" : "" }} value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="work_hours" class="form-label">Jumlah waktu pengerjaan</label>
                                <input type="number" class="form-control @error('hours') is-invalid @enderror" name="hours" value="{{ old('hours', 1) }}" min="1" max="12">
                                @error('hours')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <textarea id="summernote" name="report" cols="30" rows="10" class="form-control @error('report') is-invalid @enderror" placeholder="Hari ini saya mengerjakan...">{{ old('report') }}</textarea>
                                @error('report')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center">
                            <h3 class="card-title">Profile</h3>
                            <a href="{{ route('home.profiles.edit', ["profile" => Auth::user()->id]) }}"><i class="fas fa-pencil-alt"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ Auth::user()->profile->avatar ?? Storage::url('images/default/placeholder.png') }}" alt="{{ Auth::user()->profile->avatar ?? Storage::url('images/default/placeholder.png') }}" class="rounded-circle" height="100" width="100">
                        </div>
                        <div class="form-group">
                            <label for="full_name" class="form-label">Fullname</label>
                            <p>{{ Auth::user()->name }}</p>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <p>{{ Auth::user()->email }}</p>
                        </div>
                        <div class="form-group">
                            <label for="position" class="form-label">Posisi</label>
                            <p>{{ Auth::user()->profile->position->name ?? "-" }}</p>
                        </div>
                        <div class="form-group">
                            <label for="phone_number" class="form-label">No. Telpon</label>
                            <p>{{ Auth::user()->profile->phone_number ?? "-" }}</p>
                        </div>
                        <div class="form-group">
                            <label for="address" class="form-label">Alamat</label>
                            <p>{{ Auth::user()->profile->address ?? "-" }}</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="btn btn-danger" type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Timeline kerja anda hari ini</h3>
            </div>
            <div class="card-body">
                @foreach ($user_timelines as $key => $user_timeline)
                    @component('components.timelines.timeline', [
                        "project_name" => $key,
                    ])
                    @foreach ($user_timeline as $timeline)
                        @include('components.timelines.timeline-item', [
                            "icon" => "fas fa-briefcase",
                            "time" => $timeline->report_time,
                            "hours" => $timeline->hours,
                            "description" => $timeline->description,
                        ])  
                    @endforeach
                    @endcomponent
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    @if (session('time_limit'))
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function () {
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: "{{ session('time_limit') }}",
                })
            });
        </script>
    @endif
    @if (session('status'))
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Yeah',
                    text: "{{ session('status') }}",
                })
            });
        </script>
    @endif
    <!-- Summernote -->
    <script src="{{ asset('adminLTE/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(function () {
          // Summernote
          $('#summernote').summernote({
              height: 300,
              placeholder: 'Hari ini saya mengerjakan ...',
              tabSize: 2
          });
        })
    </script>
@endpush
