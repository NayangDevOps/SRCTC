<style>
  body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f0f5f9; /* Light blue background */
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
    color: #007bff; /* Blue title */
  }

  .card {
    max-width: 500px;
    padding: 30px;
    background-color: #ffffff; /* White card background */
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
</style>
<main id="main" class="main">
  <div class="card">
    <div class="card-body">
      <h2>About Us</h2>
      <p>Welcome to SRCTC Train Ticket Booking!</p>
      <p>We are dedicated to providing a seamless booking experience for train travelers across Saurashtra. Our platform aims to simplify the ticket booking process and make it convenient for passengers to plan their journeys.</p>
      <p>For any inquiries or assistance, feel free to <a href="<?php echo site_url('contact_us'); ?>">contact us</a>.</p>
    </div>
  </div>
</main>
