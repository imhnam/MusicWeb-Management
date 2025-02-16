@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thêm Nghệ Sĩ Mới</h3>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('artists.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="name">Tên Nghệ Sĩ <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bio">Tiểu Sử</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                id="bio"
                                name="bio"
                                rows="5">{{ old('bio') }}</textarea>
                            @error('bio')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Trường Upload Ảnh -->
                        <div class="form-group">
                            <label for="avatar">Avatar</label>
                            <input type="file" class="form-control-file @error('avatar') is-invalid @enderror"
                                id="avatar" name="avatar" accept="image/*" onchange="previewImage(event)">
                            @error('avatar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <!-- Hiển thị ảnh xem trước -->
                            <div class="mt-3">
                                <img id="avatar-preview" src="#" alt="Xem trước ảnh" style="max-width: 200px; display: none;">
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu
                            </button>
                            <a href="{{ route('artists.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('vendor/adminlte/dist/img/LogoWebSite.png') }}" alt="Logo" height="115" width="128">
</div>

<style>
    .preloader {
        display: flex;
        background-color: #f4f6f9;
        height: 100vh;
        width: 100%;
        transition: height 200ms linear;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .dark-mode .preloader {
        background-color: #454d55 !important;
        color: #fff;
    }

    .preloader img {
        animation: shake 0.5s infinite;
    }

    @keyframes shake {
        0% {
            transform: rotate(0deg);
        }

        25% {
            transform: rotate(10deg);
        }

        50% {
            transform: rotate(0deg);
        }

        75% {
            transform: rotate(-10deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const preloader = document.querySelector('.preloader');

        if (preloader) {
            preloader.style.display = 'flex';
            window.addEventListener('load', function() {
                preloader.style.display = 'none';
            });
        }
    });


    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('avatar-preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection