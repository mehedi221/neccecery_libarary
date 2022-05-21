<!DOCTYPE html>
<html>
<head>
    <title>Paypal Payment Gateway In Codeigniter - Tutsmake.com</title>
    <!-- Latest CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
<div class="container">
    <h2 class="mt-3 mb-3">Products</h2>
    <div class="row">
        <?php if(!empty($products)): foreach($products as $product): ?>
            <div class="thumbnail">
                <img src="<?php echo base_url().'assets/images/'.$product['image']; ?>" alt="">
                <div class="caption">
                    <h4 class="pull-right">$<?php echo $product['price']; ?> USD</h4>
                    <h4><a href="javascript:void(0);"><?php echo $product['name']; ?></a></h4>
                </div>
                <a href="<?php echo base_url().'products/buyProduct/'.$product['id']; ?>"><img src="<?php echo base_url(); ?>assets/images/buy-button" style="width: 70px;"></a>
            </div>
        <?php endforeach; endif; ?>
    </div>
</div>
</body>
</html>