<form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
    <div class="form-group row align-items-center">
        <label class="col-3">Địa điểm nhận</label>
        <div class="col">
            <input type="text" placeholder="Hà Nội"  value="{{ $order->address ?? "" }}" name="address" class="form-control" >
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label class="col-3">Ghi chú</label>
        <div class="col">
            <textarea name="note" class="form-control" id="" cols="30" rows="3" placeholder="Chú ý nhập mô tả từ 80 -> 130 ký tự, không nhập quá dài và quá ngắn">{{ $order->note ?? "" }}</textarea>
            <span style="color: red;font-size: 12px"><i>Chú ý nhập mô tả từ 80 -> 130 ký tự, không nhập quá dài và quá ngắn</i></span>
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label class="col-3">Trạng thái thanh toán</label>
        <div class="col">
            <select name="status" class="form-control" id="">
                @foreach($status ?? [] as $key => $item)
                    <option {{ ($order->status ?? 0) == $key ? "selected" : "" }} value="{{ $key }}">{{ $item['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label class="col-3">Trạng thái vận chuyển</label>
        <div class="col">
            <select name="shipping_status" class="form-control" id="">
                @foreach($statusShippingConfig ?? [] as $key => $item)
                    <option {{ ($order->shipping_status ?? 0) == $key ? "selected" : "" }} value="{{ $key }}">{{ $item['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Lưu thông tin</button>
    </div>
</form>
