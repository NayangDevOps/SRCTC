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
                        <table id="user_table" class="display">
                            <thead style="text-align: center;">
                                <tr>
                                    <th>No.</th>
                                    <th>Image</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Display Name</th>
                                    <th>Email</th>
                                    <th>Mobile No.</th>
                                    <th>Gender</th>
                                    <th>User Type</th>
                                    <?php if ($user['user_type'] == 10) { ?>
                                    <th>Action</th>
                                    <?php }?>
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
<div class="modal fade" id="imageViewModal" tabindex="-1" role="dialog" aria-labelledby="imageViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" id="profileImageModalLabel"></h5>
            </div>
            <div class="modal-body">
                <img id="imagePreview" src="" class="img-fluid mx-auto d-block" alt="Image Preview">
            </div>
        </div>
    </div>
</div>
<script>
function openProfileImageModal(imageUrl, display_name) {
    var modal = $('#imageViewModal');
    $('#profileImageModalLabel').text(display_name);
    var image = document.getElementById('imagePreview');        
    image.src = imageUrl;
    modal.modal('show');
}
    $(document).ready(function() {
        $.ajax({
            url: 'user-list-ajax',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#user_table').DataTable({
                    data: response,
                    columnDefs: [
                    { "orderable": false, "targets": 9}
                    ],
                    columns: [
                        { 
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        { 
                            data: 'profile_pic',
                            render: function(data, type, row) {
                                if (data !== null && data !== '') {
                                    var imageUrl = BaseUrl + 'uploads/' + data;
                                    return '<img src="' + imageUrl + '" class="user-pic" title="' + row.display_name + '" onclick="openProfileImageModal(\'' + imageUrl + '\', \'' + row.display_name + '\')">'; 
                                } else {
                                    var defaultImageUrl = BaseUrl + 'public/img/user_default.jfif';
                                    return '<img src="' + defaultImageUrl + '" class="user-pic" title="' + row.display_name + '" onclick="openProfileImageModal(\'' + defaultImageUrl + '\', \'' + row.display_name + '\')">'; 
                                }
                            }
                        },
                        { data: 'first_name' },
                        { data: 'last_name' },
                        { data: 'display_name'},
                        { data: 'email'},
                        { data: 'mobile_no'},
                        { data: 'gender',
                            render: function(data) {
                                if (data == 0) {
                                    return 'Male';
                                } else if (data == 1) {
                                    return 'Female';
                                } else {
                                    return 'Male';
                                }
                            }
                        },
                        {  data: 'user_type',
                            render: function(data) {
                                if (data == 10) {
                                    return 'Super Admin';
                                } else if (data == 20) {
                                    return 'Admin';
                                } else if (data == 30) {
                                    return 'Loco Pilot';
                                } else {
                                    return 'Normal User';
                                }
                            }
                        },
                        {   data: null,
                            render: function(data, type, row) {                            
                                return '<a href="' + SiteURL + '/user_profile/' + row.id + '"><img src="' + BaseUrl + 'public/img/edit.png" style="width:auto;height:20px;" title="Edit"></a> | <a href="' + SiteURL + '/delete/' + row.id + '" class="delete-user" data-id="' + row.id + '" onclick="return confirm(\'Are you sure you want to delete this user?\');"><img src="' + BaseUrl + 'public/img/delete.png" style="width:auto;height:20px;" title="Delete"></a>';
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

