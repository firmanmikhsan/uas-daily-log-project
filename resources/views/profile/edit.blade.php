@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Profile</h3>
                    </div>
                    <div class="card-body">
                        <form enctype="multipart/form-data" action="{{ route('home.profiles.update', ["profile" => Auth::user()->id]) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="text-center my-3">
                                        <img src="{{ Auth::user()->profile->avatar ?? Storage::url('images/default/placeholder.png') }}" alt="{{ Auth::user()->profile->avatar ?? Storage::url('images/default/placeholder.png') }}" class="rounded-circle" height="150" width="150" id="avatar-image-preview">
                                    </div>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror" id="avatarImage" name="avatar">
                                            <label class="custom-file-label" for="avatarImage">Choose file</label>
                                        </div>
                                    </div>
                                    @error('avatar')
                                        <span class="text-danger small" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="fullName">Fullname</label>
                                    <input type="text" name="name" id="fullName" class="form-control @error('name') is-invalid @enderror" placeholder="User Name" value="{{ old('name', Auth::user()->name) }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jobPosition">Position</label>
                                    <input type="text" name="job_position" id="jobPosition" class="form-control @error('Position') is-invalid @enderror" placeholder="Position" value="{{ old('Position', Auth::user()->profile->position->name ?? "-") }}" readonly>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email', Auth::user()->email) }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="phoneNumber">Phone Number</label>
                                    <input type="text" name="phone_number" id="phoneNumber" class="form-control @error('phone_number') is-invalid @enderror" placeholder="+6289658806617" value="{{ old('phone_number', Auth::user()->profile->phone_number ?? "-") }}">
                                    @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="address">Alamat</label>
                                    <textarea name="address" id="address" cols="30" rows="5" class="form-control @error('address') is-invalid @enderror">{{ old('address', Auth::user()->profile->address ?? "-") }}</textarea>
                                    @error('address')
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
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('components.admin.image-uploader.image-upload-preview', [
    "uploader" => "avatarImage",
    "previewer" => "avatar-image-preview"
])