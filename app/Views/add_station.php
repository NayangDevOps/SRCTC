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
              <?php $url = site_url('add_station'); ?>
              <form action="<?php echo $url ?>" method="post" id="add_train">
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Station Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="station_name" value="" class="form-control">
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

