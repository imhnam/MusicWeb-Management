@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thêm Người Dùng</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" id="createUserForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Tên:</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Mật khẩu:</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Xác nhận mật khẩu:</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                    <div id="passwordMatch" class="invalid-feedback" style="display: none;">
                                        Mật khẩu xác nhận không khớp
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="role">Vai trò:</label>
                            <select name="role" class="form-control" required>
                                <option value="">Chọn vai trò</option>
                                @foreach($roles as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Trường upload avatar -->
                        <div class="form-group">
                            <label for="avatar">Ảnh đại diện:</label>
                            <input type="file" name="avatar" class="form-control-file">
                        </div>

                        <button type="submit" class="btn btn-success">Thêm</button>
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
        const form = document.getElementById('createUserForm');
        const password = form.querySelector('input[name="password"]');
        const passwordConfirm = form.querySelector('input[name="password_confirmation"]');
        const passwordMatch = document.getElementById('passwordMatch');

        function checkPasswordMatch() {
            if (password.value !== passwordConfirm.value) {
                passwordMatch.style.display = 'block';
                passwordConfirm.classList.add('is-invalid');
            } else {
                passwordMatch.style.display = 'none';
                passwordConfirm.classList.remove('is-invalid');
            }
        }

        password.addEventListener('input', checkPasswordMatch);
        passwordConfirm.addEventListener('input', checkPasswordMatch);

        form.addEventListener('submit', function(e) {
            if (password.value !== passwordConfirm.value) {
                e.preventDefault();
                alert('Vui lòng kiểm tra lại mật khẩu!');
            }
        });
    });

    //Preloader
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