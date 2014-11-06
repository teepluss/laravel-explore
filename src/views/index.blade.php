@extends(Config::get('explore::explore.template'))

@section('content')
<div class="row container-x well">
    {{ Form::open(array('url' => URL::route('explore.request', array('id' => $offset)), 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form', 'target' => 'response')) }}
    <fieldset>
    <legend>
        <span style="text-transform:uppercase;">{{ $data['type'] }}</span> : {{ array_get($data, 'title', 'Undefined') }}
    </legend>
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

        <div class="availables">
            @foreach ($data['parameter']['fields']['Parameter'] as $k => $param)
            <div class="form-group">
                <div class="col-sm-3">
                    {{ Form::text('fields[]', Input::get('fields.'.$k, $param['field']), array('class' => 'form-control')) }}
                </div>
                <div class="col-sm-8">
                    {{ Form::text('values[]', Input::get('values.'.$k, array_get($param, 'value')), array('class' => 'form-control', 'placeholder' => strip_tags($param['description']))) }}
                </div>
                <div class="col-sm-1">
                    <a href="javascript:void(0)" class="remove-node" tabindex="-1"><span class="glyphicon glyphicon-minus"></span></a>
                </div>
            </div>
            @endforeach
            <div class="form-group">
                <div class="col-sm-3">
                    {{ Form::text('fields[]', null, array('class' => 'form-control', 'placeholder' => 'Key')) }}
                </div>
                <div class="col-sm-8">
                    {{ Form::text('values[]', null, array('class' => 'form-control', 'placeholder' => 'Value')) }}
                </div>
                <div class="col-sm-1">
                    <a href="javascript:void(0)" class="remove-node" tabindex="-1"><span class="glyphicon glyphicon-minus"></span></a>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-primary">Request</button>
            </div>
        </div>
    </fieldset>
    {{ Form::close() }}
</div>

<div class="row response">
    <iframe name="response" id="iframe1" src="{{ URL::route('explore.request', array('id' => $offset)) }}" width="100%" marginheight="0" frameborder="0" onLoad="autoResize('iframe1');"></iframe>
</div>

@endsection