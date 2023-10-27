@extends('layouts.app')

@section('title', 'Volv App Referrals')

@section('content')

<div class="container">
    <div class="row">
        <h3><u>App Referrals:</u></h3>        
    </div>
    <div class="row">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>App User</th>
                    <th>Referred to</th>
                </tr>
            </thead>
            <tbody>
                @foreach($referrals as $key => $d)
                <tr>
                    <td>{{ $key }}</td> 
                    <td>
                        <ul>
                            @foreach($d as $x)
                            <li>{{ $x }}</li>
                            @endforeach
                        </ul>
                    </td>          
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection