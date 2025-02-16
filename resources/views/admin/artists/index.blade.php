@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <h1 class="mb-0">Quản lý Nghệ Sĩ</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('artists.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm Nghệ Sĩ
            </a>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <form action="{{ route('artists.index') }}" method="GET" id="searchForm">
                <div class="row">
                    <!-- Ô nhập từ khóa -->
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa..."
                                value="{{ request('keyword') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Tìm
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bộ lọc tìm kiếm -->
                    <div class="col-md-3">
                        <select name="search_by" class="form-control">
                            <option value="all" {{ request('search_by') == 'all' ? 'selected' : '' }}>Tất cả</option>
                            <option value="id" {{ request('search_by') == 'id' ? 'selected' : '' }}>ID</option>
                            <option value="name" {{ request('search_by') == 'name' ? 'selected' : '' }}>Tên nghệ sĩ</option>
                            <option value="bio" {{ request('search_by') == 'bio' ? 'selected' : '' }}>Tiểu sử</option>
                        </select>
                    </div>

                    <!-- Nút đặt lại -->
                    <div class="col-md-2">
                        <button type="button" class="btn btn-secondary btn-block" id="resetSearch">
                            <i class="fas fa-redo"></i> Đặt lại
                        </button>
                    </div>
                </div>

                <div class="row mt-2">
                    <!-- Bộ lọc số lượng hiển thị -->
                    <div class="col-md-3">
                        <select name="per_page" class="form-control">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 mục</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 mục</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 mục</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 mục</option>
                            <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Tất cả</option>
                        </select>
                    </div>

                    <!-- Bộ lọc sắp xếp -->
                    <div class="col-md-3">
                        <select name="sort_by" class="form-control">
                            <option value="id_desc" {{ request('sort_by') == 'id_desc' ? 'selected' : '' }}>ID (Mới nhất)</option>
                            <option value="id_asc" {{ request('sort_by') == 'id_asc' ? 'selected' : '' }}>ID (Cũ nhất)</option>
                            <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Tên (A-Z)</option>
                            <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Tên (Z-A)</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <table class="table table-bordered mt-2">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Tên nghệ sĩ</th>
                    <th>Tiểu sử</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($artists as $artist)
                <tr>
                    <td>{{ $artist->id }}</td>
                    <td>{{ $artist->name }}</td>
                    <td>{{ Str::limit($artist->bio, 100) }}</td>
                    <td>
                        <a href="{{ route('artists.edit', $artist->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('artists.destroy', $artist->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('vendor/adminlte/dist/img/LogoWebSite.png') }}" alt="Logo" height="115" width="128">
</div>

<style>
    /* CSS cho preloader giữ nguyên như cũ */
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
    // JavaScript giữ nguyên như cũ
    document.addEventListener('DOMContentLoaded', function() {
        const preloader = document.querySelector('.preloader');

        if (preloader) {
            preloader.style.display = 'flex';
            window.addEventListener('load', function() {
                preloader.style.display = 'none';
            });
        }
    });

    function confirmDelete(button) {
        if (confirm('Bạn có chắc chắn muốn xóa nghệ sĩ này không?')) {
            button.parentElement.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('resetSearch').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('input[name="keyword"]').value = '';
            document.querySelector('select[name="search_by"]').value = 'all';
            document.querySelector('select[name="per_page"]').value = '10';
            document.querySelector('select[name="sort_by"]').value = 'id_desc';
            document.getElementById('searchForm').submit();
        });

        document.querySelector('select[name="sort_by"]').addEventListener('change', function() {
            document.getElementById('searchForm').submit();
        });
    });
</script>
@endsection