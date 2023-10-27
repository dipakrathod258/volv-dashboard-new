@extends("layouts.app")
@section('title', 'Categories')
@section('content')  
		<div class="container">
	<div class="row pull-right">
		<a href="{{ url('/create_new_category') }}" class="btn btn-info">Create New Category&nbsp;<i class="fa fa-plus"></i></a>
<!-- 		<a href="{{ url('/export_categories_xls') }}" class="btn btn-primary">Create New Category&nbsp;<i class="fa fa-file-excel-o"></i></a>
		<a href="{{ url('/export_categories_pdf') }}" class="btn btn-success">Create New Category&nbsp;<i class="fa fa-file-pdf-o"></i></a> -->
	</div>
	<div class="row">
		<div class="col-sm-12">
			<h3>Category Details:</h3>
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<!-- <th>Sr. No.</th> -->
						<th>Category Title</th>
						<th>Category Image</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($categories as $category)
					<tr>
						<!-- <td>{{$category->id}}</td> -->
						<td>{{$category->category_title}}</td>						
						<td>
							@if(isset($category_image_path))
								<img src="{{url('/')}}/{{$category->category_image_path}}" width="100">
							@endif
						</td>
						<td>
							<!-- <a href="/view_category/{{$category->id}}" class="btn publish_btn" title="View"> -->
								<!-- <i class="fa fa-eye"></i> -->
							<!-- </a> -->
							<a href="/edit_category/{{$category->id}}" class="btn publish_btn" title="Edit">
								<i class="fa fa-edit"></i>
							</a>
				              <a type="button" class="delete_article_modal publish_btn btn" data-toggle="modal" data-target="#myModal"><i class="fa fa-trash" title="Delete"></i></a>
						</td>
					</tr>

		          <div id="myModal" class="modal fade" role="dialog">
		            <div class="modal-dialog">

		              <!-- Modal content-->
		              <div class="modal-content">
		                <div class="modal-header">
		                  <button type="button" class="close" data-dismiss="modal">&times;</button>
		                  <h4 class="modal-title"><i class="fa fa-trash"></i>&nbsp;Delete Category</h4>
		                </div>
		                <div class="modal-body">
		                  <p>Are you sure, you want to delete this Category?</p>
		                </div>
		                <div class="modal-footer">
		                  <a id="delete_modal" href="{{ url('/delete_category') }}/{{ $category->id }}" class="btn publish_btn"><i class="fa fa-trash"></i></a>
		                </div>
		              </div>

			            </div>
			          </div>
					@endforeach
				</tbody>
			</table>			
		</div>
	</div>
</div>
@endsection