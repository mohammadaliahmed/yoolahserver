@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Room {{$room->title}}</div>

                    <div class="card-body">


                        <div class="container">
                            <div class="row">
                                <div class="col-sm">
                                </div>
                                <div class="col-sm">

                                    <img width="250px" src="../public/qr/{{$room->qr_code}}">
                                </div>
                                <div class="col-sm">

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <br>
                <br>

            </div>
        </div>
    </div>

@endsection
