@extends('layouts.app')

@section('content')
    {{ $mandate[0]->name }}<br>
    {{ $mandate[0]->comment}}
@endsection
