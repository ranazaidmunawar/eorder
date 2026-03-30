@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp

@extends("user-front.layout")
@section('pageHeading')
  {{$keywords['Career Details'] ?? __('Career Details') }}
@endsection
@section('meta-keywords', "$job->meta_keywords")
@section('meta-description', "$job->meta_description")
@section('content')


    <section class="page-title-area d-flex align-items-center"
    style="background-image: url('{{ $userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB, $userBs->breadcrumb, $userBs) : asset('assets/restaurant/images/breadcrum.jpg') }}');background-size:cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-item text-center">
                        <h2 class="title">{{$upageHeading?->career_details_title}}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('user.front.index',getParam())}}">
                                        <i class="flaticon-home"></i>
                                        {{$keywords["Home"] ??__('Home')}}
                                    </a>
                                </li>
                                @if($upageHeading?->career_details_title)
                                <li class="breadcrumb-item active" aria-current="page">{{$upageHeading?->career_details_title }}</li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="service-details-section pt-115 pb-115">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="job-details">
                        <h3>{{convertUtf8($job->title)}}</h3>
                        @if (!empty($job->vacancy))
                            <div class="info">
                                <strong class="label">{{$keywords["Vacancy"] ?? __('Vacancy')}}</strong>
                                <div class="desc">{{convertUtf8($job->vacancy)}}</div>
                            </div>
                        @endif
                        @if (!empty(convertUtf8($job->job_responsibilities)))
                            <div class="info">
                                <strong class="label">{{$keywords["Job_Responsibilities"] ?? __('Job Responsibilities')}}</strong>
                                <div class="desc">
                                    {!! replaceBaseUrl(convertUtf8($job->job_responsibilities)) !!}
                                </div>
                            </div>
                        @endif
                        @if (!empty(convertUtf8($job->employment_status)))
                            <div class="info">
                                <strong class="label">{{$keywords["Employment_Status"] ?? __('Employment Status')}}</strong>
                                <div class="desc">{{ convertUtf8($job->employment_status) }}</div>
                            </div>
                        @endif
                        @if (!empty(convertUtf8($job->educational_requirements)))
                            <div class="info">
                                <strong class="label">{{ $keywords['Educational_Requirements'] ?? __("Educational Requirements") }}</strong>
                                <div class="desc">
                                    {!! replaceBaseUrl(convertUtf8($job->educational_requirements)) !!}
                                </div>
                            </div>
                        @endif
                        @if (!empty(convertUtf8($job->experience_requirements)))
                            <div class="info">
                                <strong class="label">{{$keywords["Experience_Requirements"] ?? __('Experience Requirements')}}</strong>
                                <div class="desc">
                                    {!! replaceBaseUrl(convertUtf8($job->experience_requirements)) !!}
                                </div>
                            </div>
                        @endif
                        @if (!empty(convertUtf8($job->additional_requirements)))
                            <div class="info">
                                <strong class="label">{{$keywords["Additional_Requirements"] ?? __('Additional Requirements')}}</strong>
                                <div class="desc">
                                    {!! replaceBaseUrl(convertUtf8($job->additional_requirements)) !!}
                                </div>
                            </div>
                        @endif
                        @if (!empty(convertUtf8($job->job_location)))
                            <div class="info">
                                <strong class="label">{{$keywords["Job_Location"] ?? __('Job Location')}}</strong>
                                <div class="desc">
                                    {{ convertUtf8($job->job_location) }}
                                </div>
                            </div>
                        @endif
                        @if (!empty(convertUtf8($job->salary)))
                            <div class="info">
                                <strong class="label">{{$keywords["Salary"] ?? __('Salary')}}</strong>
                                <div class="desc">
                                    {!! replaceBaseUrl(convertUtf8($job->salary)) !!}
                                </div>
                            </div>
                        @endif
                        @if (!empty(convertUtf8($job->benefits)))
                            <div class="info">
                                <strong class="label">{{$keywords["Compensation_&_Other_Benefits"] ?? __('Compensation & Other Benefits')}}</strong>
                                <div class="desc">
                                    {!! replaceBaseUrl(convertUtf8($job->benefits)) !!}
                                </div>
                            </div>
                        @endif
                        @if (!empty(convertUtf8($job->read_before_apply)))
                            <div class="info">
                                <strong class="label">{{$keywords["Read_Before_Apply"] ?? __('Read Before Apply')}}</strong>
                                <div class="desc">
                                    {!! replaceBaseUrl(convertUtf8($job->read_before_apply)) !!}
                                </div>
                            </div>
                        @endif
                        @if (!empty(convertUtf8($job->email)))
                            <div class="info">
                                <strong class="label">{{ $keywords['Email_Address'] ?? __('Email Address') }}</strong>
                                <div class="desc">
                                    {{$keywords["Send your CV to"] ?? __('Send your CV to')}}
                                    <strong class="text-danger">
                                        {{ convertUtf8($job->email) }}
                                    </strong>.
                                </div>
                            </div>
                        @endif
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
                            <h4>{{$keywords['Job_Categories'] ?? __('Job Categories')}}</h4>
                            <ul>
                                <li class="single-category">
                                    <a href="{{route('user.front.career',getParam())}}">{{$keywords["All"] ?? __('All')}} <span>({{$jobscount}})</span></a>
                                </li>
                                @foreach ($jcats as $key => $jcat)
                                    <li class="single-category {{$job->jcategory->id == $jcat->id ? 'active' : ''}}">
                                        <a href="{{route('user.front.career', [getParam(),'category' => $jcat->id, 'term'=>request()->input('term')])}}">{{convertUtf8($jcat->name)}}
                                            <span>({{$jcat->jobs()->where('user_id',$user->id)->count()}})</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
