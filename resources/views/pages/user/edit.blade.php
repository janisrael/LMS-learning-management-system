@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        @include('components.form_error')
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$edit_title}}</h3>
            </div>
            {!! Form::model($data, ['route'=>['user.update', $data->id], 'role'=>'form']) !!}
                <div class="card-body">
                    @include('pages.user._form')
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-info text-white">Save</button>
                    <a href="{{ route('user.index') }}" class="btn btn-default float-right">Cancel</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection