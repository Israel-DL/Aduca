@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<!-- <div class="breadcrumb-title pe-3">All Category</div> -->
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Coupons</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<a href="{{route('admin.add.coupon')}}" class="btn btn-primary px-5">Add Coupon</a>
						</div>
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
										<th>Coupon Name</th>
                                        <th>Coupon Discount</th>
                                        <th>Coupon Validity</th>
                                        <th>Coupon Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>

                                    @foreach ($coupon as $key=> $item)
									<tr>
										<td>{{ $key+1 }}</td>
										<td>{{ $item->coupon_name }}</td>
										<td>{{ $item->coupon_discount }}%</td>
                                        <td>{{ Carbon\Carbon::parse($item->coupon_validity)->format('D, d F Y') }}</td>
                                        <td>
                                            	@if ($item->coupon_validity >= Carbon\Carbon::now()->format('Y-m-d'))
												<span class="badge bg-success">Still Valid</span>
												@else
												<span class="badge bg-danger">Expired</span>
												@endif
                                        </td>
										<td>
                                            <a href="{{ route('admin.edit.coupon',$item->id) }}" class="btn btn-info px-5">Edit</a>
                                            <a href="{{ route('admin.delete.coupon',$item->id) }}" class="btn btn-danger px-5" id="delete">Delete</a>
                                        </td>
										
									</tr>
                                    @endforeach
									
								</tbody>
								
							</table>
						</div>
					</div>
				</div>
				
				
</div>


@endsection