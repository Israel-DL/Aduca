@extends('instructor.instructor_dashboard')
@section('instructor')


<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<!-- <div class="breadcrumb-title pe-3">All Category</div> -->
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Questions</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							
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
										<th>Course Name</th>
                                        <th>Subject</th>
                                        <th>Student Name</th>
                                        <th>Date</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>

                                    @foreach ($question as $key=> $item)
									<tr>
										<td>{{ $key+1 }}</td>
										<td>{{ $item['course']['course_name'] }}</td>
										<td><strong>{{ $item->subject }}</strong></td>
                                        <td>{{ $item['user']['name'] }}</td>
                                        <td>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
										<td>
                                            <a href="{{ route('instructor.question.details', $item->id) }}" class="btn btn-info" title="Order Details"><i class="lni lni-eye"></i></a>
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