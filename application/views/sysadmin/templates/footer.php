<!-- BEGIN: Footer-->
                <footer class="page-footer flexbox">
                    <div class="text-muted"><?php echo $general_settings->row()->footer_text;?></div>
                </footer><!-- END: Footer-->
            </div><!-- END: Content-->
        </div>
    </div><!-- BEGIN: Search form-->
    <div class="modal fade" id="search-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document" style="margin-top: 100px">
            <div class="modal-content">
                <form class="search-top-bar" action="#"><input class="form-control search-input" type="text" placeholder="Search..."><button class="reset input-search-icon" type="submit"><i class="ft-search"></i></button><button class="reset input-search-close" type="button" data-dismiss="modal"><i class="ft-x"></i></button></form>
            </div>
        </div>
    </div><!-- END: Search form-->
    <!-- BEGIN: Quick sidebar-->

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
            var MONTHS_SH = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var DAYS_S = ["S", "M", "T", "W", "T", "F", "S"];
            var DAYS = ["Sunday", "Munday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            var color = Chart.helpers.color;
            (function() {
                var dr = $('#subheader_daterange');
                if (dr.length) {
                    var t = moment();
                    var a = moment();
                    dr.daterangepicker({
                            startDate: t,
                            endDate: a,
                            ranges: {
                                'Today': [moment(), moment()],
                                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                            },
                        }, f),
                        f(t, a, "");
                }

                function f(t, a, r) {
                    var o = "",
                        n = "";
                    a - t < 100 || "Today" == r ?
                        (o = "Today:", n = t.format("MMM D")) :
                        "Yesterday" == r ? (o = "Yesterday:", n = t.format("MMM D")) :
                        n = t.format("MMM D") + " - " + a.format("MMM D"), dr.find(".subheader-daterange-date").html(n), dr.find(".subheader-daterange-title").html(o)
                }
            })();
            $('.easypie').each(function() {
                $(this).easyPieChart({
                    trackColor: $(this).attr('data-trackColor') || '#f2f2f2',
                    scaleColor: false,
                });
            });
            if ($('#line_chart_1').length) {
                var ctx = document.getElementById("line_chart_1").getContext("2d");
                new Chart(ctx, {
                    type: 'line',
                    showScale: false,
                    data: {
                        labels: MONTHS_SH,
                        datasets: [{
                            label: 'Dataset 1',
                            data: [60, 30, 80, 45, 90, 62, 85, 35, 75, 45, 90, 35],
                            data: [10, 30, 20, 40, 30, 50, 40, 60, 50, 70, 60, 80],
                            backgroundColor: color(theme_color('primary')).alpha(0.4).rgbString(),
                            borderColor: theme_color('primary'),
                            fill: false,
                            pointRadius: 5,
                            pointHitRadius: 30,
                            pointHoverBorderWidth: 2,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#fff',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                    max: 60,
                                },
                            }],
                            yAxes: [{
                                gridLines: {
                                    drawBorder: false,
                                },
                                ticks: {
                                    beginAtZero: true,
                                }
                            }]
                        },
                        legend: {
                            labels: {
                                boxWidth: 12
                            }
                        },
                    }
                });
            }
            if ($('#horizonal_bars').length) {
                var ctx = document.getElementById("horizonal_bars").getContext("2d");
                new Chart(ctx, {
                    type: 'horizontalBar',
                    data: {
                        labels: ['PayPal', 'Visa', 'Mastercard', 'Eps', 'JCB', 'Others'],
                        datasets: [{
                            label: 'Dataset 1',
                            backgroundColor: theme_color('info'),
                            //borderColor: theme_color('info'),
                            //borderWidth: 1,
                            data: [80, 70, 60, 50, 40, 30, 20],
                        }]
                    },
                    options: {
                        showScale: false,
                        elementxs: {
                            rectangle: {
                                borderWidth: 2,
                            }
                        },
                        scales: {
                            xAxes: [{
                                gridLine: {
                                    display: false,
                                },
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: false,
                                    drawBorderx: false,
                                },
                                barPercentage: 0.7,
                            }]
                        },
                        responsive: true,
                    }
                });
            }
            if ($('#pie_chart_1').length) {
                var ctx = document.getElementById("pie_chart_1").getContext("2d");
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['In-Store Sales', 'Online Sales'],
                        datasets: [{
                            data: [80, 20],
                            backgroundColor: [
                                theme_color('primary'),
                                theme_color('info'),
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: false
                        },
                        cutoutPercentage: 65,
                    }
                });
            }
            if ($('#bar_chart_sm').length) {
                var ctx = document.getElementById("bar_chart_sm").getContext("2d");
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: DAYS,
                        datasets: [{
                            backgroundColor: theme_color("primary"),
                            data: [45, 80, 58, 74, 54, 59, 40]
                        }, {
                            backgroundColor: theme_color('light'),
                            data: [29, 48, 40, 19, 78, 31, 85]
                        }]
                    },
                    options: {
                        title: {
                            display: !1
                        },
                        legend: {
                            display: !1
                        },
                        responsive: !0,
                        maintainAspectRatio: !1,
                        scales: {
                            xAxes: [{
                                display: !1,
                                gridLines: !1,
                            }],
                            yAxes: [{
                                display: !1,
                                gridLines: !1
                            }]
                        },
                        layout: {
                            padding: 0
                        }
                    }
                });
            }
            if ($('#world_map').length) {
                var markers = [{
                        latLng: [55.524010, 105.318756],
                        name: 'Russia',
                        visits: 1000
                    },
                    {
                        latLng: [60.128161, 18.643501],
                        name: 'Sweden',
                        visits: 1000
                    },
                    {
                        latLng: [35.861660, 104.195397],
                        name: 'China',
                        visits: 1000
                    },
                    {
                        latLng: [37.090240, -95.712891],
                        name: 'USA(Neda Shine)',
                        visits: 1000
                    },
                    {
                        latLng: [52.130366, -92.346771],
                        name: 'Canada',
                        visits: 1000
                    },
                    {
                        latLng: [-25.274398, 133.775136],
                        name: 'Austrlia(Neda Shine)',
                        visits: 1000
                    },
                    {
                        latLng: [51.165691, 10.451526],
                        name: 'Germany',
                        visits: 1000
                    },
                    {
                        latLng: [26.02, 50.55],
                        name: 'Bahrain',
                        visits: 1000
                    },
                    {
                        latLng: [-3, -61.38],
                        name: 'Brazil',
                        visits: 1000
                    },
                ];
                $('#world_map').vectorMap({
                    map: 'world_mill_en',
                    backgroundColor: 'transparent',
                    scale: 5,
                    focusOn: {
                        scale: 1,
                        x: 0.5,
                        y: 0.5,
                    },
                    regionStyle: {
                        initial: {
                            fill: '#DADDE0',
                        }
                    },
                    markers: markers,
                    markerStyle: {
                        initial: {
                            fill: theme_color('primary'), // '#ff4081',
                            stroke: '#b9d0ff', // '#ffc6d9',
                            "stroke-width": 5,
                            r: 8
                        },
                        hover: {
                            fill: theme_color('primary'),
                            stroke: '#b9d0ff',
                        }
                    },
                    onMarkerTipShow: function(e, label, index) {
                        label.html('' + markers[index].name + ' (Visits - ' + markers[index].visits);
                    },
                });
            }
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
                table.search($(this).val()).draw();
            });
        });
    </script>
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/toastr/build/toastr.min.js"></script><!-- CORE SCRIPTS-->
    <script src="<?php echo base_url();?>assets/dashboard/vendors/sweetalert2/dist/sweetalert2.all.min.js"></script><!-- CORE SCRIPTS-->
    <script src="<?php echo base_url();?>assets/dashboard/assets/js/scripts/sweetalert-demo.js"></script>
    <?php if ($this->session->flashdata('message_success') != null) { 
        $mess=$this->session->flashdata('message_success');
    ?>
        <script type="text/javascript">
            $(function(){
                swal("SUCCESS", "<?php echo $mess;?>", "success");
            });
        </script>
    <?php } ?>
    <?php if ($this->session->flashdata('message_error') != null) {
        $mess=$this->session->flashdata('message_error');
    ?>
        <script type="text/javascript">
            $(function(){
                swal("Error", "<?php echo $mess;?>", "error");
            });
        </script>
    <?php } ?>
    <script type="text/javascript">
        $('#edit_faq_category').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('value') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('Edit Category')
            if(recipient) 
            {
                $.ajax(
                {
                    url: '<?php echo base_url();?>sysadmin/faq_category/get_faq_category_id/'+recipient,
                    type: "GET",
                    dataType: "json",
                    success:function(data) 
                    {
                        //$('select[name="products"]').empty();
                        //$('select[name="products"]').append('<option value=" ">Select Product</option>');
                        $.each(data, function(key, value) {
                            $('input[name="name"]').val(value.Name);
                            $('input[name="id"]').val(value.Category_id);
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
        $('#edit_plan').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('value') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('Edit Plan')
            if(recipient) 
            {
                $.ajax(
                {
                    url: '<?php echo base_url();?>sysadmin/pricing/get_pricing_plan_id/'+recipient,
                    type: "GET",
                    dataType: "json",
                    success:function(data) 
                    {
                        //$('select[name="products"]').empty();
                        //$('select[name="products"]').append('<option value=" ">Select Product</option>');
                        $.each(data, function(key, value) {
                            $('input[name="name"]').val(value.PackageName);
                            $('textarea[name="description"]').val(value.Description);
                            $('textarea[name="features"]').val(value.Features);
                            $('input[name="id"]').val(value.Package_id);
                            $('input[name="old_price"]').val(value.Old_price);
                            $('input[name="new_price"]').val(value.New_price);
                            $('input[name="number_of_school"]').val(value.Number_of_schools);
                            $('input[name="recommend_text"]').val(value.Recommend_text);
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
        $('#edit_method').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('value') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('Edit Payment Method')
            if(recipient) 
            {
                $.ajax(
                {
                    url: '<?php echo base_url();?>sysadmin/payment_methods/get_payment_method_id/'+recipient,
                    type: "GET",
                    dataType: "json",
                    success:function(data) 
                    {
                        //$('select[name="products"]').empty();
                        //$('select[name="products"]').append('<option value=" ">Select Product</option>');
                        $.each(data, function(key, value) {
                            $('input[name="name"]').val(value.MethodName);
                            $('input[name="private_key"]').val(value.Private_key);
                            $('input[name="public_key"]').val(value.Public_key);
                            $('input[name="merchant_id"]').val(value.Merchant_id);
                             $('input[name="url"]').val(value.Web_Hook);
                            $('input[name="id"]').val(value.MethodId);
                        });
                    }
                });
            }
            else
            {
                $('#edit_method').hide();
            }
        })
    </script>
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/summernote/dist/summernote-bs4.min.js"></script><!-- CORE SCRIPTS-->
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
            $('#summernote1').summernote();
            $('#summernote-air').summernote({
                airMode: true
            });
        });
    </script>
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/dropzone/dist/min/dropzone.min.js"></script><!-- CORE SCRIPTS-->
</body>
</html>