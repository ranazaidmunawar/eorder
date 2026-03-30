@php
    use App\Models\User\Language;
    $userId = getRootUser()->id;
    $userDefaultLang = Language::query()
    ->where([
        ['user_id',$userId],
        ['is_default',1]
    ])->first();
    $userLanguages = Language::query()->where('user_id',$userId)->get();
   
@endphp
@if(!is_null($userDefaultLang))
    @if (!empty($userLanguages))
        <select name="userLanguage" class="form-control"
                onchange="window.location='{{url()->current() . '?language='}}'+this.value">
            <option value="" selected disabled>{{__('Select a Language')}}</option>
            @foreach ($userLanguages as $lang)
                <option
                    value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
            @endforeach
        </select>
    @endif
@endif
