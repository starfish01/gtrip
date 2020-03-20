@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
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
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>URL</th>
                            <th>search_keys</th>
                            <th>skip keys</th>
                            <th>enabled</th>
                        </tr>
                        @foreach($data as $item)
                        <tr>
                            <th>{{ $item['id'] }}</th>
                            <th>{{ $item['title'] }}</th>
                            <th><a href="{{ $item['url'] }}" target="_blank">Open</a></th>
                            <th>{{ $item['keys']['keys'] }}</th>
                            <th>{{ $item['keys']['skip_keys'] }}</th>
                            <th>{{ $item['enabled'] ? 'enabled' : 'off' }}</th>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Found Items </div>

                <div class="card-body">

                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>URL</th>
                            <th>Email Sent</th>
                            <th>Filtered Out</th>

                        </tr>
                        @foreach($foundItems as $item)
                        <tr>
                            <th>{{ $item['id'] }}</th>
                            <th>{{ $item['title'] }}</th>
                            <th><a href="http://www.gumtree.com.au{{ $item['url'] }}" target="_blank">Open</a></th>
                            <th>{{ $item['email_sent'] }}</th>
                            <th>{{ $item['filtered_out'] }}</th>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection