@if( $errors->any() )
    <div class="alert alert-danger alert-dismissable">
        <button class="close" data-dismiss="alert"></button> Please check the following field(s):
        <ul>
            @foreach($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif