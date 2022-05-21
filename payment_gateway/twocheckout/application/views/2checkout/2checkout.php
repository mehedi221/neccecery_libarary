<?php $this->load->view('templates/header');?>
<!-- container -->
<section class="showcase">
    <div class="container">
        <div class="pb-2 mt-4 mb-2 border-bottom">
            <h2>2Checkout Payment Gateway Integration in Codeigniter</h2>
        </div>
        <span id="success-msg" class="payment-errors"></span>
        <!-- 2Checkout payment form -->
        <form action="<?php print site_url(); ?>2checkout/callback" method="POST" id="myCCForm">
            <input id="token" name="token" type="hidden" value="">
            <input type="hidden" name="amount" value="<?php print number_format($itemInfo['price']);?>">
            <input type="hidden" name="product_name" value="<?php print $itemInfo['name'];?>">
            <input type="hidden" name="product_id" value="<?php print $itemInfo['product_id'];?>">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 pb-5">
                    <div class="row"></div>
                    <!--Form with header-->
                    <div class="card border-gray rounded-0">
                        <div class="card-header p-0">
                            <div class="bg-gray text-left py-2">
                                <h5 class="pl-2"><strong>Item Name: </strong><?php print $itemInfo['name'];?></h5>
                                <h6 class="pl-2"><strong>Price: </strong> $<?php print number_format($itemInfo['price']);?> USD</h6>
                            </div>
                        </div>

                        <div class="card-body p-3">
                            <!--Body-->
                            <div class="form-group">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Full Name</div>
                                    </div>
                                    <input type="text" class="form-control" id="2checkout-name" name="2checkout_name" placeholder="Full Name *" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Email</div>
                                    </div>
                                    <input type="email" class="form-control" id="2checkout-email" name="2checkout_email" placeholder="Email *" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Card Number</div>
                                    </div>
                                    <input id="ccNo" type="text" size="20" class="form-control" autocomplete="off" value="4000000000000002" placeholder="1234 5678 9012 3456" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <input type="text" class="form-control" name="tcheckout_month" placeholder="MM" maxlength="2" value="12" id="expMonth" required autocomplete="off"/>
                                </div>
                                <div class="form-group col-md-5">
                                    <input type="text" class="form-control" name="tcheckout_year" placeholder="YYYY" maxlength="4" value="2024" id="expYear" autocomplete="off" required />
                                </div>
                                <div class="form-group col-md-2">
                                    <input id="cvv" maxlength="4" type="text" class="form-control"  name="cvc" placeholder="CVC" value="757" autocomplete="off" required />
                                </div>
                            </div>

                            <div class="text-right">
                                <a href="<?php print site_url();?>" id="payBtn" class="btn btn-primary py-2">Back</a>
                                <button type="buttom" id="payBtn" class="btn btn-info py-2">Pay</button>
                            </div>

                        </div>

                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php $this->load->view('templates/footer');?>