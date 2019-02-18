<?php

require_once("../actions/var_flush.php");
if(!session_id()) {
        session_start();
}

if(!(isset($_SESSION['name']))){
    header('Location:'.$url_actual.'index');
}else{	
	$name = base64_decode($_SESSION['name']);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en"  xml:lang="en">

<head>
    
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Colorlib">
    <meta name="description" content="#">
    <meta name="keywords" content="#">
	<title>Admin London Tour</title>
	<link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">	
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">  
	<link rel="stylesheet" type="text/css" href="css/bootstrap-table.min.css">
    
    
</head>

<body oncontextmenu="return false" onkeydown="return false">

<?php
   include_once('header.php');
?>


    <section class="content-users">        
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4>Reserve of users</h4>                    
                </div>
                
                <div class="col-md-12 tableUser">
                    <small class="form-text text-muted">Click on the number of tickets to see their detail</small>
                    <div class="table-responsive tableUserUp">
                        <table class="table table-hover table-striped table-bordered tablePublic" data-toggle="tabUser" data-search="true" data-show-refresh="true" data-pagination="true" data-page-size="5" data-page-list="[10, 25, 50, 100, ALL]" id="tabUser">
                        
                      </table>
                    </div>

                </div>
            </div>            
        </div>
    </section>		


    <div id="popover_html" style="display:none;">
      <h3 class="popover-header text-center">Tickets Details</h3>
      <div class="row content-popover">p_name</div>
    </div>
	
  
<?php
   include_once('footer.php');
?>

<script src="../js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<script src="js/bootstrap-table.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(".nav-reser").addClass('active');


    $(document).ready(function(){  
    $('#tabUser').bootstrapTable({
      url: 'actions/getReserveUser.php',
      columns: [{
          field: 'name',
          title: 'Name'          
      }, {
          field: 'email',
          title: 'Email',
          width: '15%'
      },{
          field: 'phone',
          title: 'Phone',
          width: '20%'
      }, {
          field: 'name_tour',
          title: 'Tour',
          width: '20%'          
      },{
          field: 'date_tour',
          title: 'Date to tour',
          valign: 'middle',
          align : 'center'        
      },{
          field: 'date_reser',
          title: 'Date to reserve',
          valign: 'middle',
          align : 'center'        
      },{
          field: 'shedule',
          title: 'Shedule Assign',
          valign: 'middle',
          align : 'center'         
      },{
          field: 'cant_tikets',
          title: 'Number of tickets',
          valign: 'middle',
          align : 'center'         
      },{
          field: 'price',
          title: 'Price total',
          align: 'center',
          valign: 'middle',
          width: '10%'          
      },]
    });

  });

  $("body").on("mouseenter","table",function(event){
   
    $('.hover').popover({
      title: popoverContent,
      html: true,
      placement: 'right'     
    });


  });

  

  function popoverContent() {
    
    var content = '';
    var element = $(this);
    console.log(element.attr("id"));
    var id = element.attr("id");
      $.ajax({
        url: "actions/load_data_popover.php",
        method: "POST",
        async: false,
        data:{ id : id },
        success:function(data){
          console.log(data);
          content = $("#popover_html").html();
          content = content.replace(/p_name/g, data);  
        }
      });
    return content;
  }

</script>
<?php if(isset($_SESSION['name']) && !empty($_SESSION['name'])): ?>
  <script>
        function comfirtClose() {
          var cerrar = setTimeout(closeSesion,5000);
        }
        function closeSesion(){
            alert('For security reasons, your session will be closed. We invite you to log in again.');
            location.href = '../actions/close_sesion.php';
        }
        var temp = setTimeout(comfirtClose, 180000);//3min

        $(document).on('click keyup keypress keydown blur change', function(e) {
            clearTimeout(temp);
            temp = setTimeout(comfirtClose,180000);
            
        });
  </script>
<?php endif; ?>
</body>

</html>