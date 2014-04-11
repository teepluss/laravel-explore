@if ($index = 0) @endif
@foreach ($navigators as $group => $navs)
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">{{ $group }}</h3>
    </div>
    <div class="list-group">
        @foreach ($navs as $v)
        <a href="{{ URL::route('explore.index.get', array('id' => $index)) }}" class="list-group-item @if ($index == $offset) active @endif">
            {{ $v['title'] }}
        </a>
        @if ($index++) @endif
        @endforeach
    </div>
</div>
@endforeach