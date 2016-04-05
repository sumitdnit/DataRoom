@extends('layouts.protected')
@section('content')
<div class="container">
<h1 style="text-align:center;">Invite user for Project::&nbsp;{{$data['varProjectName']}}</h1>
	       <div>                      
									{{ Form::open(array('url' => 'project/invitesave')) }} 
											<input type="hidden" name="addProject" value="add" class="form-control">
											<input type="hidden" name="addProjectID" value="{{$data['varProjectId']}}" class="form-control"> 
											<input type="hidden" name="varProjectName" value="{{$data['varProjectName']}}" class="form-control"> 	
											<input type="hidden" name="varProjectDataRoomId" value="{{$data['varProjectdataid']}}" class="form-control"> 								
            <label for="Dataroom"><h4>First Name</h4></label></br>                         
            <input type="text" id="userFirstName" style="width:30%" name="userFirstName" value="" class="form-control" required>   
			<br> 
			<label for="Dataroom"><h4>Last Name</h4></label></br>                         
            <input type="text" id="userLastName" style="width:30%" name="userLastName" value="" class="form-control" required>
			</br>		
			<label for="Dataroom"><h4>Role</h4></label><br>
			<select class="list-select-box" name="dataRoomRole" id="dataRoomRole" required>
				<option value="">Select Role</option>
				<option value="upload">Upload</option>
				<option value="view">View</option>
				<option value="downloded">Downloded</option>
			</select>
			</br>
			   
			<label for="Dataroom"><h4>Email</h4></label></br>                         
            <input type="email" id="userEmail" style="width:30%" name="userEmail" value="" class="form-control" required> 			
			</br>
			<div>
				<button type="submit"  value="add" class="btn btn-default btn-info">Add</button> 
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
							
   });
</script>
@endsection