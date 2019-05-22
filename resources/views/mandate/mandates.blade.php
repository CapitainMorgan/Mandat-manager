@extends('layouts.app')

@section('content')
   <all-mandate :data-mandate="{{ $mandate }}"></all-mandate>
@endsection
