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
								<li class="breadcrumb-item active" aria-current="page">Site Setting</li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
				
				<div class="card">
							<div class="card-body p-4">
								<h5 class="mb-4">Edit Site Settings</h5>
								<form id="myForm" action="{{ route('update.site') }}" method="post"  class="row g-3" enctype="multipart/form-data">
									@csrf

                                    <input type="hidden" name="id" value="{{ $site->id }}" >

									<div class="form-group col-md-6">
										<label for="input1" class="form-label">Phone</label>
										<input type="text" class="form-control" id="input1" name="phone" value="{{ $site->phone }}">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Email</label>
										<input type="email" class="form-control" id="input1" name="email" value="{{ $site->email }}">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Address</label>
										<input type="text" class="form-control" id="input1" name="address" value="{{ $site->address }}">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Facebook Link</label>
										<input type="text" class="form-control" id="input1" name="facebook" value="{{ $site->facebook }}">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Twitter Link</label>
										<input type="text" class="form-control" id="input1" name="twitter" value="{{ $site->twitter }}">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Instagram Link</label>
										<input type="text" class="form-control" id="input1" name="instagram" value="{{ $site->instagram }}">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Copyright</label>
										<input type="text" class="form-control" id="input1" name="copyright" value="{{ $site->copyright }}">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input2" class="form-label">Site Logo</label>
										<input class="form-control" name="logo" type="file" id="image">
									</div>

                                    <div class="form-group col-md-6">

									</div>

									<div class="col-md-6">
									<img id="showImage" src="{{ asset($site->logo) }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="80">
									</div>
									
									
									<div class="col-md-12">
										<div class="d-md-flex d-grid align-items-center gap-3">
											<button type="submit" class="btn btn-primary px-4">Update Site Settings</button>
											
										</div>
									</div>
								</form>
							</div>
						</div>
				
				
</div>



<script type="text/javascript">

    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

</script>





@endsection