@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<!-- <div class="breadcrumb-title pe-3">All Category</div> -->
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Add Sub-Category</li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
				
				<div class="card">
							<div class="card-body p-4">
								<h5 class="mb-4">Sub-Category Form</h5>
								<form id="myForm" action="{{ route('store.subcategory') }}" method="post"  class="row g-3">
									@csrf
									<div class="form-group col-md-6">
										<label for="input1" class="form-label">Category Name</label>
										<select name="category_id" class="form-select mb-3" aria-label="Default select example">
                                            <option selected="" disabled>Select Category</option>
                                            @foreach ($category as $cat)
                                            <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                                            @endforeach
                                        </select>
									</div>

									<div class="col-md-6">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Sub-Category Name</label>
										<input type="text" class="form-control" id="input1" name="subcategory_name" placeholder="Category Name">
									</div>

									
									
									
									<div class="col-md-12">
										<div class="d-md-flex d-grid align-items-center gap-3">
											<button type="submit" class="btn btn-primary px-4">Add Category</button>
											
										</div>
									</div>
								</form>
							</div>
						</div>
				
				
</div>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                subcategory_name: {
                    required : true,
                }, 
				category_id: {
                    required : true,
                }, 
                
            },
            messages :{
                subcategory_name: {
                    required : 'Please Enter SubCategory Name',
                }, 
				category_id: {
                    required : 'Please Select Category Name',
                }, 
                 

            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>






@endsection