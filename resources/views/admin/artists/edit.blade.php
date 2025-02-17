@extends('adminlte::page')

@section('title', 'Chỉnh Sửa Nghệ Sĩ')

@section('content_header')
<h1 class="m-0 text-dark">Chỉnh Sửa Nghệ Sĩ</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('artists.update', $artist->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Tên nghệ sĩ <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $artist->name) }}" placeholder="Nhập tên nghệ sĩ" required>
                                </div>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="bio">Tiểu sử</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-book"></i>
                                        </span>
                                    </div>
                                    <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" 
                                        rows="4" placeholder="Nhập tiểu sử nghệ sĩ">{{ old('bio', $artist->bio) }}</textarea>
                                </div>
                                @error('bio')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="avatar">Ảnh đại diện</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-image"></i>
                                        </span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="avatar" class="custom-file-input @error('avatar') is-invalid @enderror" id="avatar">
                                        <label class="custom-file-label" for="avatar">Chọn file</label>
                                    </div>
                                </div>
                                @error('avatar')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                
                                @if($artist->avatar)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $artist->avatar) }}" alt="Current avatar" class="img-thumbnail" style="max-height: 200px;">
                                    <p class="text-muted mt-1">Avatar hiện tại</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="float-right">
                                <a href="{{ route('artists.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('vendor/adminlte/dist/img/LogoWebSite.png') }}" alt="Logo" height="115" width="128">
</div>
@stop

@section('css')
<style>
    .card {
        margin-top: 20px;
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
    }

    .input-group-text {
        width: 40px;
        justify-content: center;
    }

    .img-thumbnail {
        object-fit: cover;
    }
    
    .custom-file-label {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Preloader styles */
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
        0% { transform: rotate(0deg); }
        25% { transform: rotate(10deg); }
        50% { transform: rotate(0deg); }
        75% { transform: rotate(-10deg); }
        100% { transform: rotate(0deg); }
    }
</style>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preloader
        const preloader = document.querySelector('.preloader');
        if (preloader) {
            preloader.style.display = 'flex';
            window.addEventListener('load', function() {
                preloader.style.display = 'none';
            });
        }

        // Xử lý hiển thị tên file khi chọn avatar
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;

            // Preview ảnh
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.img-thumbnail').src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@stop
