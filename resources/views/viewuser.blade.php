@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"></div>

                    <div class="card-body">


                        <div class="container">
                            <div class="row">
                                <div class="col-sm">
                                </div>
                                <div class="col-sm">

                                    <img width="300px" height="300px" class="rounded-circle"
                                         src="../public/images/{{$user->thumbnailUrl}}">

                                    <h4>Name: {{$user->name}} </h4>
                                    <h4>Email: {{$user->email}} </h4>
                                    <h4>Phone:{{$user->phone}} </h4>
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
