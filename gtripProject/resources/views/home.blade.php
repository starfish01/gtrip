@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    User ID: {{ $user }}
                    <hr>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>URL</th>
                            <th>search_keys</th>
                            <th>enabled</th>
                        </tr>
                        @foreach($data as $item)
                        <tr>
                            <th>{{ $item['id'] }}</th>
                            <th>{{ $item['title'] }}</th>
                            <th><a href="{{ $item['url'] }}" target="_blank">Open</a></th>
                            <th>{{ $item['search_keys'] }}</th>
                            <th>{{ $item['enabled'] ? 'enabled' : 'off' }}</th>
                        </tr>
                        @endforeach
                    </table>



                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection