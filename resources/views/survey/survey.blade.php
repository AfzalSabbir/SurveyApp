@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __($survey->title) }}</div>
                    <div class="card-body">
                        <form action="{{route('survey.save', $survey->id)}}" method="post">
                            @csrf
                            @include('survey.tabs', $survey)
                            <button class="btn btn-success mt-3">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
