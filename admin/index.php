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
	<!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900" rel="stylesheet">
    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">	
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">  
	
    
</head>

<body oncontextmenu="return false" onkeydown="return false">

<?php
   include_once('header.php');
?>	
	
	
    <section class="home-title">
    	<div class="container">
    		<h2>London Tours Administration System</h2>			
    		<a class="btn btn-info" target="_black" href="<?php echo $url_actual."index" ?>">Go to home page</a>
    	</div>
    </section>
<?php
   include_once('footer.php');
?>

<script src="../js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<script type="text/javascript">
    $(".nav-home").addClass('active');
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
