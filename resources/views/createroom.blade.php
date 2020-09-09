@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if($user->email_verified==0)
                <div class="alert alert-danger" role="alert">

                    Your email is not verified. Please check email
                </div>
            @else


                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">List of groups</div>
                        <div class="row">
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
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1"
                                            aria-label="Created At: activate to sort column ascending"
                                            style="width: 178px;">Title
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1"
                                            aria-label="Products: activate to sort column ascending"
                                            style="width: 100px;">
                                            Subtitle
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1"
                                            aria-label="Payment Type: activate to sort column ascending"
                                            style="width: 50px;">
                                            Members
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1"
                                            aria-label="Payment Type: activate to sort column ascending"
                                            style="width: 80px;">
                                            Members Limit
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1"
                                            aria-label="Total: activate to sort column ascending" style="width: 161px;">
                                            Created At
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1"
                                            aria-label="Action: activate to sort column ascending" style="width: 77px;">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($rooms as $day)

                                        {{--                        {{$day->title}}--}}


                                        <tr role="row" class="even">
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
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>


                        <div class="card-body">
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
        </div>

        </div>
@endsection
