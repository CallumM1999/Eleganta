@extends('inc.base')

@section('content')

<p>Match page works! [{{ $id }}]</p>

    @foreach($data['users'] as $user)
        <p>User: {{ $user->name }}</p>
    @endforeach

@endsection