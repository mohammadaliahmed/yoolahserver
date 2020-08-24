@extends('layouts.adminapp')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">


                <div class="card">
                    <div class="card-header">All List of groups</div>
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
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Created At: activate to sort column ascending"
                                        style="width: 178px;">Title
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Products: activate to sort column ascending" style="width: 100px;">
                                        Subtitle
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Payment Type: activate to sort column ascending"
                                        style="width: 50px;">
                                        Members
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Payment Type: activate to sort column ascending"
                                        style="width: 80px;">
                                        Members Limit
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Total: activate to sort column ascending" style="width: 161px;">
                                        Created At
                                    </th>

                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
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

                                        <th><a href="#"
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
