@extends('layouts.app')

@section('content')

  <info-mandate></info-mandate>

    {{ $mandate->name }}<br>
    {{ $mandate->comment}}
@endsection
