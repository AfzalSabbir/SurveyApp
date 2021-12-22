@forelse($surveyItemGroup as $key => $surveyItem)
    <label for="{{"_$key"}}" class="w-100 mb-3">
        {{$surveyItem->title}}
        @switch($surveyItem)
            @case($surveyItem->inputType->type == 'input')
            <input id="{{"_$key"}}" required="" name="{{"item_id_$surveyItem->id"}}" class="form-control"
                   type="text">
            @break
            @case($surveyItem->inputType->type == 'select')
            <select id="{{"_$key"}}" required=""
                    name="{{"item_id_$surveyItem->id"}}{{$surveyItem->is_multiple ? '[]' : ''}}"
                    class="form-control" {{$surveyItem->is_multiple ? 'multiple' : ''}}>
                @foreach(explode(',', $surveyItem->options) as $option)
                    <option value="{{$option}}"
                            class="text-capitalize">{{$option}}</option>
                @endforeach
            </select>
            @break
            @case($surveyItem->inputType->type == 'textarea')
            <textarea id="{{"_$key"}}" required="" name="{{"item_id_$surveyItem->id"}}" class="form-control"
                      rows="3"></textarea>
            @break
            @case($surveyItem->inputType->type == 'date')
            <input id="{{"_$key"}}" required="" name="{{"item_id_$surveyItem->id"}}" class="form-control"
                   type="date">
            @break
            @case($surveyItem->inputType->type == 'number')
            <input id="{{"_$key"}}" required="" name="{{"item_id_$surveyItem->id"}}" class="form-control"
                   type="number">
            @break
            @case($surveyItem->inputType->type == 'checkbox')
            <br>
            @foreach(explode(',', $surveyItem->options) as $k => $option)
                <label class="me-2" for="{{$key . $k}}">
                    <input id="{{$key . $k}}" type="checkbox" value="{{$option}}"
                           name="{{"item_id_$surveyItem->id"}}[]"
                           class="text-capitalize"> {{$option}}
                </label>
            @endforeach
            @break
            @case($surveyItem->inputType->type == 'radio')
            <br>
            @foreach(explode(',', $surveyItem->options) as $k => $option)
                <label class="me-2" for="{{$key . $k}}">
                    <input id="{{$key . $k}}" type="radio" value="{{$option}}" required=""
                           name="{{"item_id_$surveyItem->id"}}"
                           class="text-capitalize"> {{$option}}
                </label>
            @endforeach
            @break
            @default
            @break
        @endswitch
    </label>
@empty
    No Items found
@endforelse
