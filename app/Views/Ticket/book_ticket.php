<main id="main" class="main">
    <div class="pagetitle">
        <h1><?php echo $head_title; ?></h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Book Your Ticket</h5>
                        <form action="<?php echo site_url('search_ticket'); ?>" method="POST" id="book_ticket">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="start_point" class="form-label">From Station</label>
                                    <select name="start_point" id="startPoint" class="form-control">
                                        <option value="" selected>Select departure station</option>
                                        <?php foreach ($stations as $station): ?>
                                            <option value="<?php echo $station['id']; ?>" <?php echo $station['id'] == $submitted_data['route_start'] ? 'selected' : ''; ?>><?php echo $station['station_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="end_point" class="form-label">To Station</label>
                                    <select name="end_point" id="endPoint" class="form-control">
                                        <option value="" selected>Select arrival station</option>
                                        <?php foreach ($stations as $station): ?>
                                            <option value="<?php echo $station['id']; ?>" <?php echo $station['id'] == $submitted_data['route_end'] ? 'selected' : ''; ?>><?php echo $station['station_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="travel_date" class="form-label">Travel Date</label>
                                    <input type="date" name="travel_date" id="travel_date" class="form-control" value="<?= isset($submitted_data['travel_date']) ? esc($submitted_data['travel_date']) : '' ?>">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" id="filter" class="btn btn-primary w-100">Submit</button>
                                </div>
                            </div>
                        </form>            
                        <?php 
                        if ($results) {
                            if (!empty($results)) {
                                $bookingCount = count($results['booking_options']);
                                $fromStation = htmlspecialchars(getStation($results['from_station']));
                                $toStation = htmlspecialchars(getStation($results['to_station']));
                            ?>
                            <div id="booking_summary" class="summary-box card">
                                <h2 class="summary-head">
                                    <i id="custom-icon-summary" class="bi bi-info-circle"></i>
                                    Booking Options from <?php echo $fromStation; ?> to <?php echo $toStation; ?>
                                </h2>
                                <p class="summary-content">
                                    We found <?php echo $bookingCount; ?> booking option(s) for your trip.
                                </p>
                            </div>
                            <?php 
                                foreach ($results['booking_options'] as $booking) {
                                    $coachesArray = explode(',', $booking['trainData']['coaches']);
                            ?>
                            <div id="booking_results">
                                <div class="info-box card">
                                    <h3 class="custom-head">
                                        <i id="custom-icon" class="bi bi-train-front-fill"></i>
                                        <?php echo htmlspecialchars($booking['trainData']['train_name']) . " (" . htmlspecialchars($booking['trainData']['train_code']) . ")"; ?>
                                        <span class="runs-on-label">
                                            Runs On: <?php echo htmlspecialchars(formatRunsOnLabel($booking['routeData']['avl_days'])); ?>
                                        </span>
                                    </h3>
                                    <p class="custom-content">
                                        <span class="station-label">From: <?php echo $fromStation; ?></span>
                                        <?php 
                                        $routeKm = $booking['tariff_data']['route_km'];
                                        $speed = 80;
                                        $travelTimeHours = $routeKm / $speed;
                                        $hours = floor($travelTimeHours);
                                        $minutes = round(($travelTimeHours - $hours) * 60);
                                        $travelTimeFormatted = sprintf('%d hours %d minutes', $hours, $minutes);
                                        ?>
                                        <span class="travel-time-label">Travel Time: <?php echo $travelTimeFormatted; ?></span>
                                        <span class="station-left-label">To: <?php echo $toStation; ?></span><br>
                                    </p>
                                    <div class="form-group inline-buttons"> 
                                        <?php foreach ($coachesArray as $coach) { ?>
                                            <div class="coach-button-wrapper">
                                                <button type="button" class="btn btn-secondary toggle-button" data-availability="<?php echo $coach; ?>" data-coach="<?php echo htmlspecialchars(getCoaches(trim($coach))); ?>">
                                                    <i id="custom-icon-refresh" class="bi bi-arrow-repeat"></i>
                                                    <?php echo htmlspecialchars(getCoaches(trim($coach))); ?>
                                                </button>
                                                <div class="availability-info" style="display: none;">
                                                    <span></span>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        </div>
                                        <div class="form-group inline-buttons"> 
                                        <div class="book-now-button-wrapper" style="margin-top: 10px;">
                                            <button type="button" class="btn cart-btn btn-primary book-now-btn" data-train= '<?php echo json_encode($booking['trainData']['id']); ?>' data-coaches='<?php echo json_encode($coachesArray); ?>' data-tariff='<?php echo json_encode($booking['tariff_data']); ?>' >
                                                <i class="bi bi-cart-fill"></i> Book Now
                                            </button>
                                        </div>
                                        </div>
                                </div>               
                            </div>
                            <?php 
                                }
                            }else{ ?>
                                <div id="booking_summary" class="summary-box card text-center">
                                    <div class="card-body">
                                        <h2 class="summary-head text-danger">
                                            <i class="bi bi-info-circle"></i>
                                            No Booking Options Found
                                        </h2>
                                        <p class="summary-content">
                                            Sorry, we couldn't find any booking options for your selected route. Please try again with different stations or dates.
                                        </p>
                                    </div>
                                </div>
                                <?php 
                                    }
                                } else { ?>
                                    <div id="booking_summary" class="summary-box card text-center">
                                        <div class="card-body">
                                            <h2 class="summary-head text-danger">
                                                <i class="bi bi-info-circle"></i>
                                                No Results Found
                                            </h2>
                                            <p class="summary-content">
                                                Please apply search  option for finding route.
                                            </p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
</section>
</main>

<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title" id="bookingModalLabel">Book Ticket</h5>
            </div>
            <form action="<?php echo site_url('book_ticket'); ?>" id="bookingModal" method="POST">
                <div class="modal-body">
                    <div class="form-group custom-input">
                        <label for="passenger_name">Passenger Name</label>
                        <input type="text" name="passenger_name" id="passenger_name" class="form-control custom-input" required>
                    </div>
                    <div class="form-group custom-input">
                        <label for="passenger_email">Passenger Email Address</label>
                        <input type="email" name="passenger_email" id="passenger_email" class="form-control custom-input" required>
                    </div>
                    <div class="form-group custom-input">
                        <label for="passenger_phone">Passenger Phone Number</label>
                        <input type="tel" name="passenger_phone" id="passenger_phone" class="form-control" required>
                    </div>
                    <div class="form-group custom-input">
                        <label for="passenger_age">Passenger Age</label>
                        <input type="number" name="passenger_age" id="passenger_age" class="form-control" required>
                    </div>
                    <div class="form-group custom-input">
                        <label for="from_station">From Station</label>
                        <input type="text" name="from_station" id="from_station" value="<?= getStation($submitted_data['route_start']); ?>" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="from_station_id" value="<?= $submitted_data['route_start']; ?>">
                    <input type="hidden" name="train_name" id="train_name" value="">

                    <div class="form-group custom-input">
                        <label for="to_station">To Station</label>
                        <input type="text" name="to_station" id="to_station" value="<?= getStation($submitted_data['route_end']); ?>" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="to_station_id" value="<?= $submitted_data['route_end']; ?>">
                    <div class="form-group custom-input">
                        <label for="ticket_date">Date</label>
                        <input type="text" name="ticket_date" id="ticket_date" value="<?= isset($submitted_data['travel_date']) ? esc($submitted_data['travel_date']) : '' ?>" class="form-control" readonly>
                    </div>
                    <div class="form-group custom-input">
                        <label for="coach_type">Select Coach Type</label>
                        <select name="coach_type" id="coach_type" class="form-control" required>
                            <option value="" selected>Select Coach Type</option>
                        </select>
                    </div>
                    <div class="form-group custom-input">
                        <label for="ticket_price">Total Ticket Price</label>
                        <input type="text" name="ticket_price" id="ticket_price" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>                    
                    <button type="submit" class="btn btn-primary">Book</button> 
                </div>
            </form>
        </div>
    </div>
</div>
<script>
const coachNames = {
    '1': 'AC 1 Tier(1A)',
    '2': 'AC 2 Tier(2A)',
    '3': 'AC 3 Tier(3A)',
    '4': 'Economy(3E)',
    '5': 'Sleeper(SL)'
};
function getCoaches(coach) {
    return coachNames[coach] || 'Unknown';
}
function cleanText(text) {
    return text.replace(/\s+/g, ' ').trim();
}
function updateTicketPrice(tariffData, age, coachType) {
    let basePrice;
    if (age < 18) {
        basePrice = Number(tariffData.child_price);
    } else if (age >= 18 && age <= 59) {
        basePrice = Number(tariffData.adult_price);
    } else {
        basePrice = Number(tariffData.senior_price);
    }
    let coachPriceIncrease = {
        '1': 300,
        '2': 250,
        '3': 200,
        '4': 150,
        '5': 100
    };    
    let additionalPrice = coachPriceIncrease[coachType] || 0;
    let price = basePrice + additionalPrice;    
    document.getElementById('ticket_price').value = !isNaN(price) ? price : 'N/A';
}
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.book-now-btn').forEach(button => {
        button.addEventListener('click', () => {
            let coaches = JSON.parse(button.getAttribute('data-coaches'));
            let tariffData = JSON.parse(button.getAttribute('data-tariff'));
            let data_train = JSON.parse(button.getAttribute('data-train'));
            let bookingModal = new bootstrap.Modal(document.getElementById('bookingModal'));
            let coachTypeSelect = document.getElementById('coach_type');
            let form = document.querySelector('#bookingModal form');
            form.reset();
            coachTypeSelect.innerHTML = '';
            document.getElementById('train_name').value = data_train;
            let defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select Coach Type';
            defaultOption.selected = true;
            defaultOption.disabled = true;
            coachTypeSelect.appendChild(defaultOption);
            coaches.forEach(coach => {
                let option = document.createElement('option');
                option.value = cleanText(coach);
                option.textContent = getCoaches(cleanText(coach));
                coachTypeSelect.appendChild(option);
            });
            bookingModal.show();
            document.getElementById('passenger_age').addEventListener('input', function() {
                let age = this.value;
                let coachType = document.getElementById('coach_type').value;
                if (age && coachType) {
                    updateTicketPrice(tariffData, age, coachType);
                } else {
                    document.getElementById('ticket_price').value = '';
                }
            });
            document.getElementById('coach_type').addEventListener('change', function() {
                let age = document.getElementById('passenger_age').value;
                let coachType = this.value;
                if (age && coachType) {
                    updateTicketPrice(tariffData, age, coachType);
                } else {
                    document.getElementById('ticket_price').value = '';
                }
            });
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-button').forEach(button => {
        button.addEventListener('click', () => {
            let coach = button.getAttribute('data-availability');
            let fromStation = '<?= $submitted_data['route_start']; ?>';
            let toStation = '<?= $submitted_data['route_end']; ?>';
            let travelDate = '<?= $submitted_data['travel_date']; ?>';
            let availabilityInfo = button.parentElement.querySelector('.availability-info');
            availabilityInfo.innerHTML = '<span>Checking availability...</span>';
            availabilityInfo.style.display = 'block';
            fetch('<?= site_url('check_availability'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    coach: coach,
                    from_station: fromStation,
                    to_station: toStation,
                    travel_date: travelDate
                }),
            })
            .then(response => response.json())
            .then(data => { 
                if (data.success) {
                    availabilityInfo.innerHTML = `<span>${data.availability} availability</span>`;
                } else {
                    availabilityInfo.innerHTML = '<span>Availability check failed</span>';
                }
            })
            .catch(error => {
                availabilityInfo.innerHTML = '<span>Error checking availability</span>';
            });
        });
    });
});
</script>
<style>
.modal-content {
  margin-top: 80px;
  max-height: 500px;
  overflow-y: auto;
}
.modal-content::-webkit-scrollbar{
    width: 12px;
}
.modal-content::-webkit-scrollbar-track{
    background-color: white;
    border-radius: 10px;
}
.modal-content::-webkit-scrollbar-thumb{
    background-color: #f3dee8;
    border-radius: 10px;
}
.modal-header {
    color: #fff;
    background-color: #2f2f8f;
    font-weight: bold;
}
.info-box {
    padding: 15px;
    margin-bottom: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.custom-head {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.stations {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: 20px;
}

.station {
    font-size: 1em;
}

.station-label {
    display: inline-block;
    margin-right: 20px;
    font-weight: bold;
}

.summary-box {
    padding: 20px;
    margin-bottom: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.summary-head {
    font-size: 20px;
    margin-bottom: 10px;
}

.summary-content {
    font-size: 15px;
}

.inline-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 10px;
}

.toggle-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px 15px; 
}

i#custom-icon-refresh {
    margin-right: 5px;
}

