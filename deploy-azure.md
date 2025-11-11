# Hướng dẫn Deploy GuhaStore lên Azure (Student)

## 📋 YÊU CẦU

- Tài khoản Azure for Students (đã kích hoạt)
- MySQL Client/Workbench hoặc command line
- Azure CLI (tùy chọn)
- Git (để deploy code)

## 🗄️ BƯỚC 1: THIẾT LẬP DATABASE

### 1.1. Tạo Azure Database for MySQL Flexible Server

1. Vào [Azure Portal](https://portal.azure.com)
2. **Create a resource** → **Azure Database for MySQL Flexible Server**
3. Cấu hình:
   - **Subscription**: Azure for Students
   - **Resource Group**: `guhastore-rg` (tạo mới)
   - **Server name**: `guhastore-db-server` (phải unique)
   - **Region**: Southeast Asia
   - **MySQL version**: 8.0
   - **Workload type**: Development
   - **Compute + Storage**: Burstable, B1ms (1 vCore, 2GB RAM)
   - **Admin username**: `guhaadmin`
   - **Password**: [Tạo password mạnh và LƯU LẠI]

4. **Networking**:
   - Public access
   - ✅ Allow public access from any Azure service
   - ✅ Add current client IP address

5. Click **Review + Create** → **Create**

### 1.2. Cấu hình Firewall

Sau khi tạo xong, vào resource:
1. **Networking** → **Firewall rules**
2. Add rule để cho phép IP của bạn kết nối
3. Tạm thời có thể add: `0.0.0.0` - `255.255.255.255` (CHỈ ĐỂ IMPORT - sau phải xóa)

### 1.3. Import Database

**Lấy thông tin kết nối:**
- Server: `guhastore-db-server.mysql.database.azure.com`
- Username: `guhaadmin`
- Password: [password bạn đã tạo]
- Port: 3306

**Tạo database:**
```bash
# Dùng MySQL command line hoặc MySQL Workbench
mysql -h guhastore-db-server.mysql.database.azure.com -u guhaadmin -p

# Sau khi đăng nhập:
CREATE DATABASE dbperfume_new CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

**Import file SQL:**
```bash
mysql -h guhastore-db-server.mysql.database.azure.com -u guhaadmin -p dbperfume_new < dbperfume.sql
```

**Hoặc dùng MySQL Workbench:**
1. New Connection với thông tin trên
2. Test Connection
3. Server → Data Import → Import from Self-Contained File
4. Chọn file `dbperfume.sql`
5. Start Import

## 🌐 BƯỚC 2: DEPLOY WEB APP

### 2.1. Tạo Azure Web App

1. **Create a resource** → **Web App**
2. Cấu hình:
   - **Resource Group**: `guhastore-rg` (chọn cái đã tạo)
   - **Name**: `guhastore-app` (phải unique, sẽ là: guhastore-app.azurewebsites.net)
   - **Publish**: Code
   - **Runtime stack**: PHP 8.2
   - **Operating System**: Linux
   - **Region**: Southeast Asia
   
3. **App Service Plan**:
   - **Pricing plan**: Free F1 (đủ để test) hoặc Basic B1 (tốt hơn)
   - Với Student credit, khuyên dùng B1 (khoảng $13/tháng)

4. Click **Review + Create** → **Create**

### 2.2. Cấu hình Environment Variables

Sau khi tạo xong Web App:
1. Vào Web App resource
2. **Configuration** → **Application settings**
3. Add các biến môi trường:

```
DB_HOST = guhastore-db-server.mysql.database.azure.com
DB_USER = guhaadmin
DB_PASS = [password của bạn]
DB_NAME = dbperfume_new
```

4. Click **Save** (phía trên)

### 2.3. Deploy Code

**Phương án 1: Dùng Git Deploy (Khuyên dùng)**

1. Trong Web App → **Deployment Center**
2. Chọn **Source**: Local Git
3. Click **Save**
4. Lấy Git URL và Deployment credentials

5. Trong PowerShell (tại thư mục dự án):

```powershell
# Init git nếu chưa có
git init
git add .
git commit -m "Initial commit for Azure deployment"

# Add Azure remote
git remote add azure https://guhastore-app.scm.azurewebsites.net:443/guhastore-app.git

# Push to Azure
git push azure main
# Nhập username/password khi được hỏi
```

**Phương án 2: Dùng FTP**

1. Trong Web App → **Deployment Center**
2. Chọn FTPS credentials
3. Lấy FTP hostname, username, password
4. Dùng FileZilla hoặc WinSCP upload toàn bộ file vào `/site/wwwroot/`

**Phương án 3: Dùng VS Code (Dễ nhất)**

1. Install extension: **Azure App Service**
2. Đăng nhập Azure trong VS Code
3. Right-click thư mục dự án → **Deploy to Web App**
4. Chọn subscription và web app
5. Confirm deploy

### 2.4. Cấu hình PHP và Extensions

1. Trong Web App → **Configuration** → **General settings**
2. **Startup Command**: (để trống)
3. **Stack settings**: PHP 8.2

4. Nếu cần extensions (mysqli, mbstring,...):
   - Vào **SSH** hoặc **Console**
   - Chạy: `apk add php82-mysqli php82-mbstring php82-pdo_mysql`

### 2.5. Cấu hình Web Server

Tạo file `.htaccess` trong root (nếu chưa có):

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Security headers
Header set X-Content-Type-Options "nosniff"
Header set X-Frame-Options "SAMEORIGIN"
```

Hoặc tạo file `web.config` cho IIS (nếu dùng Windows):

```xml
<?xml version="1.0" encoding="UTF-8"?>
<configuration>
  <system.webServer>
    <rewrite>
      <rules>
        <rule name="Main Rule" stopProcessing="true">
          <match url=".*" />
          <conditions logicalGrouping="MatchAll">
            <add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
            <add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" />
          </conditions>
          <action type="Rewrite" url="index.php" />
        </rule>
      </rules>
    </rewrite>
  </system.webServer>
</configuration>
```

## 🔧 BƯỚC 3: KIỂM TRA VÀ TỐI ƯU

### 3.1. Kiểm tra kết nối DB

Truy cập: `https://guhastore-app.azurewebsites.net`

Nếu lỗi, kiểm tra logs:
- Web App → **Log stream**
- Hoặc **Advanced Tools (Kudu)** → Debug console

### 3.2. Bảo mật Database

1. Vào MySQL Server → **Networking**
2. **XÓA** rule `0.0.0.0 - 255.255.255.255`
3. Chỉ giữ rule cho Azure services
4. Add rule cho IP cá nhân nếu cần quản trị từ xa

### 3.3. Tối ưu chi phí

**Để tiết kiệm Student Credit:**

1. **Stop resources khi không dùng:**
   - Database: Có thể stop tạm thời
   - Web App: Free tier luôn chạy, B1 có thể stop

2. **Giám sát chi phí:**
   - Azure Portal → **Cost Management + Billing**
   - Set up **Budget alerts**

3. **Chọn tier phù hợp:**
   - **Free F1**: $0 - giới hạn 60 min CPU/day, 1GB RAM
   - **Basic B1**: ~$13/month - 1 core, 1.75GB RAM, không giới hạn
   - **Database B1ms**: ~$25/month

## 📝 BƯỚC 4: CẬP NHẬT CODE

Khi cần update code:

**Nếu dùng Git:**
```powershell
git add .
git commit -m "Update features"
git push azure main
```

**Nếu dùng VS Code:**
- Right-click → Deploy to Web App → Confirm

**Nếu dùng FTP:**
- Upload file thay đổi qua FileZilla/WinSCP

## 🔍 TROUBLESHOOTING

### Lỗi kết nối Database
- Kiểm tra firewall rules
- Kiểm tra environment variables
- Test connection từ SSH/Console của Web App

### Website hiển thị lỗi 500
- Xem logs tại **Log stream**
- Kiểm tra file permissions
- Kiểm tra PHP version compatibility

### Lỗi SSL/TLS với MySQL
Thêm vào connection string:
```php
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name, 3306);
$mysqli->ssl_set(NULL, NULL, NULL, NULL, NULL);
```

## 🎯 CHECKLIST HOÀN THÀNH

- [ ] Tạo MySQL Server trên Azure
- [ ] Import database thành công
- [ ] Cấu hình firewall cho DB
- [ ] Tạo Web App
- [ ] Cấu hình environment variables
- [ ] Deploy code lên Web App
- [ ] Test website hoạt động
- [ ] Bảo mật database (xóa rule 0.0.0.0)
- [ ] Setup budget alerts
- [ ] Backup database định kỳ

## 📞 HỖ TRỢ

- [Azure Documentation](https://docs.microsoft.com/azure)
- [Azure Student Portal](https://portal.azure.com/#blade/Microsoft_Azure_Education/EducationMenuBlade/overview)
- [MySQL on Azure Guide](https://docs.microsoft.com/azure/mysql/)

---
**Lưu ý**: Với Student credit $100, bạn có thể chạy dự án này khoảng 2-3 tháng với cấu hình vừa phải.
