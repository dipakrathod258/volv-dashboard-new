@include('base')
@include('layouts.header')
@include('trending_category.sidebar')

<div class="container">
	<h3>Trending Articles</h3>
	<div class="row">
		@foreach($articles as $value)
		<div class="col-sm-3">
			  <a href="{{ $value['url'] }}" target="_blank" style="text-decoration: none">
			<div class="card">
			  <img class="card-img-top" src="{{ $value['urlToImage'] }}" alt="Card image cap" width="250">
			  <div class="card-body">
			    <h5 class="card-title">{{ $value["title"] }}</h5>
			    <p class="card-text">{{ $value["description"] }}</p>
			    <p class="card-text"><small class="text-muted">Published at : {{ $value["publishedAt"] }}</small></p>
				  </div>
			</div>			
			 </a>
		</div>
		@endforeach
	</div>	
</div>