button.toggle-button {
    margin-left: 10px;
    background-color: #2f2f8f;
    font-weight: bold;
}

#custom-icon {
    margin-right: 15px;
}

.custom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-left: 10px;
}

h3.custom-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-left: 0;
    font-size: 20px;
    font-weight: bold;
    color: #fff;
    background-color: #2f2f8f;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    padding: 10px;
}

.runs-on-label {
    margin-left: auto;
    margin-right: auto;
    font-size: small;
}

.pagetitle h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

.card-title {
    font-size: 20px;
    margin-bottom: 20px;
}

.form-label {
    font-weight: bold;
    color: #2f2f8f;
}

#booking_results {
    margin-top: 25px;
}

button#filter {
    margin-top: 30px;
}

form#book_ticket {
    margin-top: -15px;
}

span.travel-time-label {
    font-weight: bold;
}

span.station-left-label {
    font-weight: bold;
}

.availability-info {
    margin-top: 10px;
    margin-left: 10px;
    font-weight: bold;
    color: #ffffff;
    background-color: #20b720;
    border-radius: 4px;
    text-align: center;
}
button.btn.cart-btn.btn-primary {
    margin-left: 10px;
}
</style>
<style>
.modal {
    transition: opacity 0.5s ease;
}

.overlay-active .modal {
    pointer-events: none;
    opacity: 0;
}

.modal.show {
    pointer-events: auto;
    opacity: 1;
}

.modal-dialog {
    margin: auto;
}

.overlay-active {
    overflow: hidden;
}

.overlay-active > *:not(.modal) {
    transition: opacity 0.5s ease;
    pointer-events: none;
    opacity: 0.5;
}
.custom-input{
   margin-top: 10px;
}
</style>
