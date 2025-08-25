<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="{{asset ('backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Admin</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
				</div>
			 </div>
			<!--navigation-->
			<ul class="metismenu" id="menu">

				<li>
					<a href="{{ route('admin.dashboard') }}">
						<div class="parent-icon"><i class='bx bx-home-alt'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>

				
				
				<li class="menu-label">UI Elements</li>
				
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">Manage Category</div>
					</a>
					<ul>
						<li> <a href="{{route('all.category')}}"><i class='bx bx-radio-circle'></i>All Category</a>
						</li>
						<li> <a href="{{route('all.subcategory')}}"><i class='bx bx-radio-circle'></i>All Sub-Category</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
						</div>
						<div class="menu-title">Manage Instructors</div>
					</a>
					<ul>
						<li> <a href="{{ route('all.instructor') }}"><i class='bx bx-radio-circle'></i>All Instructors</a>
						</li>
						
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
						</div>
						<div class="menu-title">Manage Courses</div>
					</a>
					<ul>
						<li> <a href="{{ route('admin.all.courses') }}"><i class='bx bx-radio-circle'></i>All Courses</a>
						</li>
						
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
						</div>
						<div class="menu-title">Manage Coupons</div>
					</a>
					<ul>
						<li> <a href="{{ route('admin.all.coupons') }}"><i class='bx bx-radio-circle'></i>All Coupons</a>
						</li>
						
					</ul>
				</li>

				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
						</div>
						<div class="menu-title">Manage Orders</div>
					</a>
					<ul>
						<li> <a href="{{ route('admin.pending.orders') }}"><i class='bx bx-radio-circle'></i>Pending Orders</a></li>
						<li> <a href="{{ route('admin.confirmed.orders') }}"><i class='bx bx-radio-circle'></i>Confirmed Orders</a></li>
						
					</ul>
				</li>

				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
						</div>
						<div class="menu-title">Manage Report</div>
					</a>
					<ul>
						<li> <a href="{{ route('report.view') }}"><i class='bx bx-radio-circle'></i>View Report</a></li>
					</ul>
				</li>

				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
						</div>
						<div class="menu-title">Manage Course Reviews</div>
					</a>
					<ul>
						<li> <a href="{{ route('admin.pending.review') }}"><i class='bx bx-radio-circle'></i>Pending Reviews</a></li>
						<li> <a href="{{ route('admin.approved.review') }}"><i class='bx bx-radio-circle'></i>Approved Reviews</a></li>
					</ul>
				</li>

				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
						</div>
						<div class="menu-title">Manage All Users</div>
					</a>
					<ul>
						<li> <a href="{{ route('admin.all.user') }}"><i class='bx bx-radio-circle'></i>All Users</a></li>
						<li> <a href="{{ route('admin.all.instructor') }}"><i class='bx bx-radio-circle'></i>All Instructors</a></li>
					</ul>
				</li>

				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
						</div>
						<div class="menu-title">Manage Settings</div>
					</a>
					<ul>
						<li> <a href="{{ route('smtp.setting') }}"><i class='bx bx-radio-circle'></i>Manage SMTP</a>
						</li>
						
					</ul>
				</li>
				
				
				<li class="menu-label">Charts & Maps</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-line-chart"></i>
						</div>
						<div class="menu-title">Charts</div>
					</a>
					<ul>
						<li> <a href="charts-apex-chart.html"><i class='bx bx-radio-circle'></i>Apex</a>
						</li>
						<li> <a href="charts-chartjs.html"><i class='bx bx-radio-circle'></i>Chartjs</a>
						</li>
						<li> <a href="charts-highcharts.html"><i class='bx bx-radio-circle'></i>Highcharts</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-map-alt"></i>
						</div>
						<div class="menu-title">Maps</div>
					</a>
					<ul>
						<li> <a href="map-google-maps.html"><i class='bx bx-radio-circle'></i>Google Maps</a>
						</li>
						<li> <a href="map-vector-maps.html"><i class='bx bx-radio-circle'></i>Vector Maps</a>
						</li>
					</ul>
				</li>
				
				<li>
					<a href="https://codervent.com/rocker/documentation/index.html" target="_blank">
						<div class="parent-icon"><i class="bx bx-folder"></i>
						</div>
						<div class="menu-title">Documentation</div>
					</a>
				</li>
				<li>
					<a href="https://themeforest.net/user/codervent" target="_blank">
						<div class="parent-icon"><i class="bx bx-support"></i>
						</div>
						<div class="menu-title">Support</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>