<div class="nav-menu">
        <div class="bg transition">
            <div class="container-fluid fixed">
                <div class="row">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-lg navbar-light ">
                            <a class="navbar-brand" href="index">
                            	<img src="images/tour_logo.png" alt="London Tours">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                				<span class="navbar-toggler-icon"></span>
              				</button>              				
                            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="index">Home</a>                                        
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="about">About Us</a>                                        
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="tours">Tours</a>
                                    </li> 
                                    <li class="nav-item dropdown">
                                       <a class="nav-link" href="contacto">Contact</a>
                                    </li>
                                    
                                    <?php if(!isset($_SESSION['name']) && empty($_SESSION['name'])): ?>
                                    <li class="nav-item dropdown main-nav">                                       
                                            <a class="nav-link cd-signin" href="#0">Login</a>
                                    </li>
                                    <?php else: ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            My account
                                        <span><i class="fa fa-sort-desc"></i></span>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <a class="dropdown-item" href="reservations">Reservations</a>
                                            <?php if(isset($_SESSION['clasUser']) && !empty($_SESSION['clasUser']) && base64_decode($_SESSION['clasUser']) == '1'): ?>
                                                <a class="dropdown-item" target="_black" href="admin/index">Administration</a>
                                            <?php endif;?>
                                            <a class="dropdown-item" href="details_cart">Shopping cart</a>
                                            <a class="dropdown-item" href="actions/close_sesion.php">Logout</a>
                                        </div>
                                    </li>
                                    <?php endif;?>

                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>