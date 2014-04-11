@extends(Config::get('explore::explore.template'))

@section('content')
<div class="row container-x">
    {{ Form::open(array('method' => 'post', 'class' => 'form-horizontal', 'role' => 'form')) }}
        <div class="form-group">
            <label for="endpoint" class="col-sm-2 control-label">Endpoint</label>
            <div class="col-sm-10">
                {{ Form::text('endpoint', Input::get('endpoint', Config::get('explore::explore.endpoint').$data['url']), array('class' => 'form-control')) }}
            </div>
        </div>

        @foreach ($data['parameter']['fields']['Parameter'] as $k => $param)
        <div class="form-group">
            <div class="col-xs-2">
                {{ Form::text('fields[]', Input::get('fields.'.$k, $param['field']), array('class' => 'form-control')) }}
            </div>
            <div class="col-sm-10">
                {{ Form::text('values[]', Input::get('values.'.$k, array_get($param, 'value')), array('class' => 'form-control', 'placeholder' => $param['description'])) }}
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