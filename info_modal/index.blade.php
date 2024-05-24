<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Team Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th scope="row" width="20px">Name:</th>
                        <td><span id="teamName"></span></td>
                    </tr>
                    <tr>
                        <th scope="row" width="20px">IBAN:</th>
                        <td><span id="iban"></span></td>
                    </tr>
                    <tr>
                        <th scope="row" width="20px">Description:</th>
                        <td><span id="description"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a id="editTeamButton" target="_blank" href="#" class="btn btn-danger">Edit Team</a>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

<script>
    function dodavatelInfo(dodavatel_id) {
        event.preventDefault();
        if (dodavatel_id !== '') {
            $.ajax({
                url: '/admin/get-dodavatel-info/' + dodavatel_id,
                type: 'GET',
                success: function(response){
                    // Populate modal with response values
                    $('#dodavatel_name').text(response.name);
                    $('#iban').text(response.name);
                    $('#description').html(response.name);
                    // Update the Edit Team button URL
                    var editTeamUrl = '/admin/dodavatels/' + response.id + '/edit';
                    $('#editTeamButton').attr('href', editTeamUrl);
                    
                    // Show the modal
                    $('#myModal').modal('show');
                },
                error: function(error){
                    console.log('hi');
                }
            });
        }
    };
</script>