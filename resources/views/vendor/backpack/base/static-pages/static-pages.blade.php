@extends(backpack_view('blank'))

@section('content')

    <table class="table">
        <thead>
        <tr>

            <th scope="col">Page</th>
            <th scope="col">Slug</th>

        </tr>
        </thead>
        <tbody>
        @foreach($pages as $key => $page)
        <tr>
            <td>{{ $key }}</td>
            <td>{{ $page }}</td>

        </tr>
        @endforeach
        </tbody>
    </table>

@endsection
