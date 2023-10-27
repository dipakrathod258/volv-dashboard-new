@foreach($data as $article)
    
    <div class="row" style="margin-top: 5px; margin-bottom: 5px; border: 1px solid #ccc; padding: 10px;  border-radius: 5px;">

        <div class="col-sm-3">
            @if($article->source_name == 'CNBC')
              <img src="{{ url('/assets/imgs/sources/cnbc.gif') }}" width="150" alt="" style="border-radius: 5px;">
            @elseif($article->source_name == 'CNN')
              <img src="{{ url('/assets/imgs/sources/cnn.png') }}" width="150" alt="" style="border-radius: 5px;">
            @elseif($article->source_name == 'BBC')
              <img src="{{ url('/assets/imgs/sources/bbc.png') }}" width="150" alt="" style="border-radius: 5px;">
            @elseif($article->source_name == 'Wall Street Journal')
              <img src="{{ url('/assets/imgs/sources/wsj.png') }}" width="150" alt="" style="border-radius: 5px;">
            @elseif($article->source_name == 'Daily mail')
            <img src="{{ url('/assets/imgs/sources/daily_mail.png') }}" width="150" alt="" style="border-radius: 5px;">
            @elseif($article->source_name == 'The Hill')
            <img src="https://thehill.com/sites/all/themes/thehill/images/redesign/thehill-logo-big.png" width="150" alt="" style="border-radius: 5px;">
            @endif
        </div>
        <div class="col-sm-6">
            <a href="{{ $article->main_source }}" target="_blank">
                <h4><b>{{ $article->article_title }}</b></h4>
            </a>
            <p>{{ $article->article_description }}</p>
            <p>
                <span><i class='fa fa-clock-o'></i>&nbsp;Published at: <b>{{ $article->published_date }}</b></span>
            </p>
        </div>
    </div>
@endforeach