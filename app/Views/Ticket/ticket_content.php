<?php 
echo '<div class="container">
<div class="row">';
echo '<div class="ticket-container">';
foreach ($data as $ticket) {
    echo '<div class="ticket">';
    echo '<div class="ticket__main">';
    echo '<header class="header-ticket">' . train_details($ticket['train_name'])['train_code'] . ' - ' . train_details($ticket['train_name'])['train_name'] . '</header>';
    echo '<div class="info passenger">';
    echo '<div class="info__item">Passenger Name:</div>';
    echo '<div class="info__detail">' . $ticket['passenger_name'] . '</div>';
    echo '</div>';    
    echo '<div class="info passenger-email">';
    echo '<div class="info__item">Passenger Email:</div>';
    echo '<div class="info__detail">' . $ticket['passenger_email'] . '</div>';
    echo '</div>';
    echo '<div class="info passenger-phone">';
    echo '<div class="info__item">Passenger Phone:</div>';
    echo '<div class="info__detail">' . $ticket['passenger_phone'] . '</div>';
    echo '</div>';
    echo '<div class="info passenger-age">';
    echo '<div class="info__item">Passenger Age:</div>';
    echo '<div class="info__detail">' . $ticket['passenger_age'] . '</div>';
    echo '</div>';
    echo '<div class="info departure">';
    echo '<div class="info__item">From:</div>';
    echo '<div class="info__detail">' . getStation($ticket['from_station']) . '</div>';
    echo '</div>';
    echo '<div class="info arrival">';
    echo '<div class="info__item">To:</div>';
    echo '<div class="info__detail">' . getStation($ticket['to_station']) . '</div>';
    echo '</div>';
    echo '<div class="info date">';
    echo '<div class="info__item">Departure Date:</div>';
    echo '<div class="info__detail">' . $ticket['ticket_date'] . '</div>';
    echo '</div>';
    echo '<div class="info passenger-time">';
    echo '<div class="info__item">Departure Time:</div>';
    echo '<div class="info__detail">' . getRouteData(getRoute($ticket['train_name']))['departure_time'] . '</div>';
    echo '</div>';
    echo '<div class="info passenger-coach">';
    echo '<div class="info__item">Coach:</div>';
    echo '<div class="info__detail">' . getCoaches($ticket['selected_coach']) . '</div>';
    echo '</div>';
    echo '<div class="info passenger-price">';
    echo '<div class="info__item">Price :</div>';
    echo '<div class="info__detail">₹ ' . $ticket['ticket_price'] . '</div>';
    echo '</div>';
    echo '<div class="fineprint">';
    echo '<p>Non-refundable, non-transferable</p>';
    echo '<p>Please arrive 15 minutes before departure</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
echo '</div>';
?>
<script>
    function cancelTicket(ticketId) {
    if (confirm("Are you sure you want to cancel this ticket?")) {
        var xhr = new XMLHttpRequest();
        var url = "<?= site_url('cancelTicket') ?>/" + ticketId; 
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    var ticketCard = document.getElementById("ticket-" + ticketId);
                    var cancelButton = ticketCard.querySelector(".cancel-button");
                    cancelButton.style.display = "none";
                    var cancelledStatus = document.createElement("p");
                    cancelledStatus.className = "cancelled-status";
                    cancelledStatus.textContent = "Cancelled";
                    ticketCard.appendChild(cancelledStatus);
                } else {
                    alert("Failed to cancel the ticket. Please try again.");
                }
            } else {
                console.error("Failed to cancel the ticket.");
            }
        };
        xhr.send();
    }
}
</script>
<style>
.ticket:hover {
    transform: scale(1.02);
}
.ticket {
  display: grid;
  grid-template-columns: auto 143px;
  background: #fff;
  border-radius: 10px;
  border: 2px solid #000;
  cursor: default;
  margin-top: 20px;
}
.ticket__main {
  display: grid;
  grid-template-columns: repeat(6, 1fr) 120px;
  grid-template-rows: repeat(4, min-content) auto;
  padding: 10px;
  width: 900px;
}
.header-ticket {
  grid-area: title;
  grid-column: span 7;
  grid-row: 1;
  font: 900 38px 'Montserrat', sans-serif;
  padding: 5px 0 5px 20px;
  letter-spacing: 6px;
  background: #030360ed;
  color: #fff;
}
.info {
  border: 3px solid;
  border-width: 0 3px 3px 0;
  padding: 8px;
}
.info__item {
  font: 400 13px 'Questrial', sans-serif;
  letter-spacing: 0.5px;
}
.info__detail {
  font: 700 20px/1 'Jura';
  letter-spacing: 1px;
  margin: 4px 0;
}
.passenger {
  grid-column: 1 / span 7; 
}
.passenger-email {
  grid-column: 1 / span 3;
}
.passenger-phone {
  grid-column: 4 / span 2;
}
.passenger-age {
  grid-column: 6 / span 2; 
}
.passenger-time {
  grid-column: 1 / span 3;
}
.passenger-coach {
  grid-column: 1 / span 3;
}
.passenger-price {
    grid-column-start: span 3;
}
.departure, .arrival {
  grid-column-start: span 2;
}
.passenger-time, .passenger-coach {
  grid-column-start: span 2;
}
.passenger, .passenger-email, .departure, .passenger-time {
  border-left: 3px solid;
}
.date {
  grid-column-start: span 3;
}
.fineprint {
  grid-column-start: span 7;
  font-size: 14px;
  font-family: 'Inconsolata';
  line-height: 1;
  margin-top: 10px;
  padding-right: 5px;
}
.fineprint p:nth-child(2) {
  margin: 4px 4px 0 0;
  padding-top: 4px;
  border-top: 1.5px dotted;
  font: 11px/1 'Inconsolata';
}
</style>