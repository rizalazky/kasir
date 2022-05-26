<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Majoo Teknologi Indonesia</title>
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />

    <!-- <link href="<?= base_url('css/select2.css') ?>" rel="stylesheet" /> -->
    

</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Majoo Teknologi Indonesia</span>
    </div>
    </nav>
    <div class="container">
        <h2 class="h2">Products</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Product
        </button>
        <table class="table">
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
        <?= $pager->links('default','custom_pager') ?>
        
    </div>

   
       

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="product_name" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" id="category_id" class="select-2 form-select">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                    <textarea class="form-control" id="product_desc" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Price</label>
                    <input type="text" class="form-control" id="product_price" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Image</label>
                    <input type="file" class="form-control" id="product_image" placeholder="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="<?= base_url('js/select2.full.js') ?>"></script> -->
    <script>
        $(document).ready(function(){
            
            function matchStart(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Skip if there is no 'children' property
                if (typeof data.children === 'undefined') {
                    return null;
                }

                // `data.children` contains the actual options that we are matching against
                var filteredChildren = [];
                $.each(data.children, function (idx, child) {
                    if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                    filteredChildren.push(child);
                    }
                });

                // If we matched any of the timezone group's children, then set the matched children on the group
                // and return the group object
                if (filteredChildren.length) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.children = filteredChildren;

                    // You can return modified objects from here
                    // This includes matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }

            // $('.select-2').select2({
            //     matcher: matchStart
            // });
            

            

            function postData(url,data){
                $.ajax({
                    type: "POST",
                    url:url,
                    data: data,
                    dataType: 'json'
                }).then((response)=>{
                    if(response.status){
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Cool'
                        });
                    }else{
                        let msg ='';
                        for (const key in response.data) {
                            msg = msg + `${response.data[key]}<br/>`;
                        }
                        Swal.fire({
                            title: 'Error!',
                            html: msg,
                            icon: 'error',
                            confirmButtonText: 'Cool'
                        });
                    }
                }).catch(err=>{
                   console.log(err)
                })
            }

            function deleteData(url){
                $.ajax({
                    type: "DELETE",
                    url:url
                }).then((response)=>{
                    if(response.status){
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                }).catch(err=>{
                   console.log(err)
                })
            }

            function addData(){
                let product_name = $('#product_name').val();
                let category_id = $('#category_id').val();
                let product_price = $('#product_price').val();
                let product_desc = $('#product_desc').val();
                let product_image = $('#product_image').val();
                let data = {
                    product_name,
                    category_id,
                    product_price,
                    product_desc,
                    product_image
                }
                let url =  "<?php echo base_url('admin/product') ?>";
               
                postData(url,data);
                
                
            }

            $('#btn-save').click(async function(){
                addData();
            });

            
            $('.btn-delete').click(function(){

                let id = $(this).data('id')
                console.log(id);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url =  "<?php echo base_url('admin/product/') ?>/"+id;
                        deleteData(url)
                    }
                })

            })

            

        })
    </script>
</body>
</html>