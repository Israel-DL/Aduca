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
								<li class="breadcrumb-item active" aria-current="page">SMTP Setting</li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
				
				<div class="card">
							<div class="card-body p-4">
								<h5 class="mb-4">Edit SMTP Settings</h5>
								<form id="myForm" action="{{ route('update.smtp') }}" method="post"  class="row g-3" enctype="multipart/form-data">
									@csrf

                                    <input type="hidden" name="id" value="{{ $smtp->id }}" >

									<div class="form-group col-md-6">
										<label for="input1" class="form-label">Mailer</label>
										<input type="text" class="form-control" id="input1" name="mailer" value="{{ $smtp->mailer }}">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Host</label>
										<input type="text" class="form-control" id="input1" name="host" value="{{ $smtp->host }}">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Port</label>
										<input type="text" class="form-control" id="input1" name="port" value="{{ $smtp->port }}">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Username</label>
										<input type="text" class="form-control" id="input1" name="username" value="{{ $smtp->username }}">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Password</label>
										<input type="text" class="form-control" id="input1" name="password" value="{{ $smtp->password }}">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Encryption</label>
										<input type="text" class="form-control" id="input1" name="encryption" value="{{ $smtp->encryption }}">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">From Address</label>
										<input type="text" class="form-control" id="input1" name="from_address" value="{{ $smtp->from_address }}">
									</div>
									
									
									<div class="col-md-12">
										<div class="d-md-flex d-grid align-items-center gap-3">
											<button type="submit" class="btn btn-primary px-4">Update SMTP Settings</button>
											
										</div>
									</div>
								</form>
							</div>
						</div>
				
				
</div>





@endsection