@extends("layouts.app")
@section('title', 'Articles on App')

@section('content')

<div class="container main_section">
  <div class="row">
    <h3 class="text-success"><b><u>Articles on App:</u></b></h3>
  </div>
</div>
<div class="container-fluid main_section">
  <div class="row">
    <div class="table-responsive">
      <table id="article_table" class="table table-striped dataTable dashbopard_panel">
        <thead>
          <tr>
            <th>Article Image</th>
            <th>Category</th>
            <th style="width: 33%;"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;Articles</th>
            <th><i class="fa fa-user"></i>&nbsp;Author</th>
            <th><i class="fa fa-clock-o"></i>&nbsp;Last Updated</th>
            <!-- <th>Status</th> -->
            <th>Notification Text</th>
            <th>Status</th>
            <th>Action</th>
            <th>Activity</th>
          </tr>
        </thead>
        <tbody id="post-data">
          @include("articles.data")
        </tbody>
      </table>      
    </div>
  </div>
</div>
@endsection