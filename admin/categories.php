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
<div class="loader"></div>
<?php
   include_once('header.php');
?>


    <section class="content-users">        
        <div class="container">
            
            <div class="row">
                <div class="col-md-12">
                    <h4>Categories of tours</h4>                    
                </div>                
                <div class="col-md-12">
                      <div class="alert alert-success alert-catg-success alert-dismissible" role="alert">
                            Category successfully updated
                      </div>
                      <div class="alert alert-success alert-catg--new alert-dismissible" role="alert">
                            Category successfully created
                      </div>
                      <div class="alert alert-warning alert-problem alert-dismissible" role="alert">
                        There was a problem. <strong>Try again later.</strong>.
                      </div>
                </div>  
                <div class="col-md-12 text-right btn-new">
                    <a id="newcatg" class="btn btn-info" data-toggle="modal" data-target="#myModalNewCatg">New category</a>
                </div>              
                <div class="col-md-12 tableCatg">
                    <div class="table-responsive tableCatgUp">
                        <table class="table table-hover table-striped table-bordered tablePublic" data-toggle="tabCatg" data-search="true" data-show-refresh="true" data-pagination="true" data-page-size="10" data-page-list="[10, 25, 50, 100, ALL]" id="tabCatg">
                        
                      </table>
                    </div>
                </div>
            </div>            
        </div>
    </section>		
	 

<!-- edit Modal name category -->
<div id="myModalEditCatg" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Category</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>        
      </div>
      <form method="post" class="col-md-12">
      <div class="modal-body">
        <div class="panel panel-default">
            <div class="alert alert-danger alert-emphy alert-dismissible" role="alert">
                Add a name to the category
            </div>           
            <div class="form-group">
              <label for="textCatg">Description of the category</label>
              <input type="text" class="form-control" id="textCatg" name="textCatg">
            </div>
            <input type="hidden" id="idval" name="idval">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="updateInfoCatg();">Update</button>        
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>


<!-- create Modal name category -->
<div id="myModalNewCatg" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Create Category</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>        
      </div>
      <form method="post" class="col-md-12">
      <div class="modal-body">
        <div class="panel panel-default">
            <div class="alert alert-danger alert-emphy alert-dismissible" role="alert">
                Add a name to the category
            </div>           
            <div class="form-group">
              <label for="textnewCatg">Description of the category</label>
              <input type="text" class="form-control" id="textnewCatg" name="textnewCatg">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="createNew();">Create</button>        
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
  
<?php
   include_once('footer.php');
?>

<script src="../js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<script src="js/bootstrap-table.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(".nav-tour").addClass('active');
    $(".nav-catg").addClass('active');


    $(document).ready(function(){  
    $('#tabCatg').bootstrapTable({
      url: 'actions/getCategories.php',
      columns: [{
          field: 'id',
          title: 'ID'          
      }, {
          field: 'catg',
          title: 'Categories',
          width: '70%'
      },{
          field: 'opc',
          title: 'Opciones',
          align: 'center',
          valign: 'middle',
          width: '14%' 
      },]
    });
  });


  function updateInfo(id){
        $('.alert-emphy').hide();
        $('.alert-catg-success').hide();
        $('.alert-problem').hide();
        $('.alert-catg--new').hide();
        $.get("actions/CategoriesAction.php", {action:"updateInfo", idcatg:id}, function(data){
            if(data != 'err'){
                var datasr = JSON.parse(data);
                var name = datasr['descrip'];
                var id = datasr['id_catgry'];
                $('#textCatg').val(name);
                $('#idval').val(id);
                $('#myModalEditCatg').modal('show');

            }else{
                alert("There was a problem. <strong>Try again later.</strong>.");                          
            }

        }); 
  }

  function createNew(){
    var valores = $('#textnewCatg').val();    
    
    $('.alert-emphy').hide();
    $('.alert-catg-success').hide();
    $('.alert-problem').hide();
    $('.alert-catg--new').hide();
        
    if(valores.length != 0){
        var param ={
          'action' : 'newNameCatg',
          'datos' : valores
        }
        $.ajax({
           type:'GET',
           url:'actions/CategoriesAction.php',
           data: param,
           beforeSend: function () { 
              $(".loader").fadeIn("slow");               
           },
           success:function(data){
            console.log(data);
            $(".loader").fadeOut("slow");
            if(data == 'ok'){
                $('.alert-catg--new').show();
                $('#tabCatg').bootstrapTable('refresh');
                $('#textnewCatg').val("");
                $('#myModalNewCatg').modal('hide');
            }else{
                $('.alert-problem').show();
            }
             
           }
        });
    }else{
      $('.alert-emphy').show();
    }
  }

  function updateInfoCatg(){    
    var valores = $('#textCatg').val();
    var id = $('#idval').val();
    
    $('.alert-emphy').hide();
    $('.alert-catg-success').hide();
    $('.alert-problem').hide();
    $('.alert-catg--new').hide();    
    if(valores.length != 0){
        var param ={
          'action' : 'updateNameCatg',
          'id' : id,
          'datos' : valores
        }
        $.ajax({
           type:'GET',
           url:'actions/CategoriesAction.php',
           data: param,
           beforeSend: function () { 
                $(".loader").fadeIn("slow");               
           },
           success:function(data){
            $(".loader").fadeOut("slow");            
            if(data == 'ok'){
                $('.alert-catg-success').show();
                $('#tabCatg').bootstrapTable('refresh');
                $('#myModalEditCatg').modal('hide');
            }else{
                $('.alert-problem').show();
            }
             
           }
        });
    }else{
      $('.alert-emphy').show();
    }
    
  }

   $( window ).on("load", function() {
      $(".loader").fadeOut("slow");
   });

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