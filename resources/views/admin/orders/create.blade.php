@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.order.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orders.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="height">{{ trans('cruds.order.fields.height') }}</label>
                <input class="form-control {{ $errors->has('height') ? 'is-invalid' : '' }}" type="number" name="height" id="height" value="{{ old('height', '') }}" step="1">
                @if($errors->has('height'))
                    <div class="invalid-feedback">
                        {{ $errors->first('height') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.height_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="width">{{ trans('cruds.order.fields.width') }}</label>
                <input class="form-control {{ $errors->has('width') ? 'is-invalid' : '' }}" type="number" name="width" id="width" value="{{ old('width', '') }}" step="1">
                @if($errors->has('width'))
                    <div class="invalid-feedback">
                        {{ $errors->first('width') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.width_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="carpet_id">{{ trans('cruds.order.fields.carpet') }}</label>
                <select class="form-control select2 {{ $errors->has('carpet') ? 'is-invalid' : '' }}" name="carpet_id" id="carpet_id">
                    @foreach($carpets as $id => $entry)
                        <option value="{{ $id }}" {{ old('carpet_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('carpet'))
                    <div class="invalid-feedback">
                        {{ $errors->first('carpet') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.carpet_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_price">{{ trans('cruds.order.fields.total_price') }}</label>
                <input class="form-control {{ $errors->has('total_price') ? 'is-invalid' : '' }}" type="text" name="total_price" id="total_price" value="{{ old('total_price', '') }}">
                @if($errors->has('total_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.total_price_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection