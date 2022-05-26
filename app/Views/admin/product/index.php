<?= $this->extend('admin/layouts/layout') ?>
    <?= $this->section('content') ?>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Product
        </button>

        <?= $this->include('admin/product/modal') ?>
        <table class="table table-responsive">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Categories</th>
                <th scope="col">Price</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($products as $product){
                ?>
                    <tr>
                        <td><?= $product['id'] ;?></td>
                        <td><?= $product['product_name'] ;?></td>
                        <td><?= $product['category_id'] ;?></td>
                        <td><?= $product['product_price'] ;?></td>
                        <td><?= $product['product_desc'] ;?></td>
                        <td>
                            <button 
                            class='btn btn-primary btn-sm'
                            data-id='<?= $product['id'] ;?>'
                            data-product_name='<?= $product['product_name'] ;?>'
                            data-category_id='<?= $product['category_id'] ;?>'
                            data-product_desc='<?= $product['product_desc'] ;?>'
                            >
                                Edit
                            </button>
                            <button class='btn btn-danger btn-sm btn-delete' data-id='<?= $product['id'] ;?>'>
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    <?= $this->endSection() ?>