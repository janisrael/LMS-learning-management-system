@isset($data)
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
        <label>Last Login At: </label>
        {{$data->last_login_at ? $data->last_login_at->toDayDateTimeString() : ''}}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
        <label>Last Login IP: </label>
        {{$data->last_login_ip}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
        <label>Date Updated: </label>
        {{$data->updated_at->toDayDateTimeString()}}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
        <label>Created At: </label>
        {{$data->created_at->toDayDateTimeString()}}
        </div>
    </div>
</div>
<hr>
@endisset

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
        <label>Name*</label>
        <div class="input-group">
            {!! Form::text('name', null, ['class'=>'form-control float-right', 'required']); !!}
        </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
        <label>Username*</label>
        <div class="input-group">
            {!! Form::text('username', null, ['class'=>'form-control float-right', 'required']); !!}
        </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
        <label>Email*</label>
        <div class="input-group">
            {!! Form::email('email', null, ['class' => 'form-control float-right', 'required']); !!}
        </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
        <label>Password*</label>
        <div class="input-group">
            {!! Form::password('password', ['class' => 'form-control float-right']); !!}
        </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
        <label>Confirm Password*</label>
        <div class="input-group">
            {!! Form::password('password_confirmation', ['class' => 'form-control float-right']); !!}
        </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
                {!! Form::checkbox('is_active', 1, null, ['id' => 'is_active']) !!}
                <label class="form-check-label" for="is_active">Is Active</label>
            </div>
        </div>
    </div>
</div>