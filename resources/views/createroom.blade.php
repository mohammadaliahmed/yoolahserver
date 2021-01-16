@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')

    @if($user->email_verified==0)
        <div class="alert alert-danger" role="alert">

            Your email is not verified. Please check email
        </div>
    @else

        <div class="container-fluid">


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Rooms</h3>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body  table-bordered table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th>Id#</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Members</th>
                                    <th>Members Limit</th>
                                    <th>Created At</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($rooms as $day)



                                    <tr>
                                        <td class="sorting_1">{{$day->id}}</td>
                                        <td>{{$day->title}}</td>
                                        <td>{{$day->subtitle}}</td>
                                        <td>{{$day->memeberSize}}</td>
                                        <td>{{$day->members}}</td>
                                        <td>{{$day->created_at}}</td>

                                        <th><a href="viewroom/{{$day->id}}"
                                               class="btn btn-primary" data-toggle="tooltip"
                                               title="Show Details">View</a>
                                        </th>

                                    </tr>

                                @endforeach


                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

        </div>






        <div class="col-md-12">
            <br>
            <div class="card">
                <div class="card-header">Create Group</div>


                <div class="card-body">
                    <form method="POST" action="{{ route('createroom') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control @error('title') is-invalid @enderror" name="title"
                                       value="{{ old('title') }}" required autocomplete="name" autofocus>

                                @error('title')
                                <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Subtitle') }}</label>

                            <div class="col-md-6">
                                <input id="subtitle" type="text"
                                       class="form-control @error('subtitle') is-invalid @enderror"
                                       name="subtitle"
                                       value="{{ old('subtitle') }}" required autocomplete="subtitle" autofocus>

                                @error('subtitle')
                                <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="members"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Members') }}</label>

                            <div class="col-md-6">
                                <input id="members" type="number"
                                       class="form-control @error('members') is-invalid @enderror"
                                       name="members"
                                       value="{{ old('members') }}" required autocomplete="members" autofocus>

                                @error('members')
                                <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center">


                            <button type="submit" class="btn btn-primary  ">Create Group</button>
                        </div>
                    </form>


                </div>
            </div>

        </div>
    @endif


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
