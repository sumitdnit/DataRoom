@extends('layouts.protected')
@section('content')
<div class="pagenotfound">
  <div class="error-container" style='max-width:800px;'>
    <div class="errorimg"><img src="{{URL::asset('assets/images/404img.png')}}"></div>
    <h2>Project not accessible!</h2>
    <p>This Project may be private. If someone give you this link, they may need to<br>invite you to one of their Project.</p>
  </div>
</div>
@endsection 