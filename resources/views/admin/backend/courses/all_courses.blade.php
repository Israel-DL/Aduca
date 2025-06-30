@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
    .large-checkbox{
        transform: scale(1.5);
    }
</style>

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<!-- <div class="breadcrumb-title pe-3">All Category</div> -->
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Instructors</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>Sl</th>
										<th>Image</th>
										<th>Course Name</th>
                                        <th>Instructor</th>
                                        <th>Category</th>
                                        <th>Price</th>
										<th>Action</th>
                                        <th>Status</th>
									</tr>
								</thead>
								<tbody>

                                    @foreach ($course as $key=> $item)
									<tr>
										<td>{{ $key+1 }}</td>
										<td><img src="{{ asset($item->course_image) }}" alt="Course Image" style="width: 70; height: 40px;"></td>
                                        <td>{{$item->course_name}}</td>
                                        <td>{{$item['user']['name']}}</td>
                                        <td>{{$item['category']['category_name']}}</td>
                                        <td>₦{{$item->selling_price}}</td>
                                        <td>
                                            <a href="" class="btn btn-info px-5"><i class="lni lni-eye"></i></a>
                                        </td>
										<td>
                                            <div class="form-check-danger form-check form-switch">
									            <input class="form-check-input status-toggle large-checkbox" type="checkbox" id="flexSwitchCheckCheckedDanger" data-user-id="{{ $item->id }}" {{ $item->status ? 'checked' : '' }} >
									            <label class="form-check-label" for="flexSwitchCheckCheckedDanger"></label>
								            </div>
                                        </td>
										
									</tr>
                                    @endforeach
									
								</tbody>
								
							</table>
						</div>
					</div>
				</div>
				
				
</div>



<script>
    $(document).ready(function(){
        $('.status-toggle').on('change', function(){
            var userId = $(this).data('user-id');
            var isChecked = $(this).is(':checked');

            //Send an AJAX request to update status
            $.ajax({
                url: "{{ route('update.user.status') }}",
                method: "POST",
                data: {
                    user_id : userId,
                    is_checked : isChecked ? 1 : 0,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response){
                    toastr.success(response.message);
                },
                error: function(){

                }
            });
        });
    });
</script>


@endsection