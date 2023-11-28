{{-- styles for toggle button --}}
<style>
    .toggle {
        position: relative;
        display: inline-block;
        width: 30px;
        height: 17px;
        margin-bottom: -4px 
    }
     
    /* Hide the checkbox input */
    .toggle input {
        display: none;
    }
     
    /* Describe slider's look and position. */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: gray;
        transition: .4s;
        border-radius: 17px;
    }
     
    /* Describe the white ball's location 
          and appearance in the slider. */
    .slider:before {
        position: absolute;
        content: "";
        height: 13px;
        width: 13px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
     
    /* Modify the slider's background color to 
          green once the checkbox has been selected. */
    input:checked+.slider {
        background-color: green;
    }
     
    /* When the checkbox is checked, shift the 
          white ball towards the right within the slider. */
    input:checked+.slider:before {
        transform: translateX(13px);
    }

    .daterange-input{
        font-size: 15px;
        display: block;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        display: none;
        
    }
</style>

{{-- date filter html code --}}
<div style="margin: 20px 0px;">
    <strong>Date Filter</strong>
    <label class="toggle">
        <input type="checkbox" id="myCheckbox" name="myCheckbox" class="filter">
        <span class="slider"></span>
    </label>
    <div style="margin-top: 10px;">
        <input type="text" name="daterange" value="" class="daterange-input" />
    </div>
</div>

{{-- script to create datatables --}}
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('doklady_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.dokladies.massDestroy') }}",
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: {
        url: "{{ route('admin.dokladies.index') }}",
        //add this to enable date filter
        data:function (d) {
                d.from_date = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
                d.to_date = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
                d.checkboxValue = $('#myCheckbox').is(':checked') ? 1 : 0;
            }
    },
    
    
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'archiv', name: 'archiv' },
{ data: 'close', name: 'close' },
{ data: 'poho', name: 'poho' },
{ data: 'problem', name: 'problem' },
{ data: 'team_team', name: 'team.team' },
{ data: 'sablona_sablona', name: 'sablona.sablona' },
{ data: 'date', name: 'date' },
{ data: 'dodavatel_dodavatel', name: 'dodavatel.dodavatel' },
{ data: 'typ_typ', name: 'typ.typ' },
{ data: 'source_date', name: 'source_date' },
{ data: 'doc_source_doc_source', name: 'doc_source.doc_source' },
{ data: 'my_email_my_email', name: 'my_email.my_email' },
{ data: 'partner_email', name: 'partner_email' },
{ data: 'iban', name: 'iban' },
{ data: 'vs', name: 'vs' },
{ data: 'ks', name: 'ks' },
{ data: 'ss', name: 'ss' },
{ data: 'doklad', name: 'doklad' },
{ data: 'period_period', name: 'period.period' },
{ data: 'dodane', name: 'dodane' },
{ data: 'splatna', name: 'splatna' },
{ data: 'text', name: 'text' },
{ data: 'predkontacia_predkontacia', name: 'predkontacia.predkontacia' },
{ data: 'clenenie_dph_clenenie_dph', name: 'clenenie_dph.clenenie_dph' },
{ data: 'clnenie_kv_clenenie_kv', name: 'clnenie_kv.clenenie_kv' },
{ data: 'currency_currency', name: 'currency.currency' },
{ data: 'dph_0', name: 'dph_0' },
{ data: 'dph_10', name: 'dph_10' },
{ data: 'dph_20', name: 'dph_20' },
{ data: 'paid_from_account_title', name: 'paid_from.account_title' },
{ data: 'uhrada', name: 'uhrada' },
{ data: 'file', name: 'file', sortable: false, searchable: false },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Doklady').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

// ------ START DATE RANGE PICKER ------//

  $('input[name="daterange"]').daterangepicker({
        ranges: {
            'Q1': [moment().startOf('year'), moment().startOf('year').add(2, 'months').endOf('month')],
            'Q2': [moment().startOf('year').add(3, 'months'), moment().startOf('year').add(5, 'months').endOf('month')],
            'Q3': [moment().startOf('year').add(6, 'months'), moment().startOf('year').add(8, 'months').endOf('month')],
            'Q4': [moment().startOf('year').add(9, 'months'), moment().endOf('year')]
        },
        startDate: moment().subtract(1, 'D'),
        endDate: moment(),
        locale: {
            format: 'DD.MM.YYYY' // Specify the desired date format
        }
    }).on('apply.daterangepicker', function(ev, picker) {
        // Automatically trigger the filter when the date range is applied
        table.draw();
    });
  $(".filter").click(function(){
        table.draw();
    });


// ------ END DATE RANGE PICKER ------//
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
      var checkbox = document.getElementById('myCheckbox');
      var dateRangeInput = document.querySelector('.daterange-input');

      // Set initial visibility based on checkbox state
      toggleVisibility();

      // Add event listener to checkbox
      checkbox.addEventListener('change', toggleVisibility);

      function toggleVisibility() {
        // Toggle the visibility based on checkbox state
        if (checkbox.checked) {
          dateRangeInput.style.display = 'block';
        } else {
          dateRangeInput.style.display = 'none';
        }
      }
    });
</script>