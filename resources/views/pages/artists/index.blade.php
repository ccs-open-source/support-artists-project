Todos os Artistas
<ul>
    @foreach($artists as $artist)
        <li>{{ $artist['name'] }}</li>
    @endforeach
</ul>
