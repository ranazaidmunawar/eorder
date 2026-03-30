@extends('user.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Blog') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('user.dashboard')}}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Blog Management') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Blog') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title d-inline-block">{{ __('Blog') }}</div>
            </div>

            <div class="col-lg-3">
              @includeIf('user.partials.languages')
            </div>

            <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
              <a href="{{ route('user.blog_management.create_blog') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> {{ __('Add Blog') }}</a>

              <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete" data-href="{{ route('user.blog_management.bulk_delete_blog') }}">
                <i class="flaticon-interface-5"></i> {{ __('Delete') }}
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($blogs) == 0)
                <h3 class="text-center mt-2">{{ __('NO BLOG FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col" width="40%">{{ __('Title') }}</th>
                        <th scope="col">{{ __('Category') }}</th>
                        <th scope="col">{{ __('Author') }}</th>
                        <th scope="col">{{ __('Publish Date') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($blogs as $blog)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $blog->id }}">
                          </td>
                          <td>
                            <a href="{{ route('user.front.blog.details',[$tusername,$blog->slug,$blog->id]) }}" target="_blank">{{ strlen($blog->title) > 120 ? substr($blog->title, 0, 120) . '...' : $blog->title  }}</a>
                          </td>
                          <td>{{ $blog->categoryName }}</td>
                          <td>{{ $blog->author }}</td>
                          <td>
                            @php
                            
                              $date = Carbon\Carbon::parse($blog->created_at)->tz($userBe->timezone);
                            @endphp
                         
                            {{ date_format($date, 'M d, Y') }}
                          </td>
                          <td>
                            <a class="btn btn-secondary my-2 btn-sm mr-1" href="{{ route('user.blog_management.edit_blog', ['id' => $blog->id]) }}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                            
                            </a>

                            <form class="deleteform d-inline-block" action="{{ route('user.blog_management.delete_blog', ['id' => $blog->id]) }}" method="post">

                              @csrf
                              <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                                
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>

        <div class="card-footer"></div>
      </div>
    </div>
  </div>
@endsection
