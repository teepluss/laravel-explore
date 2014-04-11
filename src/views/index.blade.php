@extends(Config::get('explore::explore.template'))

@section('content')
<div class="row container-x">
    {{ Form::open(array('method' => 'post', 'class' => 'form-horizontal', 'role' => 'form')) }}
        <div class="form-group">
            <label for="endpoint" class="col-sm-2 control-label">Endpoint</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="endpoint" name="endpoint" value="{{ Config::get('explore::explore.endpoint').$data['url'] }}">
            </div>
        </div>

        @foreach ($data['parameter']['fields']['Parameter'] as $param)
        <div class="form-group">
            <div class="col-xs-2">
                <input type="text" class="form-control" name="fields[]" value="{{ $param['field'] }}">
            </div>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="values[]" placeholder="{{ $param['description'] }}" value="{{ array_get($param, 'value') }}">
            </div>
        </div>
        @endforeach
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Request</button>
            </div>
        </div>
    {{ Form::close() }}
</div>

@if ($response)
<pre>{{ $response }}</pre>
@endif

@endsection