@extends('layouts.protected')
@section('content')
<div class="pagenotfound">
  <div class="error-container">
    <div class="errorimg"><img src="{{URL::asset('assets/images/404img.png')}}"></div>
    <h1>404</h1>
    <h3>Oops...Page Not Found</h3>
  </div>
</div>
@endsection 