# H? th?ng Qu?n lý Khóa h?c Tr?c tuy?n (LMS)

D? án website mua và h?c khóa h?c tr?c tuy?n du?c xây d?ng b?ng Laravel Framework, ph?c v? cho quá trình th?c t?p.

##  Tính nang chính

### 1. Phân quy?n ngu?i dùng (3 Vai trò)
- **Student (H?c viên):** Xem, tìm ki?m, l?c khóa h?c, mua khóa h?c thông qua gi? hàng, h?c tr?c tuy?n (video), dánh d?u hoàn thành bài h?c, dánh giá khóa h?c.
- **Instructor (Gi?ng viên):** Qu?n lý n?i dung khóa h?c và bài h?c du?c gán.
- **Admin (Qu?n tr? viên):** Dashboard th?ng kê, CRUD Danh m?c, Khóa h?c, Bài h?c, Ngu?i dùng và Ðon hàng.

### 2. Các ch?c nang tiêu bi?u
- **Xác th?c:** Ðang ký/Ðang nh?p b?ng Username. M?c d?nh Admin: dmin / 1234.
- **Thanh toán:** H? th?ng thanh toán gi? l?p, t? d?ng kích ho?t khóa h?c sau khi d?t hàng thành công.
- **H?c t?p:** Giao di?n bài h?c tích h?p video player, ti?n d? h?c t?p du?c luu tr? theo th?i gian th?c.
- **Ðánh giá:** Tính nang Rating/Review th?c t? t? nh?ng h?c viên dã s? h?u khóa h?c.
- **UI chuyên nghi?p:** Giao di?n hi?n d?i (Udemy Style) phát tri?n trên Bootstrap 5.

##  Công ngh? s? d?ng
- **Backend:** Laravel 12.x, PHP 8.2+
- **Database:** MySQL
- **Frontend:** Blade Template, Bootstrap 5, FontAwesome 6
- **Khác:** Eloquent ORM, Middleware, Laravel Auth, Database Seeder.

##  Hu?ng d?n cài d?t

1. **Clone d? án:**
   `ash
   git clone [url_du_an]
   cd khoahoc
   `

2. **Cài d?t thu vi?n:**
   `ash
   composer install
   `

3. **C?u hình môi tru?ng:**
   - T?o file .env t? .env.example.
   - C?u hình thông tin Database (DB_DATABASE=khoahoc, ...)
   - Chú ý c?u hình APP_URL d? kh?p v?i link XAMPP.

4. **Kh?i t?o d? li?u:**
   `ash
   php artisan key:generate
   php artisan migrate --seed
   `

5. **Ch?y ?ng d?ng:**
   - N?u dùng XAMPP: Truy c?p qua Virtual Host ho?c du?ng d?n thu m?c public.
   - Ho?c dùng l?nh: php artisan serve.

##  Thông tin tài kho?n Demo
- **Admin:** admin / m?t kh?u: 1234
- **T?t c? các tài kho?n m?c d?nh:** M?t kh?u là 1234.

---
*D? án du?c xây d?ng v?i m?c tiêu h?c t?p và th?c hành các ki?n th?c v? Laravel.*
