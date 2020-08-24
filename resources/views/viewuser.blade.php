@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"></div>

                    <div class="card-body">


                        <div class="container">
                            <div class="text-center">

                                <img width="300px" height="300px" class="rounded-circle"
                                     src="../public/images/{{$user->thumbnailUrl}}">
                                <br>
                                <br>
                                <h4>Name: {{$user->name}} </h4>
                                <h4>Joined: {{$user->created_at}} </h4>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

@endsection
