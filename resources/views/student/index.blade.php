@extends('layouts.app')
@section('content')
<!-- <<--ADD STUDENT MODAL-->

<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<ul id="#saveform_errList">	</ul>
        <div class="form-group mb-3">
        	<label>Name</label>
        	<input type="text" name="" class="name form-control">
        </div>
        <div class="form-group mb-3">
        	<label>Email</label>
        	<input type="text" name="" class="email form-control">
        </div>
        <div class="form-group mb-3">
        	<label>Phone</label>
        	<input type="text" name="" class="phone form-control">
        </div>
        <div class="form-group mb-3">
        	<label>Course</label>
        	<input type="text" name="" class="course form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_student">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- END ADD MODEL -->

<!-- STUDENT EDIT MODEL-->

<div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit and update Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<ul id="#updateform_errList"></ul>
      	<input type="hidden" id="edit_stud_id">
        <div class="form-group mb-3">
        	<label>Name</label>
        	<input type="text" id="edit_name" class="name form-control">
        </div>
        <div class="form-group mb-3">
        	<label>Email</label>
        	<input type="text" id="edit_email" class="email form-control">
        </div>
        <div class="form-group mb-3">
        	<label>Phone</label>
        	<input type="text" id="edit_phone" class="phone form-control">
        </div>
        <div class="form-group mb-3">
        	<label>Course</label>
        	<input type="text" id="edit_course" class="course form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update_student">Update</button>
      </div>
    </div>
  </div>
</div>

<!-- END STUDENT EDIT MODEL -->

<!-- Delete Model-->

<div class="modal fade" id="DeleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<input type="hidden" id="delete_stud_id">
       <h4>Are you sure you want to delete the student?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary delete_student_btn">Yes Delete</button>
      </div>
    </div>
  </div>
</div>



<!-- End Delete Model -->

<div class="container py-54">
	<div class="row">
		<div class="col-md-12">
			<div id="success_message">
				
			</div>


			<div class="card">
				<div class="card-header">
					<h4>
						Students Data
						<a href='#' data-bs-toggle="modal" data-bs-target="#AddStudentModal" class="btn btn-primary float-end btn-sm">Add Student</a>
					</h4>
				</div>
				<div class="card-body">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Course</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							 
						</tbody>
						
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection  


@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){  
           fetchstudent();
		function fetchstudent()
		{
			$.ajax({

				type: "GET",
				url: "fetch-student",
				datatype: "jason",
				success: function(response){
					//console.log(response.students);
					$('tbody').html("");
					$.each(response.students, function (key, item){

						$('tbody').append('<tr>\
							 	<td>'+item.id+'</td>\
							 	<td>'+item.name+'</td>\
							 	<td>'+item.email+'</td>\
							 	<td>'+item.phone+'</td>\
							 	<td>'+item.course+'</td>\
		          <td><button type="button" value="'+item.id+'" class="edit_student btn btn-primary btn-sm">Edit</button></td>\
			     <td><button type="button" value="'+item.id+'" class="delete_student btn btn-danger btn-sm">Delete</button></td>\
							    </tr>');
					});
				}

			});
		}

		$(document).on('click','.delete_student', function(e){

			e.preventDefault();
			var stud_id = $(this).val();
			//alert('stud_id');
			$('#delete_stud_id').val(stud_id);
			$('#DeleteStudentModal').modal('show');

		});
		$(document).on('click','.delete_student_btn', function(e){
			e.preventDefault();
			$(this).text('Deleting');
			var stud_id = $('#delete_stud_id').val();

			$.ajaxSetup({
                     headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                       });

			$.ajax({
				type: "DELETE",
				url: "/delete-student/"+stud_id,
				success: function(response)
				{
					console.log(response);
					$('#success_message').addClass('alert alert-success')
					$('#success_message').text(response.message);
					$('#DeleteStudentModal').modal('hide');
			        $('.delete_student_btn').text('Yes Delete');

					fetchstudent();

				}
			});


		});
	
		$(document).on('click','.edit_student', function(e)
		{
			e.preventDefault();
            var stud_id = $(this).val();
            //console.log(stud_id);
            $('#EditStudentModal').modal('show');
            $.ajax({
				type: "GET",
				url: "/edit_student/"+stud_id,
				success: function(response)
				{
					//console.log(response);
					if(response.status == 404)
					{    
						$('#success_message').html("");
						$('#success_message').addClass('alert alert-danger');
						$('#success_message').text(response.message);
                  	}
                  	else
                  	{  
                  		$('#edit_name').val(response.student.name);
                  		$('#edit_email').val(response.student.email);
                  		$('#edit_phone').val(response.student.phone);
                  		$('#edit_course').val(response.student.course);
                  		$('#edit_stud_id').val(stud_id);



                  	}

				}

            });
		});


		$(document).on('click','.update_student', function(e)
		{  
			e.preventDefault();
			$(this).text('Updating');
			var stud_id = $('#edit_stud_id').val();
			var data = {
				'name' :$('#edit_name').val(),
				'email' :$('#edit_email').val(),
				'phone' :$('#edit_phone').val(),
				'course' :$('#edit_course').val(),

			           }

			$.ajaxSetup({
                     headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                       });
			$.ajax({
				type: "PUT",
				url: "/update_student/"+stud_id,
				data: data,
				datatype: "jason",
				success: function(response)
				{
					//console.log(response);
					if(response.status == 400)
					{
						$('#updateform_errList').html("");
						$('#updateform_errList').addClass ('alert alert-danger');
						$.each(response.errors, function (key, err_values)
						{
						$('#updateform_errList').append('<li>'+err_values+'</li>');

					    });

			          $('.update_student').text('Update');


					}
					else if(response.status == 404)
					{
						$('#updateform_errList').html("");
						$('#success_message').addClass ('alert alert-success')
						$('#success_message').text(response.message)
			            $('.update_student').text('Update');


					}
					else
					{
						$('#updateform_errList').html("");
						$('#success_message').html("");
						$('#success_message').addClass ('alert alert-success')
						$('#success_message').text(response.message)
						$('#EditStudentModal').modal('hide')
			            $('.update_student').text('Update');
						fetchstudent();

					}
				}

		});
		});





		$(document).on('click','.add_student',function(e){
			e.preventDefault();
			var data = {
				'name': $('.name').val(),
				'email': $('.email').val(),
				'phone': $('.phone').val(),
				'course': $('.course').val(),

			          }
			//console.log(data);
			$.ajaxSetup({
                     headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                       });
			$.ajax({
				type: "POST",
				url: "/students",
				data: data,
				datatype: "jason",
				success: function(response)
				{
                   // console.log(response.errors.name);
					if(response.status == 400)
					{
						$('#saveform_errList').html("");
						$('#saveform_errList').addClass ('alert alert-danger');

						$.each(response.errors, function (key, err_values){

							$('#saveform_errList').append('<li>'+err_values+'</li>');

						});
					}

					else
					{   
						$('#success_message').html("");
						$('#success_message').addClass ('alert alert-success');
						$('#success_message').text(response.message);
						$('#AddStudentModal').modal('hide');
						$('#AddStudentModal').find('input').val("");
						fetchstudent();

					}

				}

			});

		});
	});




	


</script>

@endsection