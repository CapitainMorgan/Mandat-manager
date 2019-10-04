@extends('layouts.app')

@section('content')

  <update-worktime :worktime_param="{{ $worktime }}" :mandate_id="{{ $mandate_id }}"></update-worktime>
  
@endsection