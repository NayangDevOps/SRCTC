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
                        <?php endif; 
                            if($user['user_type'] == 10 || $user['user_type'] == 20){
                        ?>
                            <table id="user_table" class="display">
                                <thead style="text-align: center;">
                                    <tr>
                                        <th>No.</th>
                                        <th>Passenger Name</th>
                                        <th>Passenger Email</th>
                                        <th>Passenger Phone</th>
                                        <th>Passenger Age</th>
                                        <th>Train Name</th>
                                        <th>From Station</th>
                                        <th>To Station</th>
                                        <th>Coach</th>
                                        <th>Journey Date</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <div class="tabs">
                                <button class="tablinks" onclick="openTab(event, 'tab1')">All Journey</button>
                                <button class="tablinks" onclick="openTab(event, 'tab2')">Upcoming Journey</button>
                                <button class="tablinks" onclick="openTab(event, 'tab3')">Past Journey</button>
                            </div>
                            <div id="tab1" class="tabcontent">Loading...</div>
                            <div id="tab2" class="tabcontent">Loading...</div>
                            <div id="tab3" class="tabcontent">Loading...</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const firstTabLink = document.querySelector('.tablinks');
    if (firstTabLink) {
        firstTabLink.click();
    }
});
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    var activeTab = document.getElementById(tabName);
    if (activeTab) {
        activeTab.style.display = "block";
    }
    evt.currentTarget.className += " active";    
    fetchTabContent(tabName);
}
function fetchTabContent(tabName) {
    var xhr = new XMLHttpRequest();
    var url = "<?= site_url('fetchContent') ?>/" + tabName;
    xhr.open("GET", url, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById(tabName).innerHTML = xhr.responseText;
        } else {
            console.error("Failed to fetch content for " + tabName);
        }
    };
    xhr.send();
}
    $(document).ready(function() {
        $.ajax({
            url: 'ticket-list-ajax',
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
                        { data: 'passenger_name' },
                        { data: 'passenger_email' },
                        { data: 'passenger_phone' },
                        { data: 'passenger_age' },                        
                        { data: 'train_names' },
                        { data: 'from' },
                        { data: 'to' },
                        { data: 'coach' },
                        { data: 'ticket_date' },
                        { data: 'ticket_price' },
                        {   data: null,
                            render: function(data, type, row) {                            
                                return '<a href="' + SiteURL + '/edit_ticket/' + row.id + '" class="edit-station-btn"><img src="' + BaseUrl + 'public/img/edit.png" style="width:auto;height:20px;" title="Edit"></a> | <a href="' + SiteURL + '/delete_ticket/' + row.id + '" class="delete-user" data-id="' + row.id + '" onclick="return confirm(\'Are you sure you want to delete this Ticket?\');"><img src="' + BaseUrl + 'public/img/delete.png" style="width:auto;height:20px;" title="Delete"></a>';
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
<style>
    .tabs {
        display: flex;
        justify-content: space-around;
        background-color: #141467;
        border-radius: 25px;
    }
    .tabs button {
        background-color: inherit;
        color: white;
        padding: 14px 16px;
        cursor: pointer;
        transition: 0.3s;
        font-size: 17px;
        width: 100%;
        border: none;
        border-radius: 25px;
    }
    .tabs button:hover {
        background-color: #0056b3;
    }
    .tabs button.active {
        background-color: #0056b3;
    }
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border-top: none;
    }
    #user_table {
        width: 100% !important;
    }
    #user_table th:nth-child(9), #user_table td:nth-child(9),
    #user_table th:nth-child(3), #user_table td:nth-child(3) {
        width: 200px;
    }
</style>
