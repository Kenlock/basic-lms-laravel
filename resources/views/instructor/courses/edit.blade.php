@extends('layouts.sidebar')
@section('content')
    <div class="row" style="margin-bottom:10px;">
        <div class="col-md-12">
            <div class="row">
                @foreach($courses as $course)
                    @if($course->id == $id)
                        <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                        </div>
                        {!! Form::open(['method' => 'POST', 'route' => ['courses.store'], 'enctype' => 'multipart/form-data'])!!}
                        <h3 class="page-title">@lang('module.courses.view-course')</h3>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                {{ $course->title }}
                            </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12 form-group">
                                            {!! Form::label('access-code', Lang::get('module.courses.fields.access_code'), ['class' => 'control-label']) !!}
                                            {!! Form::text('access_code', old('access_code'), ['class' => 'form-control ', 'placeholder' =>  $course->access_code]) !!}
                                            @if($errors->has('access_code'))
                                                <p class="help-block alert-danger" data-value="shake">
                                                    {{ $errors->first('access_code') }}

                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 form-group">
                                            {!! Form::label('course-title', Lang::get('module.courses.fields.course'), ['class' => 'control-label']) !!}
                                            {!! Form::text('title', old('title'), ['class' => 'form-control ', 'placeholder' => $course->title]) !!}
                                            @if($errors->has('title'))
                                                <p class="help-block alert-danger">
                                                    {{ $errors->first('title') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 form-group">
                                            {!! Form::label('assistant-professor', Lang::get('module.courses.fields.assistant_professor'), ['class' => 'control-label']) !!}
                                            {!! Form::text('assistant_professor', old('assistant_professor'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                                            @if($errors->has('assistant_professor'))
                                                <p class="help-block alert-danger">
                                                    {{ $errors->first('assistant_professor') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 form-group">
                                            {!! Form::label('desc', Lang::get('module.courses.fields.desc'), ['class' => 'control-label']) !!}
                                            {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => $course->description,'resize' => 'none']) !!}
                                            <p class="help-block"></p>
                                            @if($errors->has('description'))
                                                <p class="help-block alert-danger">
                                                    {{ $errors->first('description') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            <div class="panel-footer">
                                {!! Form::submit(trans('module.save'), ['class' => 'btn btn-danger' ,'data-value' => 'shake', 'onclick' => 'shake()']) !!}
                                {{ Form::reset(trans('module.reset'), ['class' => 'btn btn-primary']) }}
                                {!! Form::close() !!}
                            </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection