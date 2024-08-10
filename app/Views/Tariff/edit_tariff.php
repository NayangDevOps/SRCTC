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
              if($head_title != 'Add Tariff'){
                $url = site_url('edit_tariff/' . $data['id']);
              }else {
                $url = site_url('add_tariff');
              }
              ?>
              <form action="" id="add_tariff">
              <div class="row mb-3">
                <label for="trainSelect" class="col-sm-2 col-form-label">Select Train</label>
                <div class="col-sm-10">
                <select name="train_id" id="trainSelect" class="form-control" onchange="fetch_data(this.value)">
                    <option value="" selected>Select train</option>
                    <?php foreach ($trains as $train): ?>
                        <?php $routeValue = getRoute($train['id']); ?>                        
                        <?php if (!empty($routeValue)): ?>
                            <?php $selected = ($routeValue == $data['route_id']) ? 'selected' : ''; ?>
                            <option value="<?php echo $routeValue; ?>" <?php echo $selected; ?>>
                                <?php echo $train['train_code'] . ' - ' . $train['train_name']; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                </div>
               </div>
              <div class="row mb-3" id="showClassDiv">
              </div>
                <div class="row mb-3">
                  <div class="col-sm-11">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>  
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <div class="modal fade" id="pricingModal" tabindex="-1" role="dialog" aria-labelledby="pricingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pricingModalLabel">Pricing Details</h5>
            </div>
            <div class="modal-body">
                <div id="pricingDetails">
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center w-100">
                <button type="button" id="savePrices" class="btn btn-secondary">Save</button>
                <button type="button" class="btn btn-secondary" onclick="closePopup('pricingModal')" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    var gstRate; 
    fetch_data(<?php echo json_encode($data['route_id']); ?>);
    $(document).on('keyup', '.routeKm', function() {
        var index = $(this).attr('id').replace('routeKm', '');
        var routeKm = parseFloat($(this).val());
        var routeRatesDefaultPkm = parseFloat($('#hiddenRouteRatesPkm' + index).val());
        var routeRate = routeKm * routeRatesDefaultPkm;
        $('#routeRatesPkm' + index).val(routeRate); 
    });    
    $('#add_tariff').submit(function (e) {
    e.preventDefault();
    var gstPercentage = prompt('Enter the GST percentage:', '18');
    if (gstPercentage === null) {
        return false;
    }
    gstPercentage = gstPercentage.replace(/\D/g, '');
    if (gstPercentage === '') {
        gstPercentage = '18';
    }
    var gstRate = parseFloat(gstPercentage) / 100;
    var formData = $(this).serialize() + '&gstRate=' + gstRate;
    $.ajax({
        url: '<?php echo $url ?>',
        type: 'POST',
        data: formData,
        success: function (response) {
            var updatedPrices = response.updatedPrices;
            var html = '';  
            html = '<table class="table table-bordered price-table">';
            html += '<thead><tr><th>From</th><th>To</th><th>Adult Price</th><th>Child Price</th><th>Senior Price</th><th style="display:none;">ID</th></tr></thead><tbody>';
            for (var i = 0; i < updatedPrices.length; i++) {
                html += '<tr>' +
                        '<td>' + updatedPrices[i].from_station + '</td>' +
                        '<td>' + updatedPrices[i].to_station + '</td>' +
                        '<td>' + parseFloat(updatedPrices[i].adult_price).toFixed(0) + '</td>' +
                        '<td>' + parseFloat(updatedPrices[i].child_price).toFixed(0) + '</td>' +
                        '<td>' + parseFloat(updatedPrices[i].senior_price).toFixed(0) + '</td>' +
                        '<td style="display:none;">' + updatedPrices[i].id + '</td>' +
                        '</tr>';
            }
            html += '</tbody></table>';
            $('#pricingDetails').html(html);
            $('#pricingModal').modal('show');   
        }
    });
    $('#savePrices').click(function(){
    var updatedPrices = [];
    $('#pricingDetails table tbody tr').each(function() {
        var from_station = $(this).find('td:eq(0)').text();
        var to_station = $(this).find('td:eq(1)').text();
        var adult_price = $(this).find('td:eq(2)').text();
        var child_price = $(this).find('td:eq(3)').text();
        var senior_price = $(this).find('td:eq(4)').text();
        var id = $(this).find('td:eq(5)').text();
        updatedPrices.push({
            from_station: from_station,
            to_station: to_station,
            adult_price: adult_price,
            child_price: child_price,
            senior_price: senior_price,
            id: id 
        });
    });

    $.ajax({
        url: '<?php echo site_url('save_price'); ?>',
        type: 'POST',
        data: {updatedPrices: updatedPrices},
        success: function(response) {
            $('#pricingModal').modal('hide');
            var currentURL = window.location.href;
            var newURL = currentURL.replace(/\/edit_tariff\/\d+/g, ''); 
            newURL += (newURL.includes('/') ? '/' : '/') + 'tariffs';
            window.location.href = newURL;
        },
        error: function(xhr, status, error) {
            alert('An error occurred while saving prices: ' + xhr.responseText);
        }
    });
        });
    });
});
function fetch_data(selectedValue) {
    if (!selectedValue) {
        selectedValue = '';
    }
    $.ajax({
        url: SiteURL + '/fetch_data',
        type: 'POST',
        data: { train_id: selectedValue },
        success: function(response) {
            $('#showClassDiv').empty(); 
            $.each(response, function(index, item) {
                var stationNames = item.station_names.split(' - ');
                var stationFrom = stationNames[0];
                var stationTo = stationNames[1];
                var routeKm = item.route_km ? item.route_km : '';
                var routeRatesPkm = item.route_rates ? parseFloat(item.route_rates).toFixed(0) : (item.route_default_rate_pkm ? parseFloat(item.route_default_rate_pkm).toFixed(0) : '');
                
                $('#showClassDiv').append('<input type="hidden" id="hiddenRouteRatesPkm' + index + '" value="' + routeRatesPkm + '">');
                $('#showClassDiv').append('<input type="hidden" name="hiddenID[]" value="' + item.id + '">');
                $('#showClassDiv').append('<div class="row mb-3">\
                    <label for="stationFrom' + index + '" class="col-sm-2 col-form-label">Station From</label>\
                    <div class="col-sm-4">\
                        <input type="text" class="form-control" id="stationFrom' + index + '" name="station_from[]" value="' + stationFrom + '" readonly>\
                    </div>\
                    <label for="stationTo' + index + '" class="col-sm-2 col-form-label">Station To</label>\
                    <div class="col-sm-4">\
                        <input type="text" class="form-control" id="stationTo' + index + '" name="station_to[]" value="' + stationTo + '" readonly>\
                    </div>\
                </div>\
                <div class="row mb-3">\
                    <label for="routeKm' + index + '" class="col-sm-2 col-form-label">Route KM</label>\
                    <div class="col-sm-4">\
                        <input type="number" class="form-control routeKm" id="routeKm' + index + '" name="route_km[]" value="' + routeKm + '">\
                    </div>\
                    <label for="routeRatesPkm' + index + '" class="col-sm-2 col-form-label">Route Rate</label>\
                    <div class="col-sm-4">\
                        <input type="number" class="form-control routeRatesPkm" id="routeRatesPkm' + index + '" name="route_rates_pkm[]" value="' + routeRatesPkm + '" readonly>\
                    </div>\
                </div>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
}
</script>
