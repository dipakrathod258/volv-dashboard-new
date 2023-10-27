@extends('layouts.app')

@section('title', 'All Articles')

@section("all_article_internal_css")

@endsection

<style type="text/css">
    #nav-color-change {
        background-color: #337AB7;
        border: none;
        padding-bottom: 28px;
        /* width: 1840px; */
    }

    #button-color-change {
        background-color: #E8582B;
        border: none;
    }

    .pagination li {
        cursor: pointer;
    }

    .main_section {
        /* width: 1373px; */
    }

    #article_table .btn-primary {
        background-color: #FF7F50 !important;
        border-color: #FF7F50 !important;
    }

    .delete_article_success_msg {
        display: none;
    }

    .btn-edited,
    .btn-edited:hover,
    .btn-edited:focus {
        color: #fff;
        background-color: #a91b47;
    }

    .btn-republished,
    .btn-republished:hover,
    .btn-republished:focus {
        color: #fff;
        background-color: #286090;
    }


    /*--thank you pop starts here--*/
    .thank-you-pop {
        width: 100%;
        padding: 20px;
        text-align: center;
    }

    .thank-you-pop img {
        width: 76px;
        height: auto;
        margin: 0 auto;
        display: block;
        margin-bottom: 25px;
    }

    .thank-you-pop h1 {
        font-size: 42px;
        margin-bottom: 25px;
        color: #5C5C5C;
    }

    .thank-you-pop p {
        font-size: 20px;
        margin-bottom: 27px;
        color: #5C5C5C;
    }

    .thank-you-pop h3.cupon-pop {
        font-size: 25px;
        margin-bottom: 40px;
        color: #222;
        display: inline-block;
        text-align: center;
        padding: 10px 20px;
        border: 2px dashed #222;
        clear: both;
        font-weight: normal;
    }

    .thank-you-pop h3.cupon-pop span {
        color: #03A9F4;
    }

    .thank-you-pop a {
        display: inline-block;
        margin: 0 auto;
        padding: 9px 20px;
        color: #fff;
        text-transform: uppercase;
        font-size: 14px;
        background-color: #8BC34A;
        border-radius: 17px;
    }

    .thank-you-pop a i {
        margin-right: 5px;
        color: #fff;
    }

    #ignismyModal .modal-header {
        border: 0px;
    }

    .edit_scheduler_btn {
        display: none;
    }
</style>

@section("content")

