@extends('layouts.app')

@section('title', __('art_studio.create'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('art_studio.create') }}</div>
            <form method="POST" action="{{ route('art_studios.store') }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('art_studio.name') }} <span class="form-required">*</span></label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="sub_district" class="form-label">{{ __('art_studio.sub_district') }} <span class="form-required">*</span></label>
                        <input id="sub_district" type="text" class="form-control{{ $errors->has('sub_district') ? ' is-invalid' : '' }}" name="sub_district" value="{{ old('sub_district') }}" required>
                        {!! $errors->first('sub_district', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="village" class="form-label">{{ __('art_studio.village') }}</label>
                        <input id="village" type="text" class="form-control{{ $errors->has('village') ? ' is-invalid' : '' }}" name="village" value="{{ old('village') }}" required>
                        {!! $errors->first('village', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="leader" class="form-label">{{ __('art_studio.leader') }} <span class="form-required">*</span></label>
                        <input id="leader" type="text" class="form-control{{ $errors->has('leader') ? ' is-invalid' : '' }}" name="leader" value="{{ old('leader') }}" required>
                        {!! $errors->first('leader', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="art_type" class="form-label">{{ __('art_studio.art_type') }} <span class="form-required">*</span></label>
                        <input id="art_type" type="text" class="form-control{{ $errors->has('art_type') ? ' is-invalid' : '' }}" name="art_type" value="{{ old('art_type') }}" required>
                        {!! $errors->first('art_type', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="building" class="form-label">{{ __('art_studio.building') }} <span class="form-required">*</span></label>
                        <input id="building" type="text" class="form-control{{ $errors->has('building') ? ' is-invalid' : '' }}" name="building" value="{{ old('building') }}" required>
                        {!! $errors->first('building', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('art_studio.description') }}</label>
                        <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="4">{{ old('description') }}</textarea>
                        {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('art_studio.create') }}" class="btn btn-success">
                    <a href="{{ route('art_studios.index') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection