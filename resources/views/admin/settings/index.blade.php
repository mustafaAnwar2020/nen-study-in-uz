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

                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header p-2">
                                                <ul class="nav nav-pills">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" href="#general"
                                                           data-toggle="tab">General Settings</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#social"
                                                           data-toggle="tab">Social Media</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#media"
                                                           data-toggle="tab">Site Media</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#menu"
                                                           data-toggle="tab">Site Menu</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#flags_text"
                                                           data-toggle="tab">Flags Text</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content">
                                                    @include('admin.settings.general')
                                                    @include('admin.settings.social')
                                                    @include('admin.settings.media')
                                                    @include('admin.settings.menu')
                                                    @include('admin.settings.flags_text')
                                                </div>
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




