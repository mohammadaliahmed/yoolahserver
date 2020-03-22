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

                <div class="card">
                    <div class="card-header">Add User</div>


                    <div class="card-body">
                        <form method="POST" action="{{ route('sendmail') }}" >
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
                                    <button type="submit" class="btn btn-primary">Send email</button>

                                </div>
                            </div>

                            <div class="col-md-6">

                            </div>
                        </form>


                    </div>

                </div>

                <br>
                <br>

                <div class="card">
                    <div class="card-header">Participants</div>

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
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Products: activate to sort column ascending" style="width: 100px;">
                                        Email
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Payment Type: activate to sort column ascending"
                                        style="width: 100px;">
                                        Phone
                                    </th>

                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Action: activate to sort column ascending" style="width: 77px;">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($members as $member)



                                    <tr role="row" class="even">
                                        <td class="sorting_1">{{$member->id}}</td>
                                        <td>{{$member->name}}</td>
                                        <td>{{$member->email}}</td>
                                        <td>{{$member->phone}}</td>

                                        <th><a href="viewgroup/{{$member->id}}"
                                               class="btn btn-primary" data-toggle="tooltip"
                                               title="Show Details">View</a>
                                        </th>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
