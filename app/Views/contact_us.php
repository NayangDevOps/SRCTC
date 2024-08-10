<style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #f0f5f9;
    }

    #main {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .pagetitle {
      text-align: center;
      margin-bottom: 30px;
    }

    h1 {
      font-size: 36px;
      color: #007bff; 
    }

    .card {
      margin-top: 110px;
      max-width: 500px;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .card-body {
      text-align: center;
    }

    p {
      font-size: 18px;
      color: #555555;
      margin-bottom: 20px;
    }

    a {
      color: #007bff;
      text-decoration: none;
      transition: color 0.3s;
    }

    a:hover {
      color: #0056b3;
    }

    .star-rating {
    display: inline-block;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        font-size: 2em;
        color: #ddd;
        cursor: pointer;
        float: right;
    }

    .star-rating label:before {
        content: "\2605";
    }

    .star-rating input[type="radio"]:checked ~ label {
        color: #f90;
    }
</style>
<main id="main" class="main">
<div class="card">
      <div class="card-body">
        <h2>Have a Question or Feedback?</h2>
        <p>Feel free to reach out to us!</p>
        <p>You can contact us via email at <a href="mailto:contact@srctcticketbooking.com">contact@srctcticketbooking.com</a> or fill out the form below:</p>
        <form action="<?php echo site_url('contact_us'); ?>" method="POST">
            <div class="row mb-3">
                <label for="name" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="message" class="col-sm-3 col-form-label">Message</label>
                <div class="col-sm-9">
                    <textarea id="message" name="message" rows="4" class="form-control" required></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label for="rating" class="col-sm-3 col-form-label">Rating</label>
                <div class="col-sm-9">
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5"><label for="star5"></label>
                        <input type="radio" id="star4" name="rating" value="4"><label for="star4"></label>
                        <input type="radio" id="star3" name="rating" value="3"><label for="star3"></label>
                        <input type="radio" id="star2" name="rating" value="2"><label for="star2"></label>
                        <input type="radio" id="star1" name="rating" value="1"><label for="star1"></label>
                    </div>
                </div>
            </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
      </main>