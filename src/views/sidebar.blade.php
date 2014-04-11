<ul class="nav nav-stacked" id="sidebar">
    @foreach ($json as $k => $v)
    <li><a href="{{ URL::route('explore.index.get', array('id' => $k)) }}">{{ $v['name'] }}</a>
    @endforeach
</ul>