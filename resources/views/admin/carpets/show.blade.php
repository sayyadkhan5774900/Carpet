@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.carpet.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.carpets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.carpet.fields.id') }}
                        </th>
                        <td>
                            {{ $carpet->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carpet.fields.name') }}
                        </th>
                        <td>
                            {{ $carpet->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carpet.fields.price') }}
                        </th>
                        <td>
                            {{ $carpet->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carpet.fields.description') }}
                        </th>
                        <td>
                            {{ $carpet->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carpet.fields.image') }}
                        </th>
                        <td>
                            @if($carpet->image)
                                <a href="{{ $carpet->image->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.carpets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection