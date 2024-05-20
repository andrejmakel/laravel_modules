
{{-- JS to create custom dataTables button that clears all filters --}}
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('document_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.documents.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

// ------ CLEAR FILTER BUTTON START ------ //
let clearFiltersButtonTrans = 'Clear Filters';  
     let clearFiltersButton = {
         text: clearFiltersButtonTrans,
         className: 'btn-info',
         action: function (e, dt, node, config) {
             table.columns().search('').draw();
             table.search('').draw();
             $('select.search').val(function() {
                 return $(this).find('option:first').val();
             });
         }
     };
     dtButtons.push(clearFiltersButton);
// ------ CLEAR FILTER BUTTON END ------ //

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.documents.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'date', name: 'date' },
{ data: 'team_nazov', name: 'team.nazov', sortable: false },
{ data: 'title', name: 'title', sortable: false },
{ data: 'document_code', name: 'document_code', sortable: false },
{ data: 'document', name: 'document', sortable: false, searchable: false },
{ data: 'payment_info', name: 'payment_info', sortable: false  },
{ data: 'accounting', name: 'accounting', sortable: false  },
{ data: 'amount', name: 'amount' , sortable: false},
{ data: 'paid', name: 'paid', sortable: false, searchable: false  },
{ data: 'due_date', name: 'due_date', sortable: false, searchable: false  },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Document').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('change', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value
      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
});
</script>