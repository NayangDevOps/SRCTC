<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
    </div>
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
    <div id="success-alert" class="alert alert-success" style="display: none;"></div>
    <div id="error-alert" class="alert alert-danger" style="display: none;"></div>
    <section class="section dashboard">
      <div class="row">
      <?php
          $session = session();
          $id = $session->get('user_id');
          $user = user_data($id);
          echo "<input type='hidden' value='" . $user['user_type'] . "' id='user-type'>";
          if($user['user_type'] == 10 || $user['user_type'] == 20){ ?>
        <div class="col-lg-12">
          <div class="row">
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item filter-option" data-filter="today" href="#">Today</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="month" href="#">This Month</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="year" href="#">This Year</a></li>
                  </ul>
                </div>
                <div class="card-body">
                  <h5 class="card-title">Total Book Ticket By <span id="filter-title">| Today</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                    <h6 id="total_tickets">Loading...</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
                <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item filter-options" data-filter="today" href="#">Today</a></li>
                    <li><a class="dropdown-item filter-options" data-filter="month" href="#">This Month</a></li>
                    <li><a class="dropdown-item filter-options" data-filter="year" href="#">This Year</a></li>
                </ul>
            </div>
            <div class="card-body">
                <h5 class="card-title">Revenue <span id="revenue-filter-title">| Today</span></h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-currency-rupee"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="total_revenue">Loading...</h6>
                    </div>
                </div>
            </div>
              </div>              
            </div>
            <div class="col-xxl-4 col-xl-12">
              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">Total Users : <?php echo $data; ?></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h5 class="us-label">Super Admin : <?php echo $countUsersByType['super_admin']; ?></h5>
                    </div>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h5 class="us-label">Admin : <?php echo $countUsersByType['admin_users']; ?></h5>
                    </div>  
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h5 class="us-label">Loco Pilot : <?php echo $countUsersByType['loco_pilot']; ?></h5>            
                    </div>  
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h5 class="us-label">Normal User : <?php echo $countUsersByType['normal_users']; ?></h5>
                    </div>  
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
            <div class="col-lg-6">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">User Registration Statistics</h5>
                  <div class="filter-container">
                    <label>
                      <input type="radio" name="filter" value="week" checked> Week
                    </label>  
                    <label>
                      <input type="radio" name="filter" value="month"> Month
                    </label>
                    <label>
                      <input type="radio" name="filter" value="year"> Year
                    </label>
                  </div>
                  <canvas id="myChart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Ticket Booking Statistics</h5>
                  <div class="filter-container">
                    <label>
                      <input type="radio" name="filter_ticket" value="week" checked> Week
                    </label>
                    <label>
                      <input type="radio" name="filter_ticket" value="month"> Month
                    </label>
                    <label>
                      <input type="radio" name="filter_ticket" value="year"> Year
                    </label>
                  </div>
                  <canvas id="myticketChart"></canvas>
                </div>
              </div>
            </div>
            </div>
            <?php } ?>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body pb-0 custom-body">
              <h5 class="card-title">News &amp; Updates</></h5>
              <?php if($user['user_type'] == 10 || $user['user_type'] == 20){ ?>
              <button type="button" onclick="openAddNewsModal()" class="btn btn-primary news-button">Add News</button>
              <?php } ?>
              <div id="news-container">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</main>
<!-- Modal -->
<div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="addNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewsModalLabel">Add News</h5>
            </div>
            <div class="modal-body">
                <form id="newsForm" enctype="multipart/form-data">
                    <div class="form-group mb-4">
                        <label for="newsTitle"><i class="fas fa-heading"></i> Title</label>
                        <input type="text" class="form-control" id="newsTitle" name="title" placeholder="Enter news title" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="newsDescription"><i class="fas fa-align-left"></i> Description</label>
                        <textarea class="form-control" id="newsDescription" name="description" rows="4" placeholder="Enter news description" required></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="newsImage"><i class="fas fa-image"></i> Image</label>
                        <input type="file" class="form-control-file" id="newsImage" name="image" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" onclick="add_new_news()" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closePopup('addNewsModal');"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
<script>
if ($('#myChart').length) {
    let myChart;
    async function fetchData(filter) {
      const response = await fetch(`<?= site_url('user') ?>?filter=${filter}`);
      const data = await response.json();
      return data;
    }
    function renderChart(data, filter) {
      const ctx = document.getElementById('myChart').getContext('2d');
      let xAxisLabel = 'Date';
      if (filter === 'week') {
        xAxisLabel = 'Day';
      } else if (filter === 'month') {
        xAxisLabel = 'Date';
      } else if (filter === 'year') {
        xAxisLabel = 'Month';
      }
      if (myChart) {
        myChart.destroy();  
      }
      const maxCount = Math.max(...data.counts);
      myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.labels,
          datasets: [{
            label: 'User Registrations',
            data: data.counts,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
              max: Math.ceil(maxCount / 10) * 10, 
              ticks: {
                stepSize: Math.ceil(maxCount / 10) || 1,
                callback: function(value, index, values) {
                  return (index % 2 === 0) ? value : '';
                }
              },
              title: {
                display: true,
                text: 'Number of Registrations'
              }
            },
            x: {
              title: {
                display: true,
                text: xAxisLabel
              } 
            }
          }
        }
      });
    }
    document.addEventListener('DOMContentLoaded', async function () {
      let filter = 'week';
      const data = await fetchData(filter);
      renderChart(data, filter);
      document.querySelectorAll('input[name="filter"]').forEach(input => {
        input.addEventListener('change', async function () {
          filter = this.value;
          const data = await fetchData(filter);
          renderChart(data, filter);
        });
      });
    });
}
if ($('#myticketChart').length) {
    let myticketChart;
    async function fetchData(filter) {
        const response = await fetch(`<?= site_url('getTicketData') ?>?filter=${filter}`);
        const data = await response.json();
        return data;
    }
    function renderChart(data, filter) {
        const ctx = document.getElementById('myticketChart').getContext('2d');
        let xAxisLabel = 'Date';

        if (filter === 'week') {
            xAxisLabel = 'Day';
        } else if (filter === 'month') {
            xAxisLabel = 'Date';
        } else if (filter === 'year') {
            xAxisLabel = 'Month';
        }

        if (myticketChart) {
            myticketChart.destroy();
        }

        const maxCount = Math.max(...data.counts);

        myticketChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Ticket Booking',
                    data: data.counts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: Math.ceil(maxCount / 10) * 10,
                        ticks: {
                            stepSize: Math.ceil(maxCount / 10) || 1,
                            callback: function(value) {
                                return value;
                            }
                        },
                        title: {
                            display: true,
                            text: 'Number of Ticket Booking'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: xAxisLabel
                        }
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', async function () {
        let filter = 'week';
        const data = await fetchData(filter);
        renderChart(data, filter);

        document.querySelectorAll('input[name="filter_ticket"]').forEach(input => {
            input.addEventListener('change', async function () {
                filter = this.value;
                const data = await fetchData(filter);
                renderChart(data, filter);
            });
        });
    });
}

</script>