@extends(Config::get('explore::explore.template'))

@section('content')
<div class="row container-x well">
    {{ Form::open(array('method' => 'post', 'class' => 'form-horizontal', 'role' => 'form')) }}
    <fieldset>
    <legend>{{ $data['title'] }}</legend>
        <div class="form-group">
            <div class="col-sm-12">
                {{
                    Form::text('endpoint', Input::get('endpoint', Config::get('explore::explore.endpoint').$data['url']), array(
                        'class' => 'form-control',
                        'placeholder' => 'Endpoint URL'
                    ))
                }}
            </div>
        </div>

        @foreach ($data['parameter']['fields']['Parameter'] as $k => $param)
        <div class="form-group">
            <div class="col-sm-3">
                {{ Form::text('fields[]', Input::get('fields.'.$k, $param['field']), array('class' => 'form-control')) }}
            </div>
            <div class="col-sm-9">
                {{ Form::text('values[]', Input::get('values.'.$k, array_get($param, 'value')), array('class' => 'form-control', 'placeholder' => $param['description'])) }}
            </div>
        </div>
        @endforeach
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-primary">Request</button>
            </div>
        </div>
    </fieldset>
    {{ Form::close() }}
</div>

@if (isset($dataResponse))
<div class="row well">
    <pre><code class="hljs json">{{ $dataResponse }}</code></pre>
</div>
@endif

@endsection