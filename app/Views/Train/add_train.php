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
              if($head_title == 'Update Train'){
                $url = site_url('train_edit/' . $data['id']);
              }else {
                $url = site_url('add_train');
              }
              ?>
              <form action="<?php echo $url ?>" method="post" id="add_train">
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Train Code</label>
                  <div class="col-sm-10">
                  <?php if(empty($data['train_code'])){
                      $id= 'trainCodeInput';
                   }else{
                      $id="";
                   }
                    ?> 
                    <input type="text" name="train_code" id="<?php echo $id;?>" value="<?php echo $data['train_code']; ?>" class="form-control " readonly>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Train Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="train_name" value="<?php echo $data['train_name']; ?>" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                    <label for="inputNumber" class="col-sm-2 col-form-label">Available Coaches</label>
                    <div class="col-sm-10">
                        <?php
                        $selectedCoaches = explode(',', $data['coaches']);
                        ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="1A" name="coaches[]" value="1" <?php if(in_array('1', $selectedCoaches)) echo 'checked'; ?>>
                            <label class="form-check-label" for="1A">1A(First Class AC)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="2A" name="coaches[]" value="2" <?php if(in_array('2', $selectedCoaches)) echo 'checked'; ?>>
                            <label class="form-check-label" for="2A">2A(Two-Tier AC)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="3A" name="coaches[]" value="3" <?php if(in_array('3', $selectedCoaches)) echo 'checked'; ?>>
                            <label class="form-check-label" for="3A">3A(Three-Tier AC)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="3E" name="coaches[]" value="4" <?php if(in_array('4', $selectedCoaches)) echo 'checked'; ?>>
                            <label class="form-check-label" for="3E">3E(Three-Tier AC-Economy)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="SL" name="coaches[]" value="5" <?php if(in_array('5', $selectedCoaches)) echo 'checked'; ?>>
                            <label class="form-check-label" for="SL">SL(Sleeper Class-Non AC)</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">K.M. Rate (Rs.)</label>
                  <div class="col-sm-10">
                    <input type="number" name="rate" value="<?php echo $data['rates']; ?>" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Release Date</label>
                  <div class="col-sm-10">
                    <input type="date" name="release_date" value="<?php echo $data['release_date']; ?>" class="form-control">
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