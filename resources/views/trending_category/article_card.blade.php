@foreach($articles as $key => $value)
<div style="        -ms-transform: scale(1.2); /* IE 9 */
  -webkit-transform: scale(1.2 )
  transform: scale(1.2); padding-left: 60px;" class="container article{{$key}}">
	<div class="row">
		<div class="col-sm-2 col-xs-2">
			<label><b>Priority:</b></label>
			<select class="form-control trending_news_priority article_priority{{$key}}" id="trending_news" index="{{$key}}">
				<option value="0|{{$key}}">--Select--</option>
				<option value="Urgent|{{$key}}">Urgent</option>
				<option value="Needs Coverage|{{$key}}">Needs Coverage</option>
				<!-- <option value="High|{{$key}}">High priority</option> -->
			</select>
		</div>
																																																																																																																																																																																									
		<div class="col-sm-8 col-xs-8">
			<div class="card border border-secondary">
			    <div class="row">
				    <div class="col-sm-2 col-xs-4">
						<a href="{{ $value['url'] }}" target="_blank"><img id="article_img" src="{{ $value['urlToImage'] }}" class="card-img-top" alt=""  width="150"> 
						</a>
						<p id="article_source_name" class="card-text" style="margin-left: 22px; margin-top: 5px;"><small class="text-muted">Source: {{$value["source"]["name"]}}</small></p>
						<p style="display: none;" class="article_url{{$key}}">{{ $value['url'] }}</p>
				  	</div>
				    <div class="col-sm-8">
						<h4 class="card-title article_title{{$key}}" style="margin-left: 18px; margin-top: 15px; margin-bottom: 0px;">{{ $value["title"] }}</h4>
						<div class="card-body">
							<p class="card-text" id="article_description">{{ $value["description"] }}</p>
							<p class="card-text">
								<small class="" style="font-weight: bold; color: #4a78d2;">Published {{ $value["publishedAt"] }}</small>
							</p>
					    </div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="col-sm-2 col-xs-2"> -->
			<!-- <label  style=""><b>Status:</b></label> -->
			<!-- <select class="form-control trending_news_select_user{{$key}} color_card" id="trending_news_select_user" data-index="{{$key}}"> -->
				<!-- <option value="--Select--">--Select--</option> -->
				<!-- <option value="Pending">Pending</option> -->
				<!-- <option value="In Progress">In Progress</option> -->
			<!-- </select> -->

			<!-- <button type="button" class="btn btn-info submit_trending_article{{$key}}">Add me</button> -->
		<!-- </div> -->
	</div>	
</div>
@endforeach
</div>
