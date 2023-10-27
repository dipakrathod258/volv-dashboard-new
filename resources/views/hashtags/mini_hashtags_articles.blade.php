@extends('layouts.app')

@section('title','Create Article')

<style type="text/css">

/* allow room for 3 columns */
.minihastag ul
  {
    width: 35em;
  }  /* float & allow room for the widest item */
  .minihastag ul li
  {
    float: left;
    width: 10em;
  }  /* stop the float */
  br
  {
    clear: left;
  }  /* separate the list from subsequent markup */
  div.wrapper
  {
    margin-bottom: 1em;
  }
</style>

@section('content')
<div class="container-fluid" style="margin: 15px;">
    <div class="row">
        <h3><b>Mini Hashtags Articles: <a style="color: #E76933" href="{{ url('/searchHashtagArticle') }}/{{ $hashtag }}">#{{ $hashtag }}</a></b></h3>

        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif
    </div>
    <hr>
    <h4><b>Recently used mini hashtags:</b></h4>

    <div class="row" style="max-height: 300px; overflow: auto;border: 1px solid #ccc; border-radius: 5px; padding: 10px; background-color: #f4f4f4;">
    
    <ul class="list-inline">
        @foreach($miniHashTags as $mini)
            <li style="color: #E76933; line-height: 1.8">
                <a style="color: #E76933" href="{{ url('/searchHashtagArticle') }}/{{ $mini->sub_category }}">#{{$mini->sub_category}}</a>
            </li>
        @endforeach
    </ul>

    </div>

    <div class="row">
        <!-- <div class="col-sm-9 minihastag" style="border-right: 1px solid #ccc">

        </div> -->

            <h4><b>Articles created with mini hashtag: <a style="color: #E76933" href="{{ url('/searchHashtagArticle') }}/{{ $hashtag }}">#{{ $hashtag }}</a></b></h4>
            <table class="table table-bordered table-stri[ed table-hover">
                <thead>
                    <tr>
                        <td>Article Image</td>
                        <td>Article Heading</td>
                        <td>Created At</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @if(count($articles)>0)
                        @foreach($articles as $article)
                        <tr>
                            <td>
                                <img src="{{ $article->article_image }}" alt="" width="100">
                            </td>
                            <td>
                                <a href="{{ url('view_articles') }}/{{ $article->id }}">{{ $article->article_heading }}</a>
                            </td>
                            <td>
                                {{ $article->created_at }}
                            </td>
                            <td>
                                <a href="{{ url('/removeArticleHashtags') }}/{{$article->id}}/{{ $hashtag }}" class="btn btn-danger">Remove article</a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td><span class="text-danger">No article found.</span></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                </tbody>

            </table>
    </div>
</div>
@endsection