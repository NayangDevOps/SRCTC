<main id="main" class="main">
    <div class="pagetitle">
        <h1><?php echo $head_title; ?></h1>
    </div>
    <?php $session = session();
     $id = $session->get('user_id');
     $user = user_data($id);?>
    <section class="section">
        <div class="row">
            <div class="col-lg-15">
                <div class="card test">
                    <div class="card-body">
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
                        <table id="train_table" class="display">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>No.</th>
                                    <th>Train Code</th>
                                    <th>Train Name</th>
                                    <th>Available Coaches</th>
                                    <th>K.M. Rate (Rs.)</th>
                                    <th>Release Date</th>                                    
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
            url: 'train-list-ajax',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#train_table').DataTable({
                    data: response,
                    columnDefs: [
                        { "orderable": false, "targets": 6 }
                    ],
                    columns: [
                        { 
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        { data: 'train_code' },
                        { data: 'train_name' },
                        {
                            data: 'coaches',
                            render: function(data) {
                                var coachesArray = data.split(',');
                                var coachLabels = {
                                    '1': '1A',
                                    '2': '2A',
                                    '3': '3A',
                                    '4': '3E',
                                    '5': 'SL'
                                };
                                var result = '';
                                coachesArray.forEach(function(coachValue, index) {
                                    var label = coachLabels[coachValue];
                                    if (label) {
                                        result += label;
                                    } else if (coachValue.trim() === '4' || coachValue.trim() === '5') {
                                        result += coachLabels[coachValue.trim()];
                                    } else {
                                        result += coachValue.trim()+'A';
                                    }
                                    if (index < coachesArray.length - 1) {
                                        result += ', ';
                                    }
                                });
                                return result;
                            }
                        },
                        { data: 'rates'},
                        { data: 'release_date'},
                        {   data: null,
                            render: function(data, type, row) {                            
                                return '<a href="' + SiteURL + '/train_edit/' + row.id + '"><img src="' + BaseUrl + 'public/img/edit.png" style="width:auto;height:20px;" title="Edit"></a> | <a href="' + SiteURL + '/delete_train/' + row.id + '" class="delete-user" data-id="' + row.id + '" onclick="return confirm(\'Are you sure you want to delete this train?\');"><img src="' + BaseUrl + 'public/img/delete.png" style="width:auto;height:20px;" title="Delete"></a>';
                            }
                        },
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


