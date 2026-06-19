@extends('admin.layouts.admin_dashboard', ['title'=>$model])

@section('content')

    <div class="content-wrapper">
        @include('admin.layouts.breadcrumb', ['model'=>$model])
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{$model}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header p-2">

                                            </div>
                                            <div class="card-body">

                                                <form class="form-horizontal"
                                                      action="{{route('admin.pages.update_section', $pageContent->id)}}"
                                                      method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{__('admin_dashboard.common.title_ar')}}</label>
                                                                <input type="text" name="title"
                                                                       class="form-control"
                                                                       value="{{$pageContent->title}}">
                                                            </div>
                                                        </div>

                                                        @if($pageContent->subtitle)
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="subtitle_en"
                                                                           class="col-form-label">{{__('admin_dashboard.common.subtitle_ar')}}</label>
                                                                    <textarea id="subtitle_en" data-lang="ar"
                                                                              data-height="200px" name="subtitle"
                                                                              class="editor form-control">{{$pageContent->subtitle}}</textarea>
                                                                </div>
                                                            </div>
                                                        @endif


                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="name"
                                                                       class="col-form-label">{{__('admin_dashboard.common.image')}}</label>
                                                                <input type="file" name="image"
                                                                       onchange="previewImage(this)"
                                                                       class="image_input form-control">
                                                                <div class="file__image"
                                                                     style="background: url('{{$pageContent->image}}') no-repeat; "></div>
                                                            </div>
                                                        </div>

                                                        @if($pageContent->data['list_1'])
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>عنوان القائمة</label>
                                                                    <input type="text" class="form-control"
                                                                           name="list_1[title]"
                                                                           value="{{$pageContent->data['list_1']['title']}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label
                                                                        class="col-form-label">{{__('admin_dashboard.common.subtitle_ar')}}</label>
                                                                    <textarea data-lang="ar"
                                                                              data-height="200px" name="list_1[data]"
                                                                              class="editor form-control">{!! $pageContent->data['list_1']['data'] !!}</textarea>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if(isset($pageContent->data['list_2']))
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>عنوان القائمة</label>
                                                                    <input type="text" class="form-control"
                                                                           name="list_2[title]"
                                                                           value="{{$pageContent->data['list_2']['title']}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label
                                                                        class="col-form-label">{{__('admin_dashboard.common.subtitle_ar')}}</label>
                                                                    <textarea data-lang="ar"
                                                                              data-height="200px" name="list_2[data]"
                                                                              class="editor form-control">{!! $pageContent->data['list_2']['data'] !!}</textarea>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-success">
                                                                    {{__('admin_dashboard.common.edit')}}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection

