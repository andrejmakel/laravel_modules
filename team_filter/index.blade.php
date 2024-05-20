
{{-- add id for JS --}}
<select class="search" id="select_team">
    <option value>{{ trans('global.all') }}</option>
    @foreach($teams as $key => $item)
        <option value="{{ $item->nazov }}">{{ $item->nazov }}</option>
    @endforeach
</select>

{{-- on('input', '.search',   -->   on('change', '.search', --}}
<script>
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
</script>

{{-- JS to change the value of team_select --}}
<script>
    function selectOption(teamName) {
        var selectElement = document.getElementById("select_team");
        var matchingOption = Array.from(selectElement.options).find(function(option) {
            return option.value === teamName;
        });
        if (matchingOption) {
            matchingOption.selected = true; 
            $(selectElement).trigger('change');
        }
    }
</script>