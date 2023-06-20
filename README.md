#SERI API FOOD


## Câu lệnh
`
    php artisan make:resource CategoryResource => Tạo Resource
    php artisan make:resource CategoryCollection => Tạo Collection
`

## Mã lỗi
`
    200 : OK. The standard success code and default option.
    201 : Created. Object created. Useful for the store actions.
    204 : No Content. When the action was executed successfully, but there is no content to return.
    206 : Partial Content. Useful when you have to return a paginated list of resources.
    400 : Bad Request. The standard option for requests that cannot pass validation.
    401 : Unauthorized. The user needs to be authenticated.
    403 : Forbidden. The user is authenticated but does not have the permissions to perform an action.
    404 : Not Found. Laravel will return automatically when the resource is not found.
    500 : Internal Server Error. Ideally, you will not be explicitly returning this, but if something unexpected breaks, this is what your user is going to receive.
    503 : Service Unavailable. Pretty self-explanatory, but also another code that is not going to be returned explicitly by the application.
`

## KEY
`
    php artisan passport:keys --length=256 --force
`

##GIT
`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`




API PROD

Xin lưu ý:
Thông tin dưới đây là môi trường Sandbox của VNPAY, sử dụng để kết nối kiểm thử hệ thống. Merchant không sử dụng thông tin này để đưa ra cho khách hàng thanh toán thật.
Merchant cần tạo địa chỉ IPN (server call server) sử dụng cập nhật tình trạng thanh toán (trạng thái thanh toán) cho giao dịch. Merchant cần gửi cho VNPAY URL này.
Thông tin cấu hình:
Terminal ID / Mã Website (vnp_TmnCode): B84ECGR7
Secret Key / Chuỗi bí mật tạo checksum (vnp_HashSecret): GDBLLDUKSDAJLXQYVUJKCJBDVSDNUFCN
Url thanh toán môi trường TEST (vnp_Url): https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
Thông tin truy cập Merchant Admin để quản lý giao dịch:
Địa chỉ: https://sandbox.vnpayment.vn/merchantv2/
Tên đăng nhập: tod74309@nezid.com
Mật khẩu: (Là mật khẩu nhập tại giao diện đăng ký Merchant môi trường TEST)
Kiểm tra (test case) – IPN URL:
Kịch bản test (SIT): https://sandbox.vnpayment.vn/vnpaygw-sit-testing/user/login
Tên đăng nhập: tod74309@nezid.com
Mật khẩu: (Là mật khẩu nhập tại giao diện đăng ký Merchant môi trường TEST)
Tài liệu:
Tài liệu hướng dẫn tích hợp: https://sandbox.vnpayment.vn/apis/docs/gioi-thieu/
Code demo tích hợp: https://sandbox.vnpayment.vn/apis/vnpay-demo/code-demo-tích-hợp



API LOCAL

Thông tin cấu hình:
Terminal ID / Mã Website (vnp_TmnCode): C6HDOV04
Secret Key / Chuỗi bí mật tạo checksum (vnp_HashSecret): EELRMOAOQOHRAROKOLEHISOVQPEAIOUK
Url thanh toán môi trường TEST (vnp_Url): https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
Thông tin truy cập Merchant Admin để quản lý giao dịch:
Địa chỉ: https://sandbox.vnpayment.vn/merchantv2/