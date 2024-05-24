
<a href="#" onclick="ajaxRequest('incoming-data...')">

<script>
    function ajaxRequest(incoming_data) {
        event.preventDefault();
        if (incoming_data !== '') {
            $.ajax({
                url: '/admin/ajax-request/' + incoming_data,
                type: 'GET',
                success: function(response){
                    console.log(response)
                    $('#ajax_name').text(response.name);
                },
                error: function(error){
                    console.log(error);
                }
            });
        }
    };
</script>