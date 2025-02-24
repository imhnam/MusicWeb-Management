Tên Dự Án: Hệ Thống Quản Lý Nhạc
Được Phát Triển Bởi:
Trịnh Hoài Nam
Mô Tả Ứng Dụng
Hệ thống quản lý nhạc là một ứng dụng web giúp quản lý người dùng, nghệ sĩ, bài hát, thể loại, danh sách phát một cách hiệu quả. Ứng dụng cung cấp các chức năng CRUD, tìm kiếm, sắp xếp cho các đối tượng.
Mục Đích
Quản lý thông tin người dùng, nghệ sĩ
Quản lý thông tin bài hát
Quản lý thông tin thể loại, danh sách phát
Cung cấp giao diện người dùng dễ sử dụng
Hiển thị dữ liệu hiệu quả thông qua DataTables
Công Nghệ
Dự án sử dụng các công nghệ sau:

Laravel Framework (cập nhật lên phiên bản mới nhất)
PHP 8.x
MySQL - Aiven
DataTables với jQuery
AdminLTE 3.x (giao diện admin)
HTML, CSS, JavaScript
Laravel Repository Pattern
Laravel Service Pattern
Laravel Events & Listeners
Quá Trình Phát Triển Phần Mềm
Sơ Đồ Khối (UML) - Cấu trúc Database

![Untitled diagram-2025-02-24-085155](https://github.com/user-attachments/assets/400b2703-192c-4873-9bbd-6d5e2f4d6b6b)
Sơ Đồ Chức Năng (Sơ Đồ Thuật Toán)
A[Người dùng truy cập hệ thống] --> B[Chọn module quản lý] B --> C{Chọn chức năng} C --> D[Thực hiện CRUD] C --> E[Xem danh sách] C --> F[Tìm kiếm] C --> G[Sắp xếp]
Chu Trình Phát Triển
Phases:
Analysis: Phân tích yêu cầu và thiết kế database
Design: Áp dụng các design patterns (Repository, Service)
Implementation: Viết code theo các patterns đã thiết kế
Testing: Unit tests, Feature tests
Deployment: CI/CD pipeline
Deployment
Cài đặt môi trường

composer create-project laravel/laravel music-management cd music-management

Tạo database

CREATE DATABASE defaultdb;

Configure .env

DB_CONNECTION=mysql DB_HOST=127.0.0.1 DB_PORT=19017 DB_DATABASE=defaultdb DB_USERNAME=avnadmin DB_PASSWORD=

Install dependencies

composer require jeroennoten/laravel-adminlte
composer require laravel/ui

Run migrations

php artisan key:generate
php artisan migrate php artisan db:seed

Deploy to server

php artisan serve

Lưu ý về cải tiến cấu trúc
Áp dụng Repository Pattern giúp tách biệt logic truy cập dữ liệu từ controllers
Service Layer chứa business logic, giúp code dễ test và bảo trì
Request Validation giúp tách biệt logic validation
API Resources chuẩn hóa dữ liệu trả về
Events & Listeners xử lý các tác vụ phụ không đồng bộ
