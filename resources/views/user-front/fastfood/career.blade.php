@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;use Carbon\Carbon;
@endphp

@extends("user-front.layout")
@section('pageHeading')
  {{ $keywords['Career'] ?? __('Career') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->career_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->career_meta_description : '')

@section('content')

    @include('user-front.breadcrum',['title' => $upageHeading?->career_page_title])



    <div class="job-lists">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @if (count($jobs) == 0)
                            <div class="col-12 bg-light py-5">
                                <h3 class="text-center">{{$keywords["NO_JOB_FOUND"] ?? __('NO JOB FOUND')}}</h3>
                            </div>
                        @else
                            @foreach ($jobs as $key => $job)
                                <div class="col-md-12">
                                    <div class="single-job @if($loop->last) mb-0 @endif">

                                        <h3>
                                            <a href="{{route('user.front.career.details', [getParam(),$job->slug, $job->id])}}"
                                               class="title">
                                               {{strlen(convertUtf8($job->title)) > 47 ? convertUtf8(substr($job->title, 0, 47)) . '...' : convertUtf8($job->title)}}
                                            </a></h3>

                                        @php
                                            $deadline = Carbon::parse($job->deadline)->locale("$userCurrentLang->code");
                                            $deadline = $deadline->translatedFormat('jS F, Y');
                                        @endphp

                                        <p class="deadline"><strong><i
                                                    class="far fa-calendar-alt"></i> {{$keywords["Deadline"] ?? __('Deadline')}}
                                                :</strong> {{$deadline}}</p>
                                        <p class="education"><strong><i
                                                    class="fas fa-graduation-cap"></i> {{$keywords["Educational_Experience"] ?? __('Educational Experience')}}:</strong> {!! (strlen(convertUtf8(strip_tags($job->educational_requirements))) > 110) ? convertUtf8(substr(strip_tags($job->educational_requirements), 0, 110)) . '...' : convertUtf8(strip_tags($job->educational_requirements)) !!}
                                        </p>
                                        <p class="experience"><strong><i class="fas fa-briefcase"></i>
                                        {{$keywords["Work_Experience"] ?? __('Work Experience')}}:</strong> {{convertUtf8($job->experience)}}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <nav class="pagination-nav">
                                {{$jobs->appends(['category' => request()->input('category'), 'term' => request()->input('term')])->links()}}
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="blog-sidebar-widgets">
                        <div class="searchbar-form-section">
                            <form action="{{route('user.front.career',getParam())}}">
                                <div class="searchbar">
                                    <input name="category" type="hidden" value="{{request()->input('category')}}">
                                    <input name="term" type="text" placeholder="{{$keywords["Search_Jobs"] ?? __('Search Jobs')}}"
                                           value="{{request()->input('term')}}">
                                    <button type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="blog-sidebar-widgets category-widget">
                        <div class="category-lists job">
                            <h4>{{$keywords["Job_Categories"] ?? __('Job Categories')}}</h4>
                            <ul>
                                <li class="single-category {{empty(request()->input('category')) ? 'active' : ''}}">
                                    <a href="{{route('user.front.career',getParam())}}">{{$keywords["All"] ?? __('All')}} <span>({{$jobscount}})</span></a>
                                </li>
                                @foreach ($jcats as $key => $jcat)
                                    <li class="single-category {{$jcat->id == request()->input('category') ? 'active' : ''}}">
                                        <a href="{{route('user.front.career', [getParam(),'category' => $jcat->id, 'term'=>request()->input('term')])}}">{{convertUtf8($jcat->name)}}
                                            <span>({{$jcat->jobs()->where('user_id',$user->id)->count()}})</span></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
