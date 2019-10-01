@extends('layouts.app')

@section('content')
    
    <price-component :price_param="{{ $prices }}"></price-component>
    
@endsection