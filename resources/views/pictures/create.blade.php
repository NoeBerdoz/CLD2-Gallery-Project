<form action="{{ route('pictures.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    @error('file')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <input id="title" type="text" name="title">
    <input id="file" type="file" name="picture">
    <input type="submit">
</form>
