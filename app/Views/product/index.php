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
    <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-2 h1">Majoo Teknologi Indonesia</span>
    </div>
    </nav>
    <div class="container-fluid">
        <h2 class="h2">Products</h2>
        <div class="d-flex flex-wrap justify-content-center">
            <div class="card m-2" style="width: 18rem;">
                <img src="<?php echo base_url('/img/products/paket-advance.png')?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Majoo Advance</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card m-2" style="width: 18rem;">
                <img src="<?php echo base_url('/img/products/paket-desktop.png')?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Majoo Desktop</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card m-2" style="width: 18rem;">
                <img src="<?php echo base_url('/img/products/paket-lifestyle.png')?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Mojoo Lifestyle</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card m-2" style="width: 18rem;">
                <img src="<?php echo base_url('/img/products/standard_repo.png')?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Majoo Pro</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            
        </div>
    </div>

    <script src="<?= base_url('js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
    <script>
        $(document).ready(function(){

            function initPage(response){
                let li ='';
                let checkedList=0;
                response.map((list)=>{
                    if(list.status == '1'){
                        checkedList++;
                    }
                    li +=`
                    <li class="list-group-item list-group-flush d-flex align-items-center">
                        <input class="form-check-input me-1" data-id="${list.id}" type="checkbox" ${list.status == '1' && 'checked' } aria-label="...">
                        <div class="input-group ml-3">
                            <span type="text" class="form-control border-0" aria-label="What needs to be done?" aria-describedby="button-addon2">${list.list}</span>
                            <button class="btn delete btn-sm" data-id="${list.id}" type="button" id="button-addon2"><i class="bi delete bi-trash" data-id="${list.id}"></i></button>
                        </div>
                    </li>
                    `;
                });

                if(response.length > 0){
                    $('#btn-check-all').removeAttr('disabled');
                }else{
                    $('#btn-check-all').attr('disabled','disabled');
                }

                if(checkedList > 0){
                    $('#btn-delete-all').removeAttr('disabled');
                   
                }else{
                    $('#btn-delete-all').attr('disabled','disabled');
                    
                }

                if(checkedList == response.length){
                    
                    $('#btn-check-all').text('Unchecked All List');
                    
                }else{
                    $('#btn-check-all').text('Cheked All List');
                    

                }

                $('#list').html(li);
            }

            function fetchData(){
                // $('#list').html();
                // $.ajax({
                //     type: "GET",
                //     url: "<?php echo base_url('/get_list') ?>",
                //     dataType: 'json'
                // }).then((response)=>{
                //     console.log(response)
                //     initPage(response)
                // }).catch(err=>{
                //     console.log(err)
                // })
            }

            function postData(url,data){
                $.ajax({
                    type: "POST",
                    url:url,
                    data: data,
                    dataType: 'json'
                }).then((response)=>{
                    console.log(response)
                    fetchData()
                }).catch(err=>{
                    console.log(err)
                })
            }

            function addData(){
                let list = $('#inp-list').val();
                if(list == '' || list == null) {
                    alert('Please Fill Out The Field');
                    return false;
                }
                let data = {
                    list
                }
                let url =  "<?php echo base_url('/add') ?>";
                postData(url,data);
                $('#inp-list').val("");
            }

            $('#add').click(async function(){
                addData();
            });

            $('#inp-list').on('keyup', function (e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    addData();
                }
            });
            
            $('#list').click(function(e){
                let classList= e.target.classList;

                console.log(classList)
                if(classList.contains('form-check-input')){
                    console.log(e.target.checked)
                    let status=e.target.checked;
                    let id = e.target.dataset.id;
                    let data = {
                        id,status
                    }
                    console.log(data)
                    let url =  "<?php echo base_url('/update') ?>";
                    postData(url,data);
                }

                if(classList.contains('delete')){
                    let conf= confirm('Are you sure want to delete this list?');
                    if(!conf) return false;
                    let id = e.target.dataset.id;
                    let data = {
                        id
                    }
                    console.log(data)
                    let url =  "<?php echo base_url('/delete') ?>";
                    postData(url,data);
                }
                
            });

            $('#btn-check-all').click(function(){
                let btnText=$('#btn-check-all').text();
                let conf= confirm(`Are you sure want ${btnText}?`);
                if(!conf) return false;
                let data = {
                    status : 1
                }
                console.log("btnText",btnText);
                if(btnText == 'Unchecked All List'){
                    data.status = 0;
                }

                let url =  "<?php echo base_url('/checkall') ?>";
                postData(url,data);
            });

            $('#btn-delete-all').click(function(){
                
                let conf= confirm('Are you sure want to delete all data?');
                if(!conf) return false;

                let url =  "<?php echo base_url('/deleteall') ?>";
                postData(url);
            });

            fetchData();
        })
    </script>
</body>
</html>