@foreach ($navigators as $group => $navs)
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">{{ $group }}</h3>
    </div>
    <div class="list-group">
        @foreach ($navs as $i => $v)
        <a href="{{ URL::route('explore.index.get', array('id' => $i)) }}" class="list-group-item @if ($i == $offset) active @endif">
            {{ array_get($v, 'title', 'Undefined') }}
        </a>
        @endforeach
    </div>
</div>
@endforeach