@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Survey List') }}</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Steps</th>
                                <th scope="col">Created</th>
                                <th scope="col">My Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($surveys as $key => $survey)
                                <tr>
                                    <th scope="row">{{$key + 1}}</th>
                                    <td>{{$survey->title}}</td>
                                    <td>{{ $survey->surveyItems->groupBy('survey_step_id')->count() }}</td>
                                    <td>{{$survey->created_at->diffForHumans()}}</td>
                                    <td>@mdo</td>
                                    <td>
                                        <a href="{{route('survey', $survey->id)}}" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="100%" scope="row">No Survey Found!</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
