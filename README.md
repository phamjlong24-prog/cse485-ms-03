# MiniShop — Phiếu 03 (Buổi 3)

Bài tập môn Công nghệ Web — OOP MiniShop + Đăng nhập Session.

## Cấu trúc

- `src/Category.php` — class `Category` (properties `id`, `name`; method `label()`).
- `src/Product.php` — class `Product` (properties private `sku`, `name`,
  `categoryId`, `price`, `qty`; methods `lineTotal()`, `stockLevel()`,
  `toArray()`, và các getter).
- `data.php` — tạo `$categoryObjects` (3) và `$productObjects` (8) bằng `new`.
- `login.php` — form POST, kiểm tra `admin` / `MiniShop@03`, lưu Session.
- `dashboard.php` — chặn truy cập khi chưa đăng nhập (guard), in bảng 8
  sản phẩm bằng method (`$p->lineTotal()`, `$p->stockLevel()`), có form
  "đặt thử" lưu vào `$_SESSION['orders']`.
- `logout.php` — hủy session, quay về login.

## Tài khoản đăng nhập

- Username: `admin`
- Password: `MiniShop@03`

## Kết quả kiểm tra


|
 Tình huống 
|
 Kết quả 
|
|
---
|
---
|
|
 Vào dashboard.php lúc chưa login 
|
 Về login 
|
|
 Sai mật khẩu 
|
 Ở lại login + báo lỗi 
|
|
 Đúng 
|
 Dashboard: 8 SP, tổng 41380000 
|
|
 Thêm 2 order rồi F5 
|
 Danh sách order vẫn còn 
|
|
 Logout rồi vào dashboard 
|
 Bị chặn 
|

## Cách chạy

```bash
php -S localhost:8000
```

## Trả lời câu hỏi thuyết trình

**1. Hướng cấu trúc vs OOP khác nhau chỗ nào?**
Ở Phiếu 02, `lineTotal($p)` là hàm rời, phải tự nhớ truyền đúng `$p` (mảng)
vào mỗi lần gọi, dữ liệu và logic tách biệt nhau. Ở Phiếu 03,
`$p->lineTotal()` — logic tính toán "đi liền" với object, object tự biết
cách tính giá trị của chính nó, không cần truyền tham số ngoài vì dữ
liệu đã nằm sẵn trong property của object.

**2. Class và object khác nhau thế nào?**
`Product` là **class** — một khuôn mẫu định nghĩa Product có những
thuộc tính gì (sku, name, price...) và làm được những gì (lineTotal,
stockLevel...). Mỗi dòng `new Product(...)` trong `data.php` tạo ra
một **object** cụ thể — ví dụ object đại diện cho "Keychron K2" là một
thực thể độc lập, có dữ liệu riêng, khác với object đại diện cho
"Akko 3087".

**3. Vì sao dùng Session chứ không chỉ biến PHP thường?**
Biến PHP thường chỉ tồn tại trong đúng 1 lần chạy script rồi mất — mỗi
lần tải lại trang là một request mới, biến sẽ bị reset về rỗng. Session
lưu dữ liệu ở phía server, gắn với một định danh riêng cho từng trình
duyệt, nên dữ liệu (như trạng thái đăng nhập, danh sách order) vẫn giữ
được xuyên suốt nhiều lần tải trang khác nhau, cho tới khi logout hoặc
đóng session.
