@extends('layouts.app')

@section('content')
    {{ $mandate->name }}<br>
    {{ $mandate->comment}}
@endsection
