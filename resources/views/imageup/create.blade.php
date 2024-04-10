<div style="background-color:#FFFF99; padding:10px;">
    <div style="width:80%; margin:auto;">
        <div>{{$main_title}}</div>
        <form action="{{route('imageup.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-2">
                <div>画像(3Mまで)</div>
                <input type="file" name="image_file" class="btn btn-info" id="image_file" accept=".png, .jpg, .jpeg,">
            </div>
            <button type="submit" class="btn btn-primary">登録</button>
        </form>
    </div>
</div>
