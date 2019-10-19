@extends('inc.base')

@section('content')

<p>Middleware route works!</p>

<p>Middleware data from $request: <?= $data['auth'] ?></p>

@endsection