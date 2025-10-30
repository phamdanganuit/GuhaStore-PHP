# 🛍️ Guha Store - Hệ thống Quản lý Cửa hàng Nước hoa

Hệ thống quản lý và bán hàng trực tuyến chuyên về nước hoa, được xây dựng bằng PHP thuần và MySQL.

## 📋 Mục lục

- [Tính năng](#-tính-năng)
- [Công nghệ sử dụng](#-công-nghệ-sử-dụng)
- [Yêu cầu hệ thống](#-yêu-cầu-hệ-thống)
- [Cài đặt](#-cài-đặt)
- [Cấu hình](#-cấu-hình)
- [Sử dụng](#-sử-dụng)
- [Cấu trúc thư mục](#-cấu-trúc-thư-mục)
- [Screenshots](#-screenshots)
- [Đóng góp](#-đóng-góp)
- [License](#-license)

## ✨ Tính năng

### Phía Khách hàng
- 🏠 Trang chủ với banner và sản phẩm nổi bật
- 🔍 Tìm kiếm và lọc sản phẩm theo danh mục, thương hiệu, giá
- 🛒 Giỏ hàng và thanh toán trực tuyến
- 💳 Tích hợp thanh toán MoMo
- 👤 Đăng ký, đăng nhập tài khoản
- 📝 Quản lý thông tin cá nhân và lịch sử đơn hàng
- 📰 Xem bài viết blog về nước hoa
- 💬 Tích hợp Facebook Messenger Chat
- 📧 Nhận email xác nhận đơn hàng

### Phía Admin
- 📊 Dashboard với thống kê tổng quan
- 📦 Quản lý sản phẩm (thêm, sửa, xóa)
- 📂 Quản lý danh mục và thương hiệu
- 🏷️ Quản lý bộ sưu tập (collections)
- 👥 Quản lý khách hàng
- 📋 Quản lý đơn hàng và trạng thái
- 📝 Quản lý bài viết blog
- 📈 Thống kê doanh thu theo thời gian
- 📊 Xuất báo cáo Excel
- 📄 Xuất hóa đơn PDF
- 📧 Gửi email thông báo
- 🔐 Quản lý tài khoản admin
- 📦 Quản lý kho hàng (inventory)

## 🚀 Công nghệ sử dụng

### Backend
- **PHP** - Ngôn ngữ lập trình chính
- **MySQL** - Cơ sở dữ liệu
- **PHPMailer** - Gửi email
- **FPDF/TFPDF** - Tạo file PDF
- **PhpSpreadsheet** - Xuất/nhập file Excel
- **Carbon** - Xử lý ngày tháng

### Frontend
- **HTML5/CSS3** - Giao diện
- **JavaScript/jQuery** - Tương tác động
- **Bootstrap** - Framework CSS
- **Font Awesome & Ionicons** - Icons
- **Chart.js** - Biểu đồ thống kê
- **Google Fonts** - Typography

### Tích hợp
- **MoMo Payment Gateway** - Cổng thanh toán
- **Facebook Messenger** - Chat trực tiếp

## 💻 Yêu cầu hệ thống

- PHP >= 7.4
- MySQL >= 5.7 hoặc MariaDB >= 10.2
- Apache/Nginx Web Server
- Composer (cho việc quản lý dependencies)
- Kích hoạt các PHP extensions:
  - mysqli
  - gd
  - zip
  - xml
  - mbstring
  - curl

## 📦 Cài đặt

### 1. Clone repository

```bash
git clone https://github.com/yourusername/GuhaStore-PHP.git
cd GuhaStore-PHP
```

### 2. Cài đặt dependencies

```bash
composer install
```

### 3. Import database

- Tạo database mới tên `dbperfume_new` trong MySQL
- Import file `dbperfume.sql`:

```bash
mysql -u root -p dbperfume_new < dbperfume.sql
```

Hoặc sử dụng phpMyAdmin:
1. Mở phpMyAdmin
2. Tạo database mới: `dbperfume_new`
3. Import file `dbperfume.sql`

### 4. Cấu hình database

Mở file `admin/config/config.php` và cập nhật thông tin kết nối:

```php
$mysqli = new mysqli("localhost", "your_username", "your_password", "dbperfume_new");
```

### 5. Cấu hình web server

#### Apache
Đảm bảo file `.htaccess` đã được cấu hình đúng và `mod_rewrite` được bật.

#### Nginx
Cấu hình virtual host:

```nginx
server {
    listen 80;
    server_name guhastore.local;
    root /path/to/GuhaStore-PHP;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

### 6. Phân quyền thư mục

```bash
chmod -R 755 /path/to/GuhaStore-PHP
chmod -R 777 admin/modules/product/
chmod -R 777 admin/modules/blog/
chmod -R 777 admin/modules/category/
chmod -R 777 admin/modules/brand/
chmod -R 777 assets/images/
```

## ⚙️ Cấu hình

### Cấu hình MoMo Payment

Chỉnh sửa file `config_momo.json`:

```json
{
    "partnerCode": "YOUR_PARTNER_CODE",
    "accessKey": "YOUR_ACCESS_KEY",
    "secretKey": "YOUR_SECRET_KEY"
}
```

### Cấu hình Email (PHPMailer)

Mở file `mail/sendmail.php` và cập nhật thông tin SMTP:

```php
$mail->Host = 'smtp.gmail.com';
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-app-password';
$mail->Port = 587;
```

### Cấu hình Facebook Messenger

Trong file `index.php`, cập nhật Page ID:

```javascript
chatbox.setAttribute("page_id", "YOUR_FACEBOOK_PAGE_ID");
```

## 📖 Sử dụng

### Truy cập ứng dụng

- **Website khách hàng**: `http://localhost/GuhaStore-PHP/`
- **Admin Panel**: `http://localhost/GuhaStore-PHP/admin/`

### Đăng nhập Admin

Tài khoản mặc định (kiểm tra trong database bảng `account`):
- Username: `admin`
- Password: (xem trong database)

**⚠️ Lưu ý**: Nên thay đổi mật khẩu mặc định sau khi đăng nhập lần đầu.

## 📁 Cấu trúc thư mục

```
GuhaStore-PHP/
├── admin/                    # Quản trị viên
│   ├── config/              # Cấu hình database
│   ├── css/                 # CSS cho admin
│   ├── js/                  # JavaScript cho admin
│   ├── modules/             # Các module chức năng
│   │   ├── account/         # Quản lý tài khoản
│   │   ├── blog/            # Quản lý blog
│   │   ├── brand/           # Quản lý thương hiệu
│   │   ├── category/        # Quản lý danh mục
│   │   ├── collection/      # Quản lý bộ sưu tập
│   │   ├── customer/        # Quản lý khách hàng
│   │   ├── inventory/       # Quản lý kho
│   │   ├── order/           # Quản lý đơn hàng
│   │   └── product/         # Quản lý sản phẩm
│   └── index.php            # Điểm vào admin
│
├── assets/                  # Tài nguyên frontend
│   ├── css/                 # Stylesheets
│   ├── images/              # Hình ảnh
│   └── js/                  # JavaScript
│
├── pages/                   # Các trang khách hàng
│   ├── base/                # Components cơ bản
│   ├── handle/              # Xử lý logic
│   └── main/                # Trang chính
│
├── mail/                    # Email service
│   └── PHPMailer/           # Thư viện PHPMailer
│
├── fpdf/                    # Thư viện tạo PDF
├── tfpdf/                   # Thư viện PDF hỗ trợ Unicode
├── carbon/                  # Thư viện xử lý thời gian
├── vendor/                  # Composer dependencies
│
├── dbperfume.sql           # File database
├── composer.json           # Composer config
├── config_momo.json        # Cấu hình MoMo
└── index.php               # Điểm vào chính

```

## 🎨 Screenshots

### Trang chủ
_Giao diện trang chủ với banner và sản phẩm nổi bật_

### Admin Dashboard
_Bảng điều khiển quản trị với thống kê tổng quan_

### Quản lý sản phẩm
_Giao diện quản lý sản phẩm với đầy đủ chức năng CRUD_

### Trang thanh toán
_Giao diện thanh toán với tích hợp MoMo_

## 🔐 Bảo mật

- Mật khẩu nên được mã hóa bằng `password_hash()` trong PHP
- Sử dụng prepared statements để tránh SQL injection
- Validate và sanitize tất cả input từ người dùng
- Giới hạn quyền truy cập file upload
- Sử dụng HTTPS trong môi trường production
- Cấu hình CORS phù hợp

## 🚧 Roadmap

- [ ] Thêm tính năng đánh giá sản phẩm
- [ ] Tích hợp thêm cổng thanh toán (VNPay, ZaloPay)
- [ ] Thêm hệ thống mã giảm giá và khuyến mãi
- [ ] Responsive design tốt hơn cho mobile
- [ ] Tích hợp PWA
- [ ] API RESTful
- [ ] Thêm tính năng wishlist
- [ ] Notification system realtime
- [ ] Multi-language support

## 🤝 Đóng góp

Mọi đóng góp đều được chào đón! Vui lòng:

1. Fork repository
2. Tạo branch mới (`git checkout -b feature/AmazingFeature`)
3. Commit thay đổi (`git commit -m 'Add some AmazingFeature'`)
4. Push lên branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

## 📝 Changelog

### Version 1.0.0 (Current)
- Phát hành phiên bản đầu tiên
- Đầy đủ chức năng quản lý cửa hàng
- Tích hợp thanh toán MoMo
- Hệ thống blog

## 👤 Tác giả

**DangAN**
- GitHub: [@phamdanganuit](https://github.com/phamdanganuit)

## 📄 License

Dự án này được phân phối dưới giấy phép MIT. Xem file `LICENSE` để biết thêm chi tiết.

## 🙏 Acknowledgments

- Bootstrap cho framework CSS
- Font Awesome và Ionicons cho icons
- PHPMailer cho email service
- FPDF cho PDF generation
- PhpSpreadsheet cho Excel handling
- Tất cả các thư viện và công cụ open source khác


---

⭐ Nếu bạn thấy dự án này hữu ích, hãy cho một star nhé! ⭐

