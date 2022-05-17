@extends(backpack_view('blank'))

@section('content')

    <div class="alert alert-danger" role="alert">
        {{ $message  }}
    </div>

@endsection
