<?= $this->include('admin/layouts/head') ?>
    
  
        
    <?= $this->include('admin/layouts/sidebar') ?>
    <?= $this->include('admin/layouts/navbar') ?>
    
    <div id="content">
        <div class="container my-5">
            <h2 class="h2"><?= $pageTitle ?></h2>
            
            <?= $this->renderSection('content') ?>
    
            <?= $pager->links('default','custom_pager') ?>
            
        </div>
    </div>
    


<?= $this->include('admin/layouts/foot') ?>
   
    

    