<?php $this->load->view('templates/header');?>
<!-- container -->
<section class="showcase">
    <div class="container">
        <div class="pb-2 mt-4 mb-2 border-bottom">
            <h2>2Checkout Payment Gateway Integration in Codeigniter</h2>
        </div>
        <div class="text-xs-center">
            <?php if(!empty($msg)) { echo $msg;}?>
        </div>
    </div>
</section>
<?php $this->load->view('templates/footer');?>