<div class="row">
    <div class="table-responsive">
        <table id="articles_table" class="table table-striped table-bordered table-sm js-dynamitable " cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Article Image</th>
                    <th>Category</th>
                    <th style="width: 33%;"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;Articles</th>
                    <th><i class="fa fa-user"></i>&nbsp;Author</th>
                    <th><i class="fa fa-clock-o"></i>&nbsp;Last Updated</th>
                    <th>Status</th>
                    <th><i class='fa fa-clock-o'></i>&nbsp;Scheduler</th>
                    <th>Action</th>
                </tr>
            
                <tr>
                    <th>Article Image</th>
                    <th>Category</th>
                    <th style="width: 33%;"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;Articles</th>
                    <th><i class="fa fa-user"></i>&nbsp;Author</th>
                    <th><i class="fa fa-clock-o"></i>&nbsp;Last Updated</th>
                    <th><select>
                        <option value="Published">Published</option>
                        <option value="Weekend">Weekend</option>
                        <option value="Republished">Republished</option>
                        <option value=""></option>
                        <option value=""></option>

                    </select></th>
                    <th><i class='fa fa-clock-o'></i>&nbsp;Scheduler</th>
                    <th>Action</th>
                </tr>
                
            </thead>
            <tbody id="myTable">
                @foreach($articles as $article)


                <tr id="{{$article->id}}" class="task-list-row" data-task-id="1" data-user="{{$article->article_author}}" @foreach($article_statuses as $article_status) @if($article_status->status ==$article->article_status)
                    data-status="{{$article_status->status}}"
                    @endif
                    @endforeach
                    data-milestone="{{ $article->article_category}}"
                    @foreach($priorities as $priority)
                    @if($priority == $article->priority_button_class)
                    data-priority="{{$priority}}"
                    @endif
                    @endforeach


                    data-tags="Tag 2"
                    >
                    <td>
                        <img src="{{$article->article_image}}" width="150" />
                    </td>
                    <td>
                        <span>{{ $article->article_category}}</span>
                    </td>
                    <td>
                        <span><b>{{ $article->article_heading}}</b></span>
                        <p style="margin-top: 15px; text-align: justify;">{{ $article->article_summary}}</p>
                        <p style="color: #337ab7;"><span><b>Word count: <span class="text-success">{{ str_word_count($article->article_summary) }}</span></b></span>&nbsp;<span class="pull-right"><b>Character Count: <span class="text-success">{{ strlen($article->article_summary) }}</span></b></span></p>
                    </td>

                    <td>

                        {{$article->article_author}}
                        <br />
                        <a href="{{ url('article_authory_history') }}/{{$article->id}}" target="_blank"><b>History</b></a>

                    </td>

                    <td>
                        {{$article->time_ago}}
                        <br>
                        <br>
                        @if(isset($article->time_stamp))
                        {{$article->time_stamp}}
                        @endif
                    </td>

                    <td>

                        <div class="form-group" style="width: 140px;">

                            <select class="form-control article{{$article->id}} {{$article->button_class}} article_status" onchange="changeArticleStatus({{ $article->id }}, $(this).val())" id="{{$article->id}}">
                                @foreach($article_statuses as $article_status)
                                @if($article_status->status ==$article->article_status)
                                <option value="{{$article_status->status}}" selected="selected">{{$article_status->status}}</option>
                                @elseif($article_status->status !=$article->article_status)
                                <option value="{{$article_status->status}}">{{$article_status->status}}</option>
                                @endif
                                @endforeach
                            </select>


                        </div>
                    </td>

                    <td style="width: 15%;">
                        @if(isset($article->publish_datetime) && $article->article_status !="Rollback")
                        <span class="pub_date_time{{ $article->id }}"><b>{{ $article->publish_datetime }}</b></span>
                        <br>
                        @endif
                        <input type="text" class='form-control date-format datetime{{$article->id}}' placeholder="Choose datetime..." value="" name='schedule_time'>
                        <br>
                        <button class='btn btn-success schedule_btn' id="{{ $article->id }}">Schedule</button>


                    </td>

                    <td>
                        <a href="{{ url('/view_articles') }}/{{$article->id}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                        <a href="{{ url('/edit_articles') }}/{{$article->id}}" class="btn btn-primary article_id{{$article->id}}" {{($article->article_status=="Published")? " style= disabled":""}}><i class="fa fa-edit"></i></a>
                        <br>
                        <!--   <a href="{{ url('/delete_articles') }}/{{$article->id}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
 -->
                        <a type="button" class="btn btn-danger article_delete_modal_btn" onclick="deleteArticle({{ $article->id }})" data-toggle="modal" data-target="#myModal" id="{{$article->id}}"><i class="fa fa-trash" title="Delete"></i></a>

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/scroller/2.0.2/js/dataTables.scroller.min.js"></script>
<script>
    $(document).ready( function () {
    
    // $('#myTable')

    $('#articles_table thead tr:eq(1) th').each( function () {
        if ($(this).index()!=5){
        var title = $('#articles_table thead tr:eq(0) th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        }
    }); 
    var table = $('#articles_table').DataTable({
            // 'processing': true,
            // 'serverSide': true,
            // 'ajax':{
            //     'url': '/authors_filter',
            //     'type':'GET',
            // },
            // scroller: {
            //     loadingIndicator: true
            // }
        });
    //     columnDefs: [
    //      { 
    //         targets: [1,6],
    //         "defaultContent": "-",
    //         "targets": "_all", 
    //         type: 'string',
    //         render: function(data, type, full, meta){
    //            if (type === 'filter' || type === 'sort') {
    //               var api = new $.fn.dataTable.Api(meta.settings);
    //               var td = api.cell({row: meta.row, column: meta.col}).node();
    //               data = $('input[type="text"],select', td).val();
    //            }

    //            return data;
    //         }
    //      }
    //   ]
    // });

    // Apply the search
    table.columns().every(function (index) {
        if (index==5){
            $('#articles_table thead tr:eq(1) th:eq(' + index + ') select').on('change', function () {
            console.log($(this).parent().index(),index,this.value);
            var val=this.value;
            table.column(index).search(val).draw();
        });
        }
        else{
            $('#articles_table thead tr:eq(1) th:eq(' + index + ') input').on('keyup change', function () {
        
            table.column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();
        });
        }

    });
   $('#articles_table').on('change', 'tbody select, tbody input[type="text"]', function(){
      table.cell($(this).closest('td')).invalidate();
   });
  
});
</script>
@endsection