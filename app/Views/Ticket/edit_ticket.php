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
              if($head_title == 'Update Ticket'){
                $url = site_url('ticket_edit/' . $data['id']);
              }
              ?>
              <form action="<?php echo $url; ?>" method="post" id="add_train">
                <div class="row mb-3">
                  <label for="passenger_name" class="col-sm-2 col-form-label">Passenger Name</label>
                  <div class="col-sm-10"> 
                    <input type="text" name="passenger_name" id="passenger_name" value="<?php echo $data['passenger_name']; ?>" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="passenger_email" class="col-sm-2 col-form-label">Passenger Email</label>
                  <div class="col-sm-10">
                    <input type="email" name="passenger_email" id="passenger_email" value="<?php echo $data['passenger_email']; ?>" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                    <label for="passenger_phone" class="col-sm-2 col-form-label">Passenger Number</label>
                    <div class="col-sm-10">
                    <input type="number" name="passenger_phone" id="passenger_phone" value="<?php echo $data['passenger_phone']; ?>" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                  <label for="inputNumberAge" class="col-sm-2 col-form-label">Passenger Age</label>
                  <div class="col-sm-4">
                    <input type="number" name="passenger_age" id="inputNumberAge" value="<?php echo $data['passenger_age']; ?>" class="form-control" readonly>
                  </div>
                  <label for="ticket_date" class="col-sm-2 col-form-label">Departure Date</label>
                  <div class="col-sm-4">
                    <input type="text" name="ticket_date" id="ticket_date" value="<?php echo $data['ticket_date']; ?>" class="form-control" readonly>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="from_station" class="col-sm-2 col-form-label">From Station</label>
                  <div class="col-sm-4">
                    <input type="text" name="from_station" id="from_station" value="<?php echo getStation($data['from_station']); ?>" class="form-control" readonly>
                  </div>
                  <label for="to_station" class="col-sm-2 col-form-label">To Station</label>
                  <div class="col-sm-4">
                    <input type="text" name="to_station" id="to_station" value="<?php echo getStation($data['to_station']); ?>" class="form-control" readonly>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="coach" class="col-sm-2 col-form-label">Coach Type</label>
                  <div class="col-sm-4">
                    <input type="text" name="coach" id="coach" value="<?php echo getCoaches($data['selected_coach']); ?>" class="form-control" readonly>
                  </div>
                  <label for="ticket_price" class="col-sm-2 col-form-label">Ticket Price</label>
                  <div class="col-sm-4">
                    <input type="text" name="ticket_price" id="ticket_price" value="<?php echo $data['ticket_price']; ?>" class="form-control" readonly>
                  </div>
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