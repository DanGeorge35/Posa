
    <!-- Core scripts -->
    <script src="template/assets/js/pace.js"></script>
    <script src="template/assets/js/jquery-3.3.1.min.js"></script>
    <script src="template/assets/libs/popper/popper.js"></script>
    <script src="template/assets/js/bootstrap.js"></script>
    <script src="template/assets/js/sidenav.js"></script>
    <script src="template/assets/js/layout-helpers.js"></script>
    <script src="template/assets/js/material-ripple.js"></script>

    <!-- Libs -->
    <script src="template/assets/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="template/assets/libs/eve/eve.js"></script>
    <script src="template/assets/libs/raphael/raphael.js"></script>  
    <script src="template/assets/libs/morris/morris.js"></script>    
    <script src="template/assets/js/pages/ui_navs.js"></script>



     <script src="template/assets/libs/datatables/datatables.js"></script>

    <!-- Demo -->
    <script src="template/assets/js/pages/tables_datatables.js"></script>


    <script src="template/assets/libs/markdown/markdown.js"></script>
    <script src="template/assets/libs/bootstrap-markdown/bootstrap-markdown.js"></script>


 
    <!-- Demo -->
    <script src="template/assets/js/demo.js"></script>
    <script src="template/assets/js/analytics.js"></script>

   


<div class="modal fade pr-0" id="are_you_sure" tabindex="-1" role="dialog" aria-labelledby="are_you_sure" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body w3-text-black w3-padding-64" id='are_you_sure_content'>  
    
      </div>
       
    </div>
  </div>
</div>


<script type="text/javascript">
   function are_you_sure(fun,par1,par2) {
        // body...
        document.getElementById('are_you_sure_content').innerHTML ="\
    <div class='w3-large text-center pb-4'>\
        Are you Sure?\
      </div>\
    <div class='row'>\
        <div class='col-4 offset-2'>\
            <button class='btn btn-success btn-block' onclick='"+fun+"(\""+par1+"\");$(\"#are_you_sure\").modal(\"hide\");'> Yes</button>\
        </div>\
        <div class='col-4'>\
             <button class='btn btn-danger btn-block' data-dismiss='modal' aria-label='Close'> No</button>\
        </div>\
    </div>\
        ";
        $('#are_you_sure').modal('show');
    }

    function are_you_sure2(fun,par1,par2) {
        // body...
        document.getElementById('are_you_sure_content').innerHTML ="\
    <div class='w3-large text-center pb-4'>\
        Are you Sure?\
      </div>\
    <div class='row'>\
        <div class='col-4 offset-2'>\
            <button class='btn btn-success btn-block' onclick='"+fun+"(\""+par1+"\",\""+par2+"\");$(\"#are_you_sure\").modal(\"hide\");'> Yes</button>\
        </div>\
        <div class='col-4'>\
             <button class='btn btn-danger btn-block' data-dismiss='modal' aria-label='Close'> No</button>\
        </div>\
    </div>\
        ";
        $('#are_you_sure').modal('show');
    }


    function are_you_sure3(fun,par1,par2,par3) {
        // body...
        document.getElementById('are_you_sure_content').innerHTML ="\
    <div class='w3-large text-center pb-4'>\
        Are you Sure?\
      </div>\
    <div class='row'>\
        <div class='col-4 offset-2'>\
            <button class='btn btn-success btn-block' onclick='"+fun+"(\""+par1+"\",\""+par2+"\",\""+par3+"\");$(\"#are_you_sure\").modal(\"hide\");'> Yes</button>\
        </div>\
        <div class='col-4'>\
             <button class='btn btn-danger btn-block' data-dismiss='modal' aria-label='Close'> No</button>\
        </div>\
    </div>\
        ";
        $('#are_you_sure').modal('show');
    }
    



$(document).ready(function() {
     // $('#<?php echo $pageTitle; ?>').scrollIntoView();
     document.getElementById('<?php echo $pageTitle; ?>').scrollIntoView();

});
    
