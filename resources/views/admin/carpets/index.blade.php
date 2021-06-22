@extends('layouts.admin')
@section('content')
@can('carpet_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.carpets.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.carpet.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.carpet.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Carpet">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.carpet.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.carpet.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.carpet.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.carpet.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.carpet.fields.image') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carpets as $key => $carpet)
                        <tr data-entry-id="{{ $carpet->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $carpet->id ?? '' }}
                            </td>
                            <td>
                                {{ $carpet->name ?? '' }}
                            </td>
                            <td>
                                {{ $carpet->price ?? '' }}
                            </td>
                            <td>
                                {{ $carpet->description ?? '' }}
                            </td>
                            <td>
                                @if($carpet->image)
                                    <a href="{{ $carpet->image->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('carpet_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.carpets.show', $carpet->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('carpet_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.carpets.edit', $carpet->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('carpet_delete')
                                    <form action="{{ route('admin.carpets.destroy', $carpet->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('carpet_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.carpets.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Carpet:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection