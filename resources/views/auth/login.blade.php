@extends('adminlte::auth.login')
@section('content')
<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('vendor/adminlte/dist/img/LogoWebSite.png') }}" alt="Logo" height="115" width="128">
</div>
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
    0% { transform: rotate(0deg); }
    25% { transform: rotate(10deg); }
    50% { transform: rotate(0deg); }
    75% { transform: rotate(-10deg); }
    100% { transform: rotate(0deg); }
}
</style>
<script>
// Tùy chỉnh preloader  
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