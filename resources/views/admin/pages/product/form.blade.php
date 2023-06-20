<form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
    <div class="form-group row align-items-center">
        <label class="col-3">Tên</label>
        <div class="col">
            <input type="text" placeholder="Tên sản phẩm"  value="{{ $product->name ?? "" }}" name="name" class="form-control" >
            @if ($errors->first('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label class="col-3">Price</label>
        <div class="col">
            <input type="number" placeholder="0"  value="{{ $product->price ?? 0 }}" name="price" class="form-control" >
            @if ($errors->first('price'))
                <span class="text-danger">{{ $errors->first('price') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label class="col-3">Danh mục</label>
        <div class="col">
            <select name="category_id" class="form-control" id="">
                @foreach($categories ?? [] as $item)
                    <option {{ ($product->category_id ?? 0) == $item->id ? "selected" : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label class="col-3">Mô tả ngắn</label>
        <div class="col">
            <textarea name="description" class="form-control" id="" cols="30" rows="3" placeholder="Chú ý nhập mô tả từ 80 -> 130 ký tự, không nhập quá dài và quá ngắn">{{ $product->description ?? "" }}</textarea>
            <span style="color: red;font-size: 12px"><i>Chú ý nhập mô tả từ 80 -> 130 ký tự, không nhập quá dài và quá ngắn</i></span>
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label class="col-3">Nội dung</label>
        <div class="col">
            <textarea name="content" class="form-control" id="content" cols="30" rows="3" placeholder="Nội dung">{{ $product->content ?? "" }}</textarea>
            <span style="color: red;font-size: 12px"><i>Nội dung nhập đầy đủ thông tin sản phẩm, có thể nhập nhiều</i></span>
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label class="col-3">Avatar</label>
        <div class="col">
            <input type="file" name="avatar" class="form-control">
        </div>
    </div>
    @if (isset($product) && $product->avatar)
        <div class="form-group row align-items-center">
            <label class="col-3"></label>
            <div class="col">
                <img style="width: 100px;height: auto" src="{{ pare_url_file($product->avatar) }}" alt="">
            </div>
        </div>
    @endif
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Lưu thông tin</button>
    </div>
</form>

<script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">

    var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    };

    CKEDITOR.replace( 'content' ,options);
</script>
