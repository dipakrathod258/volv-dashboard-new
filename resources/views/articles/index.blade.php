@include('base')
@include('layouts/header')
<style type="text/css">
  marquee {
    font-weight: bold;
    color: #337ab7;
  }
  .create_article_btn {
  	border-radius: 25px !important;
  }
</style>

<div class="container"> 
  <div class="row pull-right">
    <a href="{{ url('/create_articles') }}" class="btn btn-info create_article_btn">Create New Article&nbsp;<i class="fa fa-plus"></i></a>
    <a href="{{ url('/downloadExcel') }}" class="btn btn-primary">Download Excel&nbsp;<i class="fa fa-file-excel-o"></i></a>
    <a href="{{ url('/export_article_pdf') }}" class="btn btn-success">Download PDF&nbsp;<i class="fa fa-file-pdf-o"></i></a>
  </div>
  <div class="row">
<!--     <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
      <a href="#">Click here for New Articles</a>
    </marquee> -->

  </div>
<!--   <div class="row">
    <div class="col-sm-4">
      <p>Welcome to Google</p>
    </div>
    <div class="col-sm-4">
      <p>Welcome to Facebook</p>
    </div>
    <div class="col-sm-4">
      <p>Welcome to Microsoft</p>
    </div>
  </div>
 -->  
  <div class="row">
    <div class="table-responsive">
      <table class="table table-striped dataTable dashbopard_panel">
        <thead>
          <tr>
            <th>Article Image</th>
            <th>Heading</th>
            <th>Category</th>
            <th>Articles</th>
            <th>Author</th>
            <th>Last Updated</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($articles as $article)

          @if($article->notification_sent_status ==1)
          <tr style="background-color: #ccc;">

          @elseif($article->notification_sent_status ==0)
            <tr>
            <td>
              <img src="{{ $article->article_image }}" width="150" style="border-radius: 135px;">
            </td>
            <td>
              <span><b>{{ $article->article_heading }}</b></span>
            </td>
            <td>{{ $article }}</td>
            <td>
              <p style="margin-top: 15px;">{{ $article->article_summary }}</p>
            </td>
            <td>{{ $article->article_author }}</td>
            <td>{{ $article->updated_at }}</td>
            <td>Draft (In Review)</td>
            <td>
              <a href="{{ url('/edit_articles') }}/{{ $article->id }}" class="btn publish_btn" disabled="disabled"><i class="fa fa-edit" aria-hidden="true"></i></a>
              <a href="{{ url('/publish_article') }}" class="btn publish_btn"><i class="fa fa-upload" aria-hidden="true"></i></a>
              <!-- <a href="{{ url('/delete_articles') }}/{{ $article->id }}" class="btn publish_btn"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
              <a type="button" class="delete_article_modal btn publish_btn" data-toggle="modal" data-target="#myModal"><i class="fa fa-trash"></i></button>              

            </td>
          </tr>
          <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-trash"></i>&nbsp;Delete Article</h4>
                </div>
                <div class="modal-body">
                  <p>Are you sure, you want to delete this Article?</p>
                </div>
                <div class="modal-footer">
                  <a id="delete_modal" href="{{ url('/delete_articles') }}/{{ $article->id }}" class="btn publish_btn"><i class="fa fa-trash"></i></a>
                </div>
              </div>

            </div>
          </div>

        @endforeach


<!--           <tr>
            <td>
              <img src="{{ url('assets/imgs/20190503180825-2019-05-03articles180632.jpg') }}">
            </td>
            <td>Trending</td>
            <td>
              <span><b>Vladimir Putin wants his own Internet for Russia</b></span>
            </td>
            <td>
              <p style="margin-top: 15px;">Donald Trump has a new cybersecurity strategy which is designed to hack into systems of adversaries such as Russia when push comes to shove. To combat this, Putin is trying to create a private, centralized Internet via which authorities can manage and, if needed, halt data traffic into, out of, and inside Russia. But naysayers believe that it is an attempt to keep civil unrest and dissent in check.</p>
            </td>
            <td>Shannon Almeida</td>
            <td>2019-05-03 16:38:25</td>
            <td>Draft (In Review)</td>
            <td>
              <a href="{{ url('/edit_article') }}" class="btn publish_btn"><i class="fa fa-edit" aria-hidden="true"></i></a>
              <a href="{{ url('/publish_article') }}" class="btn publish_btn"><i class="fa fa   " aria-hidden="true"></i></a>
              <a href="{{ url('/delete_article') }}" class="btn publish_btn"><i class="fa fa-trash" aria-hidden="true"></i></a>
            </td>
          </tr> -->
        </tbody>
      </table>
      
    </div>
  </div>
</div>
@if(isset($delete_flag))
<script type="text/javascript">
  $(function() {
    $("#delete_article_modal").modal();
  })
</script>
@endif

<div id="delete_article_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-trash"></i>&nbsp;Article Deleted</h4>
      </div>
      <div class="modal-body">
        <p>Article Deleted Successfully!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  $(function() {
    // $(".delete_article_modal").click(function(){
    // })
    function changeArticleStatus() {
      alert("ok")
    }

  })
</script>
</body>
</html>