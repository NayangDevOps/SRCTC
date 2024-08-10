<main id="main" class="main">
    <div class="pagetitle">
        <h1><?php echo $head_title; ?></h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-15">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <?php
                        $is_edit_mode = $head_title == 'Update Route';
                        if ($is_edit_mode) {
                            $url = site_url('route_edit/' . $data['id']);
                        } else {
                            $url = site_url('add_route');
                        }
                        ?>
                        <form action="<?php echo $url ?>" method="post" id="add_route">
                            <div class="row mb-3">
                                <label for="trainSelect" class="col-sm-2 col-form-label">Select Train</label>
                                <div class="col-sm-10">
                                    <select name="train_id" id="trainSelect" class="form-control">
                                        <option value="" selected>Select train</option>
                                        <?php foreach ($trains as $train): ?>
                                            <?php $selected = ($train['id'] == $data['route_train']) ? 'selected' : ''; ?>
                                            <option value="<?php echo $train['id']; ?>" <?php echo $selected; ?>>                                            
                                                <?php echo $train['train_code'] . ' - ' . $train['train_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="startPoint" class="col-sm-2 col-form-label">Start Point</label>
                                <div class="col-sm-3">
                                    <select name="start_point" id="startPoint" class="form-control">
                                        <option value="" selected>Select start point</option>
                                        <?php foreach ($stations as $station): ?>
                                            <?php $selected = ($station['id'] == $data['route_start']) ? 'selected' : ''; ?>
                                            <option value="<?php echo $station['id']; ?>" <?php echo $selected; ?>><?php echo $station['station_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>  
                                <label for="departureTime" class="col-sm-2 col-form-label">Departure Time</label>
                                <div class="col-sm-3">
                                    <input type="time" value="<?= $data['departure_time'] ?>" name="departure_time" id="departureTime" class="form-control">
                                </div>      
                            </div>
                            <div class="row mb-3">
                                <label for="endPoint" class="col-sm-2 col-form-label">End Point</label>
                                <div class="col-sm-3">
                                    <select name="end_point" id="endPoint" class="form-control" onchange="generateRoute()">
                                        <option value="" selected>Select end point</option>
                                        <?php foreach ($stations as $station): ?>
                                            <?php $selected = ($station['id'] == $data['route_end']) ? 'selected' : ''; ?>
                                            <option value="<?php echo $station['id']; ?>" <?php echo $selected; ?>><?php echo $station['station_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <label for="arrival_time" class="col-sm-2 col-form-label">Arrival Time</label>
                                <div class="col-sm-3">
                                    <input type="time" value="<?= $data['arrival_time'] ?>" name="arrival_time" id="arrival_time" class="form-control">
                                </div>
                            </div>
                            <input type="hidden" value="<?= $data['route_train'] ?>" name="old_train_id">
                            <div class="row mb-3" id="routeStations">
                            </div>
                            <div class="row mb-3">
                                <label for="inputNumber" class="col-sm-2 col-form-label">Available Days</label>
                                <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="selectAllDays">
                                        <label class="form-check-label" for="selectAllDays">Select All</label>
                                    </div>
                                    <?php
                                    $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                                    foreach ($days as $key => $day) {
                                        $value = $key + 1;
                                        $checked = in_array(strval($value), explode(',', $data['avl_days'])) ? 'checked' : '';
                                    ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input avl-day-checkbox" type="checkbox" id="<?php echo $value; ?>" name="avl_days[]" value="<?php echo $value; ?>" <?php echo $checked; ?>>
                                            <label class="form-check-label" for="<?php echo $value; ?>"><?php echo $day; ?></label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-11">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>  
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
$(document).ready(function(){
    var isEditMode = <?php echo json_encode($is_edit_mode); ?>;
    if (isEditMode) {
        generateRoute();
    }   
    $('#selectAllDays').change(function() {
        var checked = $(this).is(':checked');
        $('.avl-day-checkbox').prop('checked', checked);
    });

    // Update "Select All" checkbox status based on individual checkbox status
    $('.avl-day-checkbox').change(function() {
        var totalCheckboxes = $('.avl-day-checkbox').length;
        var checkedCheckboxes = $('.avl-day-checkbox:checked').length;
        $('#selectAllDays').prop('checked', totalCheckboxes === checkedCheckboxes);
    });
});

var stationsData = <?php echo json_encode($stations); ?>;

function generateRoute() {
    var startPoint = document.getElementById('startPoint');
    var endPoint = document.getElementById('endPoint');
    var startIndex = stationsData.findIndex(station => station.id == startPoint.value);
    var endIndex = stationsData.findIndex(station => station.id == endPoint.value);
    var routeStations = "<?php echo $data['route_stations']; ?>";
    var routeStationsArray = routeStations.split('|');
    var routeStationsHTML = '';
    if (startIndex >= 0 && endIndex >= 0) {
        for (let i = 0; i < stationsData.length; i++) {
            for (let j = 0; j < stationsData.length; j++) {
                if (i != j) {
                    var fromStation = stationsData[i];
                    var toStation = stationsData[j];
                    var routeValue = fromStation.id + '-' + toStation.id;
                    var isChecked = routeStationsArray.some(routeStation => routeStation === (fromStation.id + ',' + toStation.id));
                    var checkedAttribute = isChecked ? 'checked' : '';
                    routeStationsHTML += `
                        <div>
                            <input type="checkbox" name="route_station[]" value="${routeValue}" ${checkedAttribute}>
                            ${fromStation.station_name} to ${toStation.station_name}
                        </div>`;
                }
            }
        }
        document.getElementById('routeStations').innerHTML = `
            <label class="col-sm-2 col-form-label">Route Stations</label>
            <div class="col-sm-10">${routeStationsHTML}</div>`;
    } else {
        document.getElementById('routeStations').innerHTML = '';
    }
}


</script>