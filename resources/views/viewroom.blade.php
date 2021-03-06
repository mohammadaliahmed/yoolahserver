@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Room {{$room->title}}</div>

            <div class="card-body">


                <div class="container">

                    <div class="text-center">


                        {{--<img width="250px" src="../public/qr/{{$room->qr_code}}">--}}
                        <h2>Room Name: {{$room->title}}</h2>
                        <br>
                        <h4>Room Code: {{$room->roomcode}}</h4>
                        <br>
                        <h4>Admin Id to login: {{$admin->randomcode}}</h4>

                    </div>
                </div>


            </div>
        </div>
        <br>


        <div class="card">
            <div class="card-header">Participants {{sizeof($members).'/'.$room->members}}</div>

            <div class="card-body">
                <div class="col-sm-12">
                    <table id="example1" class="table table-bordered table-striped dataTable no-footer"
                           role="grid"
                           aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                colspan="1"
                                aria-sort="ascending" aria-label="SR# : activate to sort column descending"
                                style="width: 52px;">Id#
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                aria-label="Created At: activate to sort column ascending"
                                style="width: 178px;">Name
                            </th>
                            {{--<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"--}}
                            {{--aria-label="Products: activate to sort column ascending" style="width: 100px;">--}}
                            {{--Email--}}
                            {{--</th>--}}
                            {{--<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"--}}
                            {{--aria-label="Payment Type: activate to sort column ascending"--}}
                            {{--style="width: 100px;">--}}
                            {{--Phone--}}
                            {{--</th>--}}

                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                aria-label="Action: activate to sort column ascending" style="width: 77px;">
                                Action
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                aria-label="Action: activate to sort column ascending" style="width: 50px;">
                                Can Message
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($members as $member)



                            <tr role="row" class="even">
                                <td class="sorting_1">{{$member->user_id}}</td>
                                <td>{{$member->name}}</td>
                                {{--<td>{{$member->email}}</td>--}}
                                {{--<td>{{$member->phone}}</td>--}}
                                {{--<td>{{$member->can_message}}</td>--}}

                                <td><a href="../viewUserProfile/{{$member->user_id}}"
                                       class="btn btn-primary" data-toggle="tooltip"
                                       title="Show Details">View</a>

                                    <a href="../removeUserFromGroup/{{$room->id}}/{{$member->user_id}}"
                                       class="btn btn-danger " data-toggle="tooltip"
                                       title="Remove">Remove</a>

                                </td>
                                <td>
                                    @if($member->can_message==0)
                                        <a href="roomusers/{{$member->room_id}}/{{$member->user_id}}/active"
                                           class="btn btn-danger btn-xs"
                                           data-toggle="tooltip" title="Click to activate"
                                           data-original-title="Click To Active">Cannot
                                            message</a>

                                    @else
                                        <a href="roomusers/{{$member->room_id}}/{{$member->user_id}}/deactive"
                                           class="btn btn-success btn-xs"
                                           data-toggle="tooltip" title="Click to deactivate"
                                           data-original-title="Click To De-Active">Can Message</a>
                                    @endif

                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>


        <br>
        <div class="card">
            <div class="card-header">Add User</div>


            <div class="card-body">
                <form method="POST" action="{{ route('sendmail', $room->id)}}">
                    @csrf
                    <div class="form-group row">
                        <label for="name"
                               class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text"
                                   class="form-control @error('Email') is-invalid @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <br>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Send email</button>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">

                    </div>
                </form>


            </div>

        </div>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop