<form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
    <div class="form-group row align-items-center">
        <label class="col-3">Tên</label>
        <div class="col">
            <input type="text" placeholder="Tên danh mục"  value="{{ $category->name ?? "" }}" name="name" class="form-control" >
            @if ($errors->first('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label class="col-3">Nổi bật</label>
        <div class="col">
            <select name="hot" class="form-control" id="">
                <option value="1" {{ ($category->hot ?? 0) == 1 ? "selected" : "" }}>Nổi bật</option>
                <option value="0" {{ ($category->hot ?? 0) == 0 ? "selected" : "" }}>Mặc định</option>
            </select>
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label class="col-3">Avatar</label>
        <div class="col">
            <input type="file" name="avatar" class="form-control">
        </div>
    </div>
    @if (isset($category) && $category->avatar)
        <div class="form-group row align-items-center">
            <label class="col-3"></label>
            <div class="col">
                <img style="width: 100px;height: auto" src="{{ pare_url_file($category->avatar) }}" alt="">
            </div>
        </div>
    @endif
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Lưu thông tin</button>
    </div>
</form>
