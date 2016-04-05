@extends('layouts.protected')
@section('content')
<div class="page container" >
  <h1> Your Project</h1>
  <br/>
  <div> @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <div class="col-lg-4 col-lg-offset-4 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2"> </div>
    <a href="{{url('project/view')}}" class="nav-item btn btn-info">Back</a> </div>
  <h3>"{{$data['roomname']}}" Project shared with following user(s)</h3>
  <div class="group-wrapper"> </div>
  <div class="col-lg-6 col-md-6 col-sm-6 list-main">
    <div class="content">
      <table class="table  tablepadding ydataroom" cellspacing="50">
        <tbody>
          <tr>
            <th>Sr No.</th>
            <th>User</th>
            <th>Role</th>
            <th>&nbsp;</th>
          </tr>
          <?php $k = 0; ?>
        @if($data!=null)
        @foreach($data['projectroom'] as $key=>$room)
        <tr>
          <td>{{$k = $k+1}}</td>
          <td> {{$room['user_name']}} </td>
          <td> {{ucfirst($room['role'])}} </td>
           <td> 
         
          {{Form::open(array('url'=> 'project/removeUser'))}}
               <input type="hidden" value="" name="_token">
               <input type="hidden" value="{{$room['project_id']}}" name="varProjectRoomId">
                <input type="hidden" value="{{$room['varDataRoomId']}}" name="varDataRoomId">
               <input type="hidden" value="{{$room['user_id']}}" name="varUserId">
               <button class="btn-default btn-xs" type="submit">Delete</button>
          {{Form::close()}} 
        
           </td>
        </tr>
        @endforeach
        @endif
          </tbody>
        
      </table>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
</div>
@endsection 