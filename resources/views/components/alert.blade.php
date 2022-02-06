@if(Session::has('status') and Session::has('message'))
    <div class="alert alert-{{Session::get('status')}} alert-dismissible fade show">
        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
          <i class="nc-icon nc-simple-remove"></i>
        </button>
        @if(is_array(Session::get('message')))
            @if(count(Session::get('message')) > 1)
                <ul>
                @foreach(Session::get('message') as $message)
                    <li>{{$message}}</li>
                @endforeach
                </ul>
            @else
                {{Session::get('message')[0]}}    
            @endif
        @else
            {{Session::get('message')}}
        @endif
    </div>   
@endif

<div class="alert-message "></div>