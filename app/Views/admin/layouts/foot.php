    <script>
        var baseUrl = "<?php echo base_url()?>";
    </script>
    <script src="<?= base_url('js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="<?= base_url('js/select2.full.js') ?>"></script> -->
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
    <script>
        let productDescEditor;
        ClassicEditor
            .create(document.querySelector('#product_desc'))
            .then( editor => {
                console.log( editor );
                productDescEditor = editor;
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
    <script src="<?= base_url('js/myscript.js')?>"></script>

</body>
</html>