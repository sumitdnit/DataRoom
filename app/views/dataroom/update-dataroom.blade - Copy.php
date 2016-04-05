@extends('layouts.protected')
@section('content')
<div class="container">
<h1 style="text-align:center;">Add DataRoom</h1>
	       <div>                      
									{{ Form::open(array('url' => 'dataroom/saveupdate')) }} 
											<input type="hidden" name="Action" value="update" class="form-control">     									
												<input type="hidden" name="dataRoomId" value="{{$data['id']}}" class="form-control">  
            <label for="Dataroom"><h4>DataRoom Name</h4></label></br>                         
            <input type="text" id="dataRoom" name="dataRoom" value="{{$data['name']}}" class="form-control" required>     
												</br> 
												
												<label for="Dataroom"><h4>Status</h4></label><br>
												<select class="list-select-box" name="dataRoomStatus" id="dataRoomStatus" required>
													<option value="">Set Status</option>
													<option value="1" <?php if($data['status'] == '1') { echo 'selected'; }?>>Active</option>
													<option value="0" <?php if($data['status'] == '0') { echo 'selected'; }?>>Inactive</option>
											
												</select>
												</br>        
												</br>
												<div>
													<button type="submit"  value="update" class="btn btn-default btn-info">Update</button> 
												</div>            
									{{ Form::close() }}
							</div>
							<script>
    $(document).ready(function () {
							$("#dataRoomRole").heapbox({
           'effect': {
                'type': 'slide',
                'speed': 'fast'
            },
            'heapsize': '200px'
								});
								$("#dataRoomStatus").heapbox({
           'effect': {
                'type': 'slide',
                'speed': 'fast'
            },
            'heapsize': '200px'
								});
							
   });
</script>
@endsection