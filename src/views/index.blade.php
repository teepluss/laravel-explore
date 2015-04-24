@extends(Config::get('explore.template'))

@section('content')
<div class="row container-x well">
    <form method="post" action="{{ URL::route('explore.request', array('id' => $offset)) }}" class="form-horizontal" role="form" target="response">
    <fieldset>
    <legend>
        <span style="text-transform:uppercase;">{{ $data['type'] }}</span> : {{ array_get($data, 'title', 'Undefined') }}
    </legend>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" name="endpoint" value="{{ Input::get('endpoint', Config::get('explore.endpoint').$data['url']) }}" class="form-control" placeholder="Api Enpoint URL">
            </div>
        </div>

        <div class="availables">
            @foreach ($data['parameter']['fields']['Parameter'] as $k => $param)
            <div class="form-group">
                <div class="col-sm-3">
                    <input type="text" name="fields[]" value="{{ Input::get('fields.'.$k, $param['field']) }}" class="form-control">
                </div>
                <div class="col-sm-8">
                    <input type="text" name="values[]" value="{{ Input::get('values.'.$k, array_get($param, 'value')) }}" class="form-control" placeholder="{{ strip_tags($param['description']) }}">
                </div>
                <div class="col-sm-1">
                    <a href="javascript:void(0)" class="remove-node" tabindex="-1"><span class="glyphicon glyphicon-minus"></span></a>
                </div>
            </div>
            @endforeach
            <div class="form-group">
                <div class="col-sm-3">
                    <input type="text" name="fields[]" class="form-control" placeholder="key">
                </div>
                <div class="col-sm-8">
                    <input type="text" name="values[]" class="form-control" placeholder="value">
                </div>
                <div class="col-sm-1">
                    <a href="javascript:void(0)" class="remove-node" tabindex="-1"><span class="glyphicon glyphicon-minus"></span></a>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-primary">Request</button>
            </div>
        </div>
    </fieldset>
    </form>
</div>

<div class="row response">
    <iframe name="response" id="iframe1" src="{{ URL::route('explore.request', array('id' => $offset)) }}" width="100%" marginheight="0" frameborder="0" onLoad="autoResize('iframe1');"></iframe>
</div>

@endsection