@extends('layouts.app')

@section('content')

  <info-mandate mandate_param="{{ $mandate }}"></info-mandate>
  <fees-price mandate_id="{{ $mandate->id }}"></fees-price>

@endsection
