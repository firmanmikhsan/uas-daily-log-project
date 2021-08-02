@push('css')
    <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css') }}">
@endpush

<div class="row">
    <div class="col-md-12">
      <!-- The time line -->
      <div class="timeline">
        <!-- timeline time label -->
        <div class="time-label">
          <span class="bg-success">{{ $project_name }}</span>
        </div>
        <!-- /.timeline-label -->
        <!-- timeline item -->
        {{ $slot }}
        <!-- END timeline item -->
        <div>
          <i class="fas fa-clock bg-gray"></i>
        </div>
      </div>
    </div>
    <!-- /.col -->
  </div>