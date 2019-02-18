<footer class="page-footer font-small blue pt-4 dark-bg">
    <!-- Footer Links -->
    <div class="container-fluid text-center text-md-left">
      <!-- Grid row -->
      <div class="row">
        <!-- Grid column -->
        <div class="col-md-6 mt-md-0 mt-3 copyright">
          <!-- Content -->
        <a class="navbar-brand" href="index">
        	<img src="images/tour_logo.png" alt="London Tours">
        </a>
          <p class="fo-text">For a trip to London to be perfect, it is necessary to prepare it carefully.</p>

         <form action="" method="post" class="form-suscrip col-md-8 col-sm-8 col-xs-12">
         	<div class="input-group mb-3">
    			  <input type="email" class="form-control" name="suscrip" id="suscrip" placeholder="Email" aria-label="Subscribe" aria-describedby="basic-addon2">
    			  <div class="input-group-append">
  			       <button class="btn btn-outline-secondary" type="button"><i class="fa fa-arrow-right"></i></button>
			      </div>
			    </div>         	
         </form>
        </div>
        <!-- Grid column -->
        <hr class="clearfix w-100 d-md-none pb-3">
        <!-- Grid column -->
        <div class="col-md-2 mb-md-0">
            
        </div> 
          <!-- Grid column -->
          <div class="col-md-3 mb-md-0 mb-3 copyright copyright-list">
            <!-- Links -->            
            <ul class="list-unstyled"> 
	            <li class="nav-item">
	                <a class="nav-link" href="about">About us</a>                                        
	            </li>
	            <li class="nav-item">
	                <a class="nav-link" href="tours">Reserve</a>
	            </li> 
	            <li class="nav-item">
	               <a class="nav-link" href="contacto">Contact us</a>
	            </li>
	            
	               <?php if(!isset($_SESSION['name']) && empty($_SESSION['name'])): ?>
                    <li class="nav-item main-nav">
                      <a class="nav-link cd-signup register" href="#">Sign up</a>
                    </li>
                  <?php else: ?>
                    <li class="nav-item">
                      <a class="nav-link" href="reservations">Reservations</a>
                    </li> 
                  <?php endif; ?>
	                          
            </ul>
          </div>
          <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
    <!-- Footer Links -->
    <!-- Copyright -->
    <div class="footer-copyright text-center">
      <div class="copyright">                        
	        <p>Copyright &copy; 2019. All rights reserved</p>	        
	        <ul>
	            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
	            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
	            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
	        </ul>
	    </div>
    </div>
    <!-- Copyright -->
  </footer>
  

  <?php
    include_once('mod_log_reg.php');
  ?>
