## thanh toán trực tuyến

    - tạo qr thanh toán VietQR
        - payos, sepay
        * Mất phí: ít

    - momo, vnpay
        - phải có giấy phép kinh doanh, đa phần chỉ hỗ trợ doanh nghiệp
        * Cũng mất phí

## lấy danh sách tỉnh thành

    - https://addresskit.cas.so/ hoặc https://provinces.open-api.vn/

## đăng nhập oauth2 (google, facebook)

    - socialite

## login

    - Breeze or Jetstream

## router path

| Tác vụ                      | Phương thức | URL Path                   |
| --------------------------- | ----------- | -------------------------- |
| Xem giỏ hàng                | GET         | `/cart`                    |
| Thêm vào giỏ hàng           | POST        | `/cart/items`              |
| Cập nhật số lượng           | PUT         | `/cart/items/{item_id}`    |
| Xóa sản phẩm khỏi giỏ       | DELETE      | `/cart/items/{item_id}`    |
| Bắt đầu checkout            | GET         | `/checkout`                |
| Chọn địa chỉ giao hàng      | POST        | `/checkout/address`        |
| Chọn phương thức thanh toán | POST        | `/checkout/payment-method` |
| Đặt hàng                    | POST        | `/orders`                  |
| Xem đơn đã đặt              | GET         | `/orders`                  |
| Xem chi tiết đơn hàng       | GET         | `/orders/{order_id}`       |
| Thanh toán VNPay            | POST        | `/payment/vnpay/redirect`  |
| Callback thanh toán         | GET         | `/payment/vnpay/callback`  |

## theme

https://www.portotheme.com/html/porto_ecommerce/
https://www.portotheme.com/html/porto_ecommerce/demo4.html
