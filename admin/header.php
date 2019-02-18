<div class="nav-menu">
        <div class="bg transition">
                <div class="col-md-12 bg-dark">
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
                        <a class="navbar-brand" href="index">
                        	<img src="../images/tour_logo.png" alt="London Tours">
                        	
                        </a>
                        <a class="nav-link title-user">Welcome <?php echo $name; ?></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            				<span class="navbar-toggler-icon"></span>
          				</button>              				
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item">
									<a class="nav-link nav-home" href="index">Home <span class="sr-only">(current)</span></a>
								</li>
								<li class="nav-item dropdown">
							        <a class="nav-link nav-tour dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" class="nav-tour" aria-haspopup="true" aria-expanded="false">
							          Tour Activities
							        </a>
							        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                      <a class="dropdown-item nav-tour-mang" href="crudtour">Tours</a>
							          <a class="dropdown-item nav-catg" href="categories">Categories</a>
							          <a class="dropdown-item nav-tikect" href="tickets">Class of tickets</a>
							        </div> 
							    </li>
                                <li class="nav-item">
                                    <a class="nav-link nav-reser" href="crudreser">Reservations</a>
                                </li>
								
							</ul>
                        </div>
                    </nav>
                </div>  
        </div>
    </div>