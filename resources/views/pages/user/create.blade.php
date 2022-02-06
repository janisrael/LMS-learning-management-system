@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        @include('components.form_error')
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$create_title}}</h3>
            </div>
            {!! Form::open(['route'=>'user.store', 'role'=>'form']) !!}
                <div class="card-body">
                    @include('pages.user._form')
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-info text-white">Done</button>
                    <a href="{{ route('user.index') }}" class="btn btn-default float-right">Cancel</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection