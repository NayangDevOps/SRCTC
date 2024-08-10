<main id="main" class="main">
    <div class="pagetitle">
        <h1><?php echo $head_title; ?></h1>
    </div>
    <?php 
        $session = session();
        $id = $session->get('user_id');
        $user = user_data($id);
    ?>
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
                            <thead style="text-align: center;">
                                <tr>
                                    <th>No.</th>
                                    <th>Train Name</th>
                                    <th>Routes</th>
                                    <th>Routes KM</th>
                                    <th>Routes Rates</th>
                                    <th>Adult Price</th>
                                    <th>Child Price</th>
                                    <th>Senior Price</th>
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
<script>
    $(document).ready(function() {
        $.ajax({
            url: 'tariff-list-ajax',
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
                        { data: 'train_name' },
                        { data: 'routes_station_name' },
                        { data: 'route_km' },
                        { data: 'route_rates' },
                        { data: 'adult_price' },
                        { data: 'child_price' },
                        { data: 'senior_price' },
                        {   data: null,
                            render: function(data, type, row) {                            
                                return '<a href="' + SiteURL + '/edit_tariff/' + row.id + '" class="edit-station-btn"><img src="' + BaseUrl + 'public/img/edit.png" style="width:auto;height:20px;" title="Edit"></a> | <a href="' + SiteURL + '/delete_tariffs/' + row.id + '" class="delete-user" data-id="' + row.id + '" onclick="return confirm(\'Are you sure you want to delete this Tariff?\');"><img src="' + BaseUrl + 'public/img/delete.png" style="width:auto;height:20px;" title="Delete"></a>';
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
        
    });
</script>
