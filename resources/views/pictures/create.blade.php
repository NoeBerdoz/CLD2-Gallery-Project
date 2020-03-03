@extends('layouts.app')

@push('scripts')
    <script src="/js/s3upload.js"></script>
@endpush

@section('content')
<form action="{{ route('pictures.store')}}" method="POST" class="s3upload" data-s3attributes="{{ json_encode($s3attributes) }}" data-s3inputs="{{ json_encode($s3inputs) }}" enctype="multipart/form-data">

    @csrf
    @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <input id="title" type="text" name="title">

    <input id="file" type="file" id="image_uploader" name="file">
    <input type="hidden" name="storage_path" value="{{ $s3inputs['key'] }}">
    <input type="submit">
</form>
@endsection
