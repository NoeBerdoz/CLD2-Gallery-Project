<ul>

    @foreach($pictures as $picture)
        <li>
            <a href="{{ route('pictures.show', $picture) }}">
                <p>{{ $picture->title }}</p>
                    <img src="{{ route('pictures.show', $picture) }}" style="width: 200px;">
            </a>
        </li>
    @endforeach

</ul>

