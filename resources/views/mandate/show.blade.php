@extends('layouts.app')

@section('content')

  <info-mandate mandate_param="{{ $mandate }}"></info-mandate>
  <fees-price></fees-price>

@endsection
