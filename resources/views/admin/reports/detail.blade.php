@extends('layouts.admin.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.reports.index') }}">User Report List</a></li>
                    <li class="breadcrumb-item active">User Report</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <section class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User report timelines</h3>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <h2 class="">User Information</h2>
                            <div class="form-group">
                                <p for="username" class="my-2">Username: {{ $user->name }}</p>
                                <p for="position" class="my-2">Position: {{ $user->profile->position->name }}</p>
                                <p for="position" class="my-2">Total Reports: {{ $user->reports_count }}</p>
                                <p for="position" class="my-2">Total Work Hours: {{ $user->reports_sum_hours }}</p>
                            </div>
                        </div>
                        <hr>
                        <h2 class="">User Timelines</h2>
                        @foreach ($user_timelines as $key => $user_timeline)
                            @component('components.timelines.timeline', [
                                "project_name" => $key." - ".$user_timeline->sum('hours')." Hours",
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
    </section>
</section>
@endsection