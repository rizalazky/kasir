$(document).ready(function(){
    

    // reset form input when modal closed
    $('#exampleModal').on('hidden.bs.modal',function(){
        console.log("Hide Modal")
        $('input').val();
        let inputElement = document.getElementsByTagName('input');

        console.log(inputElement);
        for (let index = 0; index < inputElement.length; index++) {
            const inp = inputElement[index];
            inp.value = '';
        }
    })


    function previewImage(){
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
        previewImage();
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

    function saveProduct(url,data){
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();         
                xhr.upload.addEventListener("progress", function(element) {
                    if (element.lengthComputable) {
                        var percentComplete = (Math.round((element.loaded / element.total)*1000) / 10);
                        $("#progress-bar").width(percentComplete + '%');
                        $("#progress-bar").html(percentComplete+'%');
                    }
                }, false);
                return xhr;
            },
            type: 'POST',
            url: url,
            data: data,
            contentType: false,
            cache: false,
            processData:false,
            dataType:'json',
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            beforeSend: function(){
                $("#progress-bar").width('0%');
            },

            success: function(response){
                console.log("RESPONSE",response);
                console.log("RES",$('#progress-bar').width());
                // return false;
                if(response.status){
                    setTimeout(()=>{
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Cool'
                        }).then(()=>{
                            window.location.reload();
                        });
                    },1500)
                    
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
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });	
            		 
        
    }
    

    

    function postData(url,data){
        $.ajax({
            type: "POST",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
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
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            url:url,
            dataType: 'json'
        }).then((response)=>{
            
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


    $('#btn-save').click(async function(){
        let id =$('#id').val();
        let product_name = $('#product_name').val();
        let category_id = $('#category_id').val();
        let product_price = $('#product_price').val();
        let product_desc = $('#product_desc').val();
        let product_image = $('#product_image')[0].files[0];
        let data = {
            product_name,
            category_id,
            product_price,
            product_desc,
            product_image
        }
        let url =  baseUrl+"/admin/product";
        let formData=new FormData();
        if(id !== '' && id !== null){
            data.id = id;
            url = url+ "/edit/"+id;
            formData.append("id",id);
        }
       
        // postData(url,data);
        
        formData.append("product_name",product_name);
        formData.append("category_id",category_id);
        formData.append("product_price",product_price);
        formData.append("product_desc",product_desc);
        formData.append("product_image",product_image);
        saveProduct(url,formData);
        
    });

    $('.btn-edit-product').click(function(){
        let id=$(this).data('id');
        let product_name=$(this).data('product_name');
        let product_price=$(this).data('product_price');
        let category_id=$(this).data('category_id');
        let product_desc=$(this).data('product_desc');
        let product_image=$(this).data('product_image');
        $('#id').val(id);
        $('#product_name').val(product_name);
        $('#product_price').val(product_price);
        $('#category_id').val(category_id);
        $('#product_desc').val(product_desc);
        
        $('#previewImg').attr('src',baseUrl+'/img/products/'+product_image)
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
                let url =  baseUrl+"/admin/product/delete/"+id;
                deleteData(url)
                
            }
        })

    })

    $('#btn-save-category').click(async function(){
        let id = $('#id').val();
        let category_name = $('#category_name').val();
        
        let url =  baseUrl+"/admin/category";
        let data = {
            category_name,  
        }

        if(id !== '' && id !== null){
            data.id = id;
            url = url+ "/edit/"+id
        }

        console.log(data)

        console.log(url)
       
        postData(url,data);
    });

    $('.btn-edit-category').click(function(){
        let id=$(this).data('id');
        let categoryName=$(this).data('category_name');
        $('#id').val(id);
        $('#category_name').val(categoryName);
    });

    $('.btn-delete-category').click(function(){

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
                let url =  baseUrl+"/admin/category/delete/"+id;
                deleteData(url)
                
            }
        })

    })

    

})