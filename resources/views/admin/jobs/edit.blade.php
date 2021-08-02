@extends('layouts.admin.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Positions</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.positions.index') }}">Positions List</a></li>
                    <li class="breadcrumb-item">Edit Positions</li>
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
                                Edit positions
                            </h3>
                        </div>
                    </div>
                    <form action="{{ route('dashboard.positions.update', ['position' => $position->id]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="positionName">Position Name</label>
                                <input type="text" name="name" id="positionsName" class="form-control @error('name') is-invalid @enderror" placeholder="Positon name" value="{{ old('name', $position->name) }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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