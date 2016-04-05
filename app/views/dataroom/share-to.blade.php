@extends('layouts.protected')
@section('content')
<div class="page container" >
  <h1> Your DataRoom</h1>
  <br/>
  <div> @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <div class="col-lg-4 col-lg-offset-4 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2"> </div>
    <a href="{{url('dataroom/view')}}" class="nav-item btn btn-info">Back</a> </div>
  <h3>"{{$data['roomname']}}" DataRoom shared with following user(s)</h3>
  <div class="group-wrapper"> </div>
  <div class="row workflow-container clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
     
        <div class="row rowheader">
          <div class="col-lg-2 col-md-2 col-sm-2">Sr No.</div>
          <div class="col-lg-4 col-md-4 col-sm-4">User</div>
          <div class="col-lg-3 col-md-3 col-sm-3">Role</div>
          <div class="col-lg-3 col-md-3 col-sm-3"> </div>
        </div>
        <?php $k = 0; ?>
        @if($data!=null)
        @foreach($data['dataroom'] as $key=>$room)
      
        <div class="row rowdetails">
          <div class="col-lg-2 col-md-2 col-sm-2">{{$k = $k+1}}</div>
          <div class="col-lg-4 col-md-4 col-sm-4">{{$room['user_name']}} </div>
          <div class="col-lg-3 col-md-3 col-sm-3">{{ucfirst($room['role'])}}</div>
          <div class="col-lg-3 col-md-3 col-sm-3">
         
          {{Form::open(array('url'=> 'dataroom/removeUser'))}}
               <input type="hidden" value="" name="_token">
               <input type="hidden" value="{{$room['data_room_id']}}" name="varDataRoomId">
               <input type="hidden" value="{{$room['user_id']}}" name="varUserId">
               <button class="btn-default btn-xs" type="submit">Delete</button>
          {{Form::close()}} 
        
           </div>
        </div>
        @endforeach
        @endif 
    </div>
  </div>
</div>
</div>
</div>
@endsection 