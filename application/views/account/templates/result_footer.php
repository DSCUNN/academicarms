<!-- BEGIN: Footer-->
                <footer class="page-footer flexbox">
                    <div class="text-muted"><?php echo $general_settings->row()->footer_text;?></div>
                </footer><!-- END: Footer-->
            </div><!-- END: Content-->
        </div>
    </div>
    <!-- BEGIN: Page backdrops-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div><!-- END: Page backdrops-->
    <!-- CORE PLUGINS-->
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/metismenu/dist/metisMenu.min.js"></script>
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script><!-- PAGE LEVEL PLUGINS-->
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/DataTables/datatables.min.js"></script><!-- CORE SCRIPTS-->
    <script src="<?php echo base_url();?>/assets/dashboard/assets/js/app.min.js"></script><!-- PAGE LEVEL SCRIPTS-->
    <script>
        $(function() {
            var table = $('#dt-filter').DataTable({
                responsive: true,
                "sDom": 'rtip',
                columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
            });
            $('#key-search').on('keyup', function() {
                table.search(this.value).draw();
            });
            $('#type-filter').on('change', function() {
                table.column(3).search($(this).val()).draw();
            });
        });
    </script>
    <script type="text/javascript">
        $('#addschooltype').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('value') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('Add Results')
            $('select[name="class"]').on('change', function() {            	
            $('.form').empty();
            var parentID = $(this).val();
            if(parentID) {
                $.ajax({
                    url: '<?php echo base_url();?>account/results/get_class_subject/'+parentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            var namefield='<div class="col-sm-12 form-group mb-4"><label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">'+value.Subject_name+'<span class="required" style="color: red;">*</span></label><input class="form-control" type="text" placeholder="number of pin to generate" name="name[]" value="'+value.Subject_id+'"  style="display:none;"></div>';
                            var examfield='<div class="col-sm-12 form-group mb-4"><input class="form-control" type="text" placeholder="Exam Score" name="examscore[]"></div>';
                            var testfield='<div class="col-sm-12 form-group mb-4"><input class="form-control" type="text" placeholder="Test Score" name="testscore[]"></div>';
                            $('.form').append(namefield);
                            $('.form').append(examfield);
                            $('.form').append(testfield);
                        });
                    }
                });
                $.ajax({
                    url: '<?php echo base_url();?>account/results/get_class_students/'+parentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="student"]').empty();
                        $('select[name="student"]').prepend('<option value=""> Select Students</option>');
                        $.each(data, function(key, value) {
                            $('select[name="student"]').append('<option value="'+ value.Student_id +'">'+ value.Name +'</option>');
                        });
                    }
                });
            }else{
                $('.form').empty();
            }
	            
        });
        })
    </script>
    <script type="text/javascript">
        $('#edit_schooltype').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('value') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('Edit Record')
            if(recipient) 
            {
                $.ajax(
                {
                    url: '<?php echo base_url();?>account/results/get_result_id/'+recipient,
                    type: "GET",
                    dataType: "json",
                    success:function(data) 
                    {
                        //$('select[name="products"]').empty();
                        //$('select[name="products"]').append('<option value=" ">Select Product</option>');
                        $.each(data, function(key, value) {
                            stat=value.Status;
                            $('input[name="name"]').val(value.Subject_name);
                            $('input[name="exam"]').val(value.Exam_score);
                            $('input[name="test"]').val(value.Test_score);
                            $('input[name="id"]').val(value.Result_id);
                        });
                    }
                });
            }
            else
            {
                $('select[name="teacher_id"]').empty();
            }
        })
    </script>
    <script type="text/javascript">
        $('#delete_schooltype').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('value') // Extract info from data-* attributes
            var methname = button.data('session') // Extract info from data-* attributes
            var meth = button.data('term') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('Delete')
            $('input[name="id"]').val(recipient);
            $('input[name="term"]').val(meth);
            $('input[name="session"]').val(methname);
        })
    </script>
<script type="text/javascript">
  $(document).ready(function() {
    var namefield='<div class="col-sm-12 form-group mb-4"><input class="form-control" type="text" placeholder="Class Name" name="name[]"></div>';
    $('#add_column').on('click', function() {
      //$('select[name="products"]').append('<option value=" ">Select Product</option>');
      $('#form').append(namefield);
    });
  });
</script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/toastr/build/toastr.min.js"></script><!-- CORE SCRIPTS-->
    <?php if ($this->session->flashdata('message_success') != null) { 
        $mess=$this->session->flashdata('message_success');
    ?>
    <script type="text/javascript">
        $(function(){
            toastr["success"]("<?php echo ($mess);?>", "Success")
            toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
        });
    </script>
    <?php }?>
    <?php if ($this->session->flashdata('message_error') != null) { 
        $mess=$this->session->flashdata('message_error');
    ?>
    <script type="text/javascript">
        $(function(){
            toastr["error"]("<?php echo ($mess);?>", "Error")
            toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
        });
    </script>
    <?php }?>
</body>
</html>