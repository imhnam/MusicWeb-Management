@extends('adminlte::page')

@section('title', 'Chỉnh sửa Bài Hát')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Chỉnh sửa Bài Hát</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('songs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('songs.update', $song->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Tên bài hát</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $song->title) }}" required>
                </div>

                <div class="form-group">
                    <label for="artist_id">Nghệ sĩ</label>
                    <select name="artist_id" class="form-control" required>
                        @foreach ($artists as $artist)
                            <option value="{{ $artist->id }}" {{ $artist->id == $song->artist_id ? 'selected' : '' }}>
                                {{ $artist->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="genre_id">Thể loại</label>
                    <select name="genre_id" class="form-control" required>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}" {{ $genre->id == $song->genre_id ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="file_url">URL Bài Hát</label>
                    <input type="url" name="file_url" class="form-control" value="{{ old('file_url', $song->file_url) }}" required>
                </div>

                <div class="form-group">
                    <label for="duration">Thời lượng (giây)</label>
                    <input type="number" name="duration" class="form-control" value="{{ old('duration', $song->duration) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('vendor/adminlte/dist/img/LogoWebSite.png') }}" alt="Logo" height="115" width="128">
</div>
@endsection

@section('css')
<style>
    /* Tùy chỉnh preloader */
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
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const preloader = document.querySelector('.preloader');

        if (preloader) {
            // Hiển thị preloader khi trang bắt đầu tải
            preloader.style.display = 'flex';

            // Ẩn preloader khi trang tải xong
            window.addEventListener('load', function() {
                preloader.style.display = 'none';
            });
        }
    });
</script>
@endsection
