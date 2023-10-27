@extends("layouts.app")
@section('title', 'Publishers')
@section('content')  
		<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h3>Articles by {{ $publisher->publisher_title }}:</h3>
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<!-- <th>Sr. No.</th> -->
						<th>Article Image</th>
						<th>Article Title</th>
						<th>Publisher Content</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($publisher_articles as $publisher_article)
					<tr>
						<td>
							<img src="{{ url('/') }}/{{ $publisher_article->article_image }}">
						</td>
						<td>
							<a href="/publisher_articles/{{$publisher->id}}">{{$publisher_article->article_heading}}</a>
						</td>						
<!-- 						<td>
							@if(isset($publisher->publisher_image_path))
								<img src="{{$publisher->publisher_image_path}}" width="100">
							@endif
						</td>
						<td>
							{{ $publisher->publisher_content }}
						</td>
						<td>

							<a href="/edit_publisher/{{$publisher->id}}" class="btn publish_btn" title="Edit">
								<i class="fa fa-edit"></i>
							</a>
				              <a type="button" class="delete_article_modal publish_btn btn" data-toggle="modal" data-target="#myModal"><i class="fa fa-trash" title="Delete"></i></a>
						</td>
					</tr>

		          <div id="myModal" class="modal fade" role="dialog">
		            <div class= -->

		              <!-- Modal content-->
<!-- 		              <div class="modal-content">
		                <div class="modal-header">
		                  <button type="button" class="close" data-dismiss="modal">&times;</button>
		                  <h4 class="modal-title"><i class="fa fa-trash"></i>&nbsp;Delete Publisher</h4>
		                </div>
		                <div class="modal-body">
		                  <p>Are you sure, you want to delete this Publisher?</p>
		                </div>
		                <div class="modal-footer">
		                  <a id="delete_modal" href="{{ url('/delete_publisher') }}/{{ $publisher->id }}" class="btn publish_btn"><i class="fa fa-trash"></i></a>
		                </div>
		              </div>
 -->
			            </div>
			          </div>
					@endforeach
				</tbody>
			</table>			
		</div>
	</div>
</div>
@endsection