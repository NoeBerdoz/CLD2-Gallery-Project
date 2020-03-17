@extends('layouts/app')

@push('scripts')
    <script src="/js/uploadFile.js"></script>
@endpush

@section('content')
    <a href="{{ route('pictures.index') }}">galerie d'images</a>
    <form action="{{ route('pictures.store') }}" method="post" enctype="multipart/form-data" data-inputs="{{ json_encode($formInputs) }}" data-attributes="{{ json_encode($formAttributes) }}">
        @csrf

        {{$errors->first('title')}}
        <input type="text" name="title" required/><br/>

        {{$errors->first('picture')}}
        <input type="file" name="file" required/><br/>
        <input type="hidden" name="storage_path" value="{{ $formInputs['key'] }}"/>

        <input type="submit"/>
    </form>
@endsection
