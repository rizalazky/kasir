<?= $this->extend('admin/layouts/layout') ?>
    <?= $this->section('content') ?>

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
                            class='btn btn-primary btn-sm'
                            data-id='<?= $category['id'] ;?>'
                            data-category_name='<?= $category['category_name'] ;?>'
                            >
                                Edit
                            </button>
                            <button class='btn btn-danger btn-sm btn-delete' data-id='<?= $category['id'] ;?>'>
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