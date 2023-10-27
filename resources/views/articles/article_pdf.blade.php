<div class="container">
	<div class="row">
		<h4><b>Articles:</b></h4>
		<table class="table table-bordered table-hover table-striped" style="width:100%; border-collapse: collapse;">
			<thead>
				<tr>
					<th>Article Heading</th>
					<th>Summary</th>
					<th>Category</th>
					<th>Author</th>
					<th>Last updated</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				@foreach($articles as $article)
				<tr>
					<td>{{$article->article_heading}}</td>
					<td>{{$article->article_summary}}</td>
					<td>{{$article->article_category}}</td>
					<td>{{$article->article_author}}</td>
					<td>{{$article->updated_at}}</td>
					@if($article->publish_article == 'Y')
						<td><b class="text-success">Published</b></td>
					@elseif($article->publish_article == 'N')
						<td><b>In Review</b></td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>