</script>

<script type="text/javascript">

    'use strict';
$(document).ready(function() {
    buildchart()
    $(window).on('resize', function() {
        buildchart();
    });
    $('#mobile-collapse').on('click', function() {
        setTimeout(function() {
            buildchart();
        }, 700);
    });
    Morris.Bar({
        element: 'chart-bar-moris',
        data: [
        
        <?php 
                    $base = strtotime(date('Y-m',time()) . '-01 00:00:01');
                      for ($i=0; $i <= 6 ; $i++) {
                        $dmonth = $i;
                        $month =  date('M', strtotime("$dmonth month",$base));
                        $year =  date('Y', strtotime("$dmonth month",$base));
                        $target= $year."-". date('m', strtotime("$dmonth month",$base))."-";                     
                     
                              echo "
                                       {   
                                            y: '$month $year',";


                                 echo"      a:  6,";
                                           // 

                               echo "       },
                              ";

                            
                      }
        ?>

           
           
          
        ],
        xkey: 'y',
        barSizeRatio: 0.50,
        barGap: 3,
        resize: true,
        responsive: true,
        ykeys: ['a'],
        labels: ['Slot Sold' ],
        barColors: ['#62d493 ']
    });
});

function buildchart() {
    $(function() {
        //Flot Base Build Option for bottom join
        var options_bt = {
            legend: {
                show: false
            },
            series: {
                label: "",
                shadowSize: 0,
                curvedLines: {
                    active: true,
                    nrSplinePoints: 20
                },
            },
            tooltip: {
                show: true,
                content: "x : %x | y : %y"
            },
            grid: {
                hoverable: true,
                borderWidth: 0,
                labelMargin: 0,
                axisMargin: 0,
                minBorderMargin: 0,
                margin: {
                    top: 5,
                    left: 0,
                    bottom: 0,
                    right: 0,
                }
            },
            yaxis: {
                min: 0,
                max: 30,
                color: 'transparent',
                font: {
                    size: 0,
                }
            },
            xaxis: {
                color: 'transparent',
                font: {
                    size: 0,
                }
            }
        };

        //Flot Base Build Option for Center card
        var options_ct = {
            legend: {
                show: false
            },
            series: {
                label: "",
                shadowSize: 0,
                curvedLines: {
                    active: true,
                    nrSplinePoints: 20
                },
            },
            tooltip: {
                show: true,
                content: "x : %x | y : %y"
            },
            grid: {
                hoverable: true,
                borderWidth: 0,
                labelMargin: 0,
                axisMargin: 0,
                minBorderMargin: 5,
                margin: {
                    top: 8,
                    left: 8,
                    bottom: 8,
                    right: 8,
                }
            },
            yaxis: {
                min: 0,
                max: 30,
                color: 'transparent',
                font: {
                    size: 0,
                }
            },
            xaxis: {
                color: 'transparent',
                font: {
                    size: 0,
                }
            }
        };

    });
}

    function get_state(val) {
       // start_load();
        state = document.getElementById('local_state').value;
        var val = val.substr(0, val.indexOf("~"));
        data = 'get_states=1&dCountry_id='+val;
        var thestates = new  $.ajax({
                                    
                            type: 'POST',
                            data: data,
                            error: function (xhr, ajaxOptions, thrownError) {
                                stop_load(); 
                                $("#error").html('Internet Error');
                            },
                            success: function(result){
                                if(result.res =='200'){
                                    $("#local_state").html(result.note);
                                    select_value(document.getElementById("local_state"),state);
                                    
                                    if(document.getElementById("coordinate")){
                                        search_coordinate();
                                    }                                     
                                }
                                
                              stop_load();
                              return false;

                            }
                    });
           return false;
         
    }

</script>


       

    </body>

<!-- Mirrored from themesdesign.in/zinzer_1/vertical-dark/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 May 2019 11:23:28 GMT -->
</html>