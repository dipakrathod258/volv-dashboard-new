@foreach($articles as $key => $value)
<div class="container article{{$key}}">
	<div class="row">
		<div class="col-sm-2">
			<label><b>Priority:</b></label>
			<select class="form-control trending_news_priority article_priority{{$key}}" id="trending_news" index="{{$key}}">
				<option value="0|{{$key}}">--Select--</option>
				<option value="Important|{{$key}}">Important</option>
				<option value="Not Important|{{$key}}">Not Important</option>
			</select>
		</div>

		<div class="col-sm-8">
			<div class="card border border-secondary">
			    <div class="row">
				    <div class="col-sm-2">
						<a href="{{ $value['url'] }}" target="_blank"><img id="article_img" src="{{ $value['urlToImage'] }}" class="card-img-top" alt=""  width="150">
						</a>
						<p id="article_source_name" class="card-text" style="margin-left: 22px; margin-top: 5px;">
							@if(isset($value["tag"]))
								<small class="text-muted">Source: {{$value["tag"]}}</small>
							@endif
						</p>
						<p style="display: none;" class="article_url{{$key}}">{{ $value['url'] }}</p>
				  	</div>
				    <div class="col-sm-8">
						<h5 class="card-title article_title{{$key}}" style="margin-left: 18px; margin-top: 15px; margin-bottom: 0px;"> 
							<a href="{{ $value['url'] }}" target="_blank" style="text-decoration: none;  color:#337ab7 !important">{{ $value["title"] }}</a></h5>
						<div class="card-body">
							<p class="card-text" id="article_description">{{ $value["description"] }}</p>
							<p class="card-text">
								<small class="" style="font-weight: bold; color: #4a78d2;">Published {{ $value["date"] }}</small>
							</p>
					    </div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-2">
			<label  style=""><b>Status:</b></label>
			<select class="form-control trending_news_select_user{{$key}} color_card" id="trending_news_select_user" data-index="{{$key}}">
				<option value="--Select--">--Select--</option>
				<option value="Pending">Pending</option>
				<option value="In Progress">In Progress</option>
			</select>
			<!-- <button type="button" class="btn btn-info submit_trending_article{{$key}}">Add me</button> -->
		</div>
	</div>	
</div>
@endforeach
</div>
