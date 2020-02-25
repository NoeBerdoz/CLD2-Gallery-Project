<h1>{{ $picture->title }}</h1>
<form action="{{ route('pictures.destroy', $picture) }}" method="POST">
    @csrf
    @method('DELETE')
<img src="{{ route('pictures.show', $picture->id)  }}">
    <button type="submit">Supprimer</button>

</form>
