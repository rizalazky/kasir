<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Majoo Teknologi Indonesia</title>
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />

</head>
<body>
    <nav class="navbar navbar-dark bg-dark p-3 fixed-top">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Majoo Teknologi Indonesia</span>
    </div>
    </nav>
    <div class="container-fluid py-5">
        <h3 class="h3 p-4">Products</h3>
        <div class="d-flex flex-wrap justify-content-center">
            <?php foreach ($products as $product) : ?>
                <div class="card m-2" style="width: 25rem;">
                    <img src="<?php echo base_url('/img/products/'.$product['product_image'])?>" style="height:300px;object-fit:contain;" class="card-img-top img-fluid img-thumbnail" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['product_name'];?></h5>
                        <p class="card-text"><?php echo $product['product_desc'];?></p>
                        
                    </div>
                    <div class="card-footer">
                    <a href="#" class="btn btn-primary">Order</a>
                    </div>
                </div>
            <?php endforeach ; ?>
            
            
        </div>
    </div>

    <script src="<?= base_url('js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
</body>
</html>