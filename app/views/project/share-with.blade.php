@extends('layouts.protected')
@section('content')
<div class="container">
<h2 style="text-align:center;">Assign Project</h2>
<div> {{ Form::open(array('url' => 'project/saveshare')) }}
  <input type="hidden" name="addproject" value="{{$data['roomID']}}" class="form-control">
  <input type="hidden" name="varProjectdataroomid" value="{{$data['varProjectdataroomid']}}" class="form-control">
  Project:: <b>{{$data['roomName']}}</b> </br>
  <label for="dataRoomUser">
  <h4>User</h4>
  </label>
  <br>
  <?php if(count($data['users']) > 0){ ?>
  <select class="list-select-box" name="dataRoomUser" id="dataRoomUser" required>
    <option value="">Select User</option>
    <?php foreach($data['users'] as $key=>$v){
	   $name = ucfirst($v->firstname).' '.ucfirst($v->lastname); ?>
    <option value="<?php echo $v->userid;?>"><?php echo $name; ?></option>
    <?php }?>
  </select>
  <?php }?>
  </br>
  <label for="Role">
  <h4>Role</h4>
  </label>
  <br>
  <select class="list-select-box" name="dataRoomRole" id="Role" required>
    <option value="">Select Role</option>
    <option value="view">View</option>
    <option value="upload">Upload</option>
    <option value="downloded">Downloded</option>
  </select>
  </br>
  </br>
  <div>
    <button type="submit"  value="add" class="btn btn-default btn-info">Add</button>
  </div>
  {{ Form::close() }} </div>
<script>
    $(document).ready(function () {
							$("#Role").heapbox({
           'effect': {
                'type': 'slide',
                'speed': 'fast'
            },
            'heapsize': '200px'
								});
								$("#dataRoomUser").heapbox({
           'effect': {
                'type': 'slide',
                'speed': 'fast'
            },
            'heapsize': '200px'
								});
							
   });
</script> 
@endsection