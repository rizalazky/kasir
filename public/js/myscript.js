$(document).ready(function(){
    const elementTypeDecimal=document.getElementsByClassName('decimal-input')

    
    // function formatNumber(number,format){
    //     return numeral(number).format(format);
    // }

    function formatNumber(angka,prefix){
        // angka=angka.replace('.',',');
        

        var number_string = angka.replace(/[^.\d]/g, '').toString(),
        split   		= number_string.split('.'),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? ',' : '';
            rupiah += separator + ribuan.join(',');
        }

        rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ?  rupiah : '');
    }

    function initDecimalInput(){
        for (let index = 0; index < elementTypeDecimal.length; index++) {
            const elm = elementTypeDecimal[index];
            var val=elm.value ? elm.value : elm.innerText;
            console.log(elm)
            if(val){
                var format=formatNumber(val);
                try {
                    // type input
                    elm.value=format
                } catch (error) {
                    // !type input
                    elm.innerText=format
                    
                }
            }
        }
    }

    if(elementTypeDecimal.length > 0){
        initDecimalInput()
    }

    $('.decimal-input').on('keyup',function(e){
        var string = formatNumber($(this).val());
        $(this).val(string);
    });

    // reset form input when modal closed
    $('#exampleModal').on('hidden.bs.modal',function(){
        console.log("Hide Modal")
        $("#category_id option:selected").prop("selected", false)
        let inputElement = document.getElementsByTagName('input');

       
        for (let index = 0; index < inputElement.length; index++) {
            const inp = inputElement[index];
            inp.value = '';
        }
        productDescEditor.setData("")
        $('#previewImg').attr('src','');
        $('#myprogress').addClass('d-none');
    });

    function previewImageDisplay(){
        let src=$('#previewImg').attr('src');

        
        if(src){
            console.log('Masuk')
            $('#previewImg').removeClass('d-none');
        }else{
            console.log('Masuk Else')
            $('#previewImg').addClass('d-none');
        }
    }

    $('#exampleModal').on('shown.bs.modal',function(){
        previewImageDisplay();
    })


    function previewImage(){
        var file = $("#product_image").get(0).files[0];
        
        if(file){
            var reader = new FileReader();

            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
                previewImageDisplay();
            }

            reader.readAsDataURL(file);
        }
    }

    $('#product_image').change(function(e){
        previewImage();
    })
    

    // $('.select-2').select2({
    //     matcher: matchCustom
    // });


    function saveProduct(url,data){
        $("#myprogress").removeClass('d-none');
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
        let product_desc = productDescEditor.getData() || $('#product_desc').val();
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
        productDescEditor.setData(product_desc);
        
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