@php($surveyItems = $survey->surveyItems->sortBy('survey_step_id')->groupBy('survey_step_id'))

<ul class="nav nav-tabs" id="myTab" role="tablist">
    @foreach($surveyItems as $key => $surveyItem)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{$loop->index === 0 ? 'active' : ''}}" id="{{$key}}-tab" data-bs-toggle="tab"
                    data-bs-target="#{{"tab$key"}}"
                    type="button"
                    role="tab" aria-controls="{{"tab$key"}}" aria-selected="{{$key === 0 ? 'true' : 'false'}}">
                {{$surveyItem->first()->surveyStep->title}}
            </button>
        </li>
    @endforeach
</ul>
<div class="tab-content" id="myTabContent">
    @foreach($surveyItems as $key => $surveyItemGroup)
        <div class="tab-pane fade mt-3 {{$loop->index === 0 ? 'show active' : ''}}" id="{{"tab$key"}}" role="tabpanel"
             aria-labelledby="{{$key}}-tab">
            @include('survey.items', $surveyItemGroup)
        </div>
    @endforeach
</div>
