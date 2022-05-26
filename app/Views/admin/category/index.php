    <?= $this->extend('admin/layouts/layout') ?>
    <?= $this->section('content') ?>

        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Categories
        </button>

        <?= $this->include('admin/category/modal') ?>
        <table class="table table-responsive">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Category Name</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($categories as $category){
                ?>
                    <tr>
                        <td><?= $category['id'] ;?></td>
                        <td><?= $category['category_name'] ;?></td>
                        <td>
                            <button 
                            class='btn btn-primary btn-sm btn-edit-category'
                            data-id='<?= $category['id'] ;?>'
                            data-category_name='<?= $category['category_name'] ;?>'
                            data-bs-toggle="modal" data-bs-target="#exampleModal"
                            >
                                Edit
                            </button>
                            <button class='btn btn-danger btn-sm btn-delete-category' data-id='<?= $category['id'] ;?>'>
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