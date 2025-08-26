<!doctype html>
<html lang="en">



<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{asset ('backend/assets/images/favicon-32x32.png') }}" type="image/png"/>

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!--plugins-->
	<link href="{{asset ('backend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
	<link href="{{asset ('backend/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{asset ('backend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{asset ('backend/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet"/>
	<!-- loader-->
	<link href="{{asset ('backend/assets/css/pace.min.css') }}" rel="stylesheet"/>
	<script src="{{asset ('backend/assets/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{asset ('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{asset ('backend/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{asset ('backend/assets/css/app.css') }}" rel="stylesheet">
	<link href="{{asset ('backend/assets/css/icons.css') }}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{asset ('backend/assets/css/dark-theme.css') }}"/>
	<link rel="stylesheet" href="{{asset ('backend/assets/css/semi-dark.css') }}"/>
	<link rel="stylesheet" href="{{asset ('backend/assets/css/header-colors.css') }}"/>

	<!-- DataTable CSS -->
	<link href="{{ asset('backend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

	{{-- <script src="https://cdn.tiny.cloud/1/g8h4e0vcwmgbwqgky5uib09vca5luj6ns027wba6e11goojc/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script> --}}

	<!-- Place the first <script> tag in your HTML's <head> -->
	<script src="https://cdn.tiny.cloud/1/g8h4e0vcwmgbwqgky5uib09vca5luj6ns027wba6e11goojc/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

	<title>Instructor Dashboard</title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
            @include('instructor.body.sidebar')
		<!--end sidebar wrapper -->
		<!--start header -->
        @include('instructor.body.header')
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			@yield('instructor')
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		 <div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button-->
		  <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		@include('instructor.body.footer')
	</div>
	<!--end wrapper-->







	<!-- Bootstrap JS -->
	<script src="{{asset ('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{asset ('backend/assets/js/jquery.min.js') }}"></script>
	<script src="{{asset ('backend/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{asset ('backend/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
	<script src="{{asset ('backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
	<script src="{{asset ('backend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{asset ('backend/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
	<script src="{{asset ('backend/assets/plugins/chartjs/js/chart.js') }}"></script>
	<script src="{{asset ('backend/assets/js/index.js') }}"></script>

	<script>
		new PerfectScrollbar('.chat-list');
		new PerfectScrollbar('.chat-content');
	</script>

	<!--app JS-->
	<script src="{{asset ('backend/assets/js/app.js') }}"></script>
	<script src="{{asset ('backend/assets/js/validate.min.js') }}"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

	<script src="{{ asset('backend/assets/js/code.js') }}"></script>

	<script>
		new PerfectScrollbar(".app-container")
	</script>

	<!--DataTable JS-->
	<script src="{{asset ('backend/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{asset ('backend/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		  } );
	</script>
	<!--End DataTable JS-->
	

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
 @if(Session::has('message'))
 var type = "{{ Session::get('alert-type','info') }}"
 switch(type){
    case 'info':
    toastr.info(" {{ Session::get('message') }} ");
    break;

    case 'success':
    toastr.success(" {{ Session::get('message') }} ");
    break;

    case 'warning':
    toastr.warning(" {{ Session::get('message') }} ");
    break;

    case 'error':
    toastr.error(" {{ Session::get('message') }} ");
    break; 
 }
 @endif 
</script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>




</body>

</html>


