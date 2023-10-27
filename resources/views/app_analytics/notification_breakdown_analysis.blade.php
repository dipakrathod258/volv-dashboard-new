
@extends('layouts.app')
<style type="text/css">
    .thumbnail {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5);
    transition: 0.3s;
    min-width: 40%;
    border-radius: 5px;
    }

    .thumbnail-description {
    min-height: 40px;
    }

    .thumbnail:hover {
    cursor: pointer;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 1);
    }
</style>
@section('title', 'Notification Breakdown Analytics')

@section('content')

<div class="container-fluid" style="padding: 2%">
    <div class="row">
        <h2 class="text-center"><strong>Notification Analysis Breakdown</strong></h2>
        <table class="container">
            <div class="row">
                
                <table class="table table-bordered table-hover table-striped text-center">
                    <thead>
                        <th>Month</th>
                        <th>Turned On & Gave permission</th>
                        <th>Turned On & No permission</th>
                        <th>Turned Off</th>
                        <th>Turned on Breaking but no Trending</th>
                        <th>Turned on Breaking & Trending</th>
                        <th>Turned off Breaking & Trending On</th>
                        <th>No of failures</th>
                        <th>Failure Breakdown1</th>
                        <th>Failure Breakdown2</th>
                        <th>Failure Breakdown3</th>
                        <th>Failure Breakdown4</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Jan-2020</td>
                            <td>1200</td>
                            <td>3500</td>
                            <td>4500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                        </tr>
                        <tr>
                            <td>Feb-2020</td>
                            <td>1200</td>
                            <td>3500</td>
                            <td>4500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                        </tr>
                        <tr>
                            <td>March-2020</td>
                            <td>1200</td>
                            <td>3500</td>
                            <td>4500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                        </tr>
                        <tr>
                            <td>April-2020</td>
                            <td>1200</td>
                            <td>3500</td>
                            <td>4500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                        </tr>
                        <tr>
                            <td>May-2020</td>
                            <td>1200</td>
                            <td>3500</td>
                            <td>4500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                        </tr>

                        <tr>
                            <td>June-2020</td>
                            <td>1200</td>
                            <td>3500</td>
                            <td>4500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                        </tr>
                        <tr>
                            <td>July-2020</td>
                            <td>1200</td>
                            <td>3500</td>
                            <td>4500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                        </tr>
                        <tr>
                            <td>Aug-2020</td>
                            <td>1200</td>
                            <td>3500</td>
                            <td>4500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                        </tr>
                        <tr>
                            <td>Sept-2020</td>
                            <td>1200</td>
                            <td>3500</td>
                            <td>4500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                        </tr>
                        <tr>
                            <td>Oct-2020</td>
                            <td>1200</td>
                            <td>3500</td>
                            <td>4500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                            <td>3500</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            
        </table>
    </div>
</div>

@endsection