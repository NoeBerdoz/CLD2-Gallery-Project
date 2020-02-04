<form action="{{ route('pictures.store') }}">
    @csrf
    <input type="text" name="title">
    <input type="file">
    <input type="submit">
</form>
