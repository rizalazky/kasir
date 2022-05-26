$(document).ready(function(){
    


    function previewImage(input){
        var file = $("#product_image").get(0).files[0];

        if(file){
            var reader = new FileReader();

            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }

            reader.readAsDataURL(file);
        }
    }

    $('#product_image').change(function(e){
       
        previewImage($(this));
    })
    
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
                }).then(()=>{
                    window.location.reload();
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
            type: "GET",
            url:url,
            dataType: 'json'
        }).then((response)=>{
            console.log(response)
            if(response.status){
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                ).then(()=>{
                    window.location.reload();
                })
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
                let url =  "<?php echo base_url('admin/product/delete') ?>/"+id;
                deleteData(url)
                
            }
        })

    })

    

})