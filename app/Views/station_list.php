<main id="main" class="main">
    <div class="pagetitle">
        <h1><?php echo $head_title; ?></h1>
    </div>
    <?php 
        $session = session();
        $id = $session->get('user_id');
        $user = user_data($id);
    ?>
    <style>
    .custom-button {
      margin-left: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 4px;
      cursor: pointer;
    }
    .custom-button:hover {
      background-color: #0056b3;
    }
  </style>
    <section class="section">
        <div class="row">
            <div class="col-lg-15">
                <div class="card test">
                    <div class="card-body">
                    <div id="messageContainer"></div> 
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                        <table id="user_table" class="display">
                        <button type="button" class="btn btn-primary custom-modal-button" data-bs-toggle="modal" data-bs-target="#addStationModal">Add Station</button>
                            <thead style="text-align: center;">
                                <tr>
                                    <th>No.</th>
                                    <th>Station Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<div class="modal fade" id="editStationModal" tabindex="-1" role="dialog" aria-labelledby="editStationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStationModalLabel">Edit Station</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateStationForm">
                    <input type="hidden" name="station_id" id="station_id">
                    <div class="row mb-3">
                        <label for="inputEmail" class="col-sm-4 col-form-label">Station Name</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="stationName" name="station_name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add this modal structure within your add_station view -->
<div class="modal fade" id="addStationModal" tabindex="-1" aria-labelledby="addStationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStationModalLabel">Add Station</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php $url = site_url('add_station'); ?>
        <form action="<?php echo $url ?>" method="post" id="add_train">
          <div class="row mb-3">
            <label for="inputEmail" class="col-sm-4 col-form-label">Station Name</label>
            <div class="col-sm-8">
              <input type="text" name="station_name" value="" class="form-control">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: 'station-list-ajax',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#user_table').DataTable({
                    data: response,
                    columnDefs: [
                        { "orderable": false, "targets": 3 }
                    ],
                    columns: [
                        { 
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        { data: 'station_name' },
                        { data: 'created_at' },
                        {   data: null,
                            render: function(data, type, row) {                            
                                return '<a href="#" class="edit-station-btn" data-id="' + row.id + '" data-name="' + row.station_name + '"><img src="' + BaseUrl + 'public/img/edit.png" style="width:auto;height:20px;" title="Edit"></a> | <a href="' + SiteURL + '/delete_station/' + row.id + '" class="delete-user" data-id="' + row.id + '" onclick="return confirm(\'Are you sure you want to delete this station?\');"><img src="' + BaseUrl + 'public/img/delete.png" style="width:auto;height:20px;" title="Delete"></a>';
                            }
                        }

                    ],
                    "pagingType": "full_numbers",
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "language": {
                        "search": "Search:",
                        "lengthMenu": "Show _MENU_ entries",
                        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                        "infoEmpty": "Showing 0 to 0 of 0 entries",
                        "infoFiltered": "(filtered from _MAX_ total entries)",
                        "paginate": {
                            "first": "First",
                            "last": "Last",
                            "next": "Next",
                            "previous": "Previous"
                        }
                    }
                });
            }
        });
        $(document).on('click', '.edit-station-btn', function(e) {
            e.preventDefault();
            var stationId = $(this).data('id');
            var stationName = $(this).data('name');
            $('#station_id').val(stationId);
            $('#stationName').val(stationName);
            $('#editStationModal').modal('show');
        });
        $('#updateStationForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    $('#editStationModal').modal('hide');
                    window.location.reload();
                    $('#messageContainer').html('<div class="alert alert-success">Station updated successfully.</div>');

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
