@include('base')
@include('layouts/header')
<div class="container">
	<div class="row pull-right">
		<a href="{{ url('/create_trending_category') }}" class="btn btn-info">Create Trending Category&nbsp;<i class="fa fa-plus"></i></a>
<!-- 		<a href="{{ url('/export_categories_xls') }}" class="btn btn-primary">Export XLS&nbsp;<i class="fa fa-file-excel-o"></i></a>
		<a href="{{ url('/export_categories_pdf') }}" class="btn btn-success">Export PDF&nbsp;<i class="fa fa-file-pdf-o"></i></a> -->
	</div>
	<div class="row">
		<div class="col-sm-12">
			<h3>Trending Category Details:</h3>
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Sr. No.</th>
						<th>TC Title</th>
						<th>TC Image</th>
						<th>TC Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($trending_categories as $category)
					<tr>
						<td>{{$category->id}}</td>
						<td>{{$category->trending_title}}</td>
						<td>
							@if(isset($category->trending_image))
								<img src="{{ url('/') }}/{{ $category->trending_image}}" width="40px">
							@endif
						</td>
						<td>{{$category->trending_status}}</td>
						<td>
							<a href="/view_category/{{$category->id}}" class="btn publish_btn" title="View">
								<i class="fa fa-eye"></i>
							</a>
							<a href="/edit_author/{{$category->id}}" class="btn publish_btn" title="Edit">
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