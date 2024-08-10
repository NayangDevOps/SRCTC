<main id="main" class="main">
    <div class="pagetitle">
        <h1>Company Setting</h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-15">
                <div class="card">
                    <div class="card-body">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>
                        <h5 class="card-title"></h5>
                        <form class="profile-form" action="<?php echo site_url('comp_set'); ?>" method="post" enctype="multipart/form-data" id="comp_set">
                            <div class="row mb-3">
                                <label for="company_name" class="col-sm-2 col-form-label">Company Name</label>
                                <div class="col-sm-8">
                                    <input type="text" name="company_name" id="company_name" value="<?php echo $companyData[0]['company_name']; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="company_banner" class="col-sm-2 col-form-label">Company Banner</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="file" name="company_banner" id="company_banner">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary" onclick="viewImage('<?php echo base_url() . 'uploads/company/' . $companyData[0]['company_banner']; ?>')">View Image</button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="header_logo" class="col-sm-2 col-form-label">Company Header Logo</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="file" name="header_logo" id="header_logo">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary" onclick="viewImage('<?php echo base_url() . 'uploads/company/' . $companyData[0]['company_header_logo']; ?>')">View Image</button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="welcome_page_image" class="col-sm-2 col-form-label">Welcome Page Image</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="file" name="welcome_page_image" id="welcome_page_image">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary" onclick="viewImage('<?php echo base_url() . 'uploads/company/' . $companyData[0]['company_welcome_page_image']; ?>')">View Image</button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-11">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>  
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<div class="modal fade" id="imageViewModal" tabindex="-1" role="dialog" aria-labelledby="imageViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img id="imagePreview" src="" class="img-fluid mx-auto d-block" alt="Image Preview">
            </div>
        </div>
    </div>
</div>

<script>
    function viewImage(imageUrl) {
        var modal = $('#imageViewModal');
        var image = document.getElementById('imagePreview');        
        image.src = imageUrl;
        modal.modal('show');
    }
</script>
