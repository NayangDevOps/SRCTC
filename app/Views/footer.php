<?php
 if ($head_title != 'Login Page' && $head_title != 'Sign Up Page') {
?>
<footer id="footer" class="footer">
    <div class="copyright">
    <?php
    $current_year = date("Y");
    $next_year = substr($current_year,-2);        
    ?>
    &copy; 2024
    <!-- -<?php echo $next_year;?>  -->
    <strong><span><?php echo $companyData[0]['company_name']; ?></span></strong> All Rights Reserved.
    </div>
  </footer>
  <script src="<?php echo base_url(); ?>public/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/chart.js/chart.umd.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/echarts/echarts.min.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/quill/quill.min.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?php echo base_url(); ?>public/vendor/php-email-form/validate.js"></script>
  <script src="<?php echo base_url(); ?>public/js/main.js"></script>
  <script src="<?php echo base_url(); ?>public/js/common.js"></script>
<?php } ?>
</body>

</html>