jQuery(document).ready(function($){
	var $form_modal = $('.cd-user-modal'),
		$form_login = $form_modal.find('#cd-login'),
		$form_signup = $form_modal.find('#cd-signup'),
        $nav_login = $('.cd-signin'),
		$form_forgot_password = $form_modal.find('#cd-reset-password'),
		$form_modal_tab = $('.cd-switcher'),
		$tab_login = $form_modal_tab.children('li').eq(0).children('a'),
		$tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
		$forgot_password_link = $form_login.find('.cd-form-bottom-message a'),
		$back_to_login_link = $form_forgot_password.find('.cd-form-bottom-message a'),
		$main_nav = $('.main-nav');
        $nav_register = $('.register');
        $btn_reserve_block = $('.btn-reserve-is-bloked');
	//open modal
	$main_nav.on('click', function(event){
			//show modal layer
			$form_modal.addClass('is-visible');	
			//show the selected form
			( $(event.target).is('.cd-signup') ) ? signup_selected() : login_selected();		

	});

	//close modal
	$('.cd-user-modal').on('click', function(event){
		if( $(event.target).is($form_modal) || $(event.target).is('.cd-close-form') ) {
			$form_modal.toggleClass('is-visible');
		}	
	});
	//close modal when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		$form_modal.removeClass('is-visible');
	    }
    });

	//switch from a tab to another
	$form_modal_tab.on('click', function(event) {
		event.preventDefault();
		( $(event.target).is( $tab_login ) ) ? login_selected() : signup_selected();
	});

    
    $nav_login.on('click', function(event) {
        event.preventDefault();        
    });
    $nav_register.on('click', function(event) {
        event.preventDefault();        
    });
    $btn_reserve_block.on('click', function(event) {
        event.preventDefault(); 
        $form_modal.addClass('is-visible'); 
        ( $(event.target).is('.cd-signup') ) ? login_selected() : signup_selected();              
    });

	//hide or show password
	$('.hide-password').on('click', function(){
		var $this= $(this),
			$password_field = $this.prev('input');
		
		( 'password' == $password_field.attr('type') ) ? $password_field.attr('type', 'text') : $password_field.attr('type', 'password');
		( 'Hide' == $this.text() ) ? $this.text('Show') : $this.text('Hide');
		//focus and move cursor to the end of input field
		$password_field.putCursorAtEnd();
	});

	//show forgot-password form 
	$forgot_password_link.on('click', function(event){
		event.preventDefault();
		$('.msgPass').css('display','none');
        $('.buttonRes').css('display','block');
        document.getElementById("form-respassword").disabled = false;
		forgot_password_selected();
	});

	//back to login from the forgot-password form
	$back_to_login_link.on('click', function(event){
		event.preventDefault();
		login_selected();
	});

	function login_selected(){
		$form_login.addClass('is-selected');
		$form_signup.removeClass('is-selected');
		$form_forgot_password.removeClass('is-selected');
		$tab_login.addClass('selected');
		$tab_signup.removeClass('selected');
	}

	function signup_selected(){
		$form_login.removeClass('is-selected');
		$form_signup.addClass('is-selected');
		$form_forgot_password.removeClass('is-selected');
		$tab_login.removeClass('selected');
		$tab_signup.addClass('selected');
	}

	function forgot_password_selected(){
		$form_login.removeClass('is-selected');
		$form_signup.removeClass('is-selected');
		$form_forgot_password.addClass('is-selected');
	}

	//REMOVE THIS - it's just to show error messages 
	//$form_login.find('input[type="email"]').toggleClass('has-error').next('span').toggleClass('is-visible');
	$("#loginform").submit(function(event){
		event.preventDefault();
		var $button_form = $('#form-login');
		
		$.ajax({
            type: 'POST',
            url: 'actions/security.php',
            data: $(this).serialize(),
            beforeSend:function(){                  
                document.getElementById("form-login").disabled = true; 
                $button_form.val('Loading...');                            
            },
            success: function(data) {
            	if(data == "ok"){
                   $("#signupform")[0].reset();
                   setTimeout('document.location.reload()',1000);
                }else if(data == "nokk"){
                	alert('Unregistered user');
                	$("#signupform")[0].reset(); 
                    $button_form.val('Login');
                    document.getElementById("form-login").disabled = false;
                }
                else{
                    alert('Incorrect email and password.');
                    $("#signupform")[0].reset(); 
                    $button_form.val('Login');
                    document.getElementById("form-login").disabled = false;
                }              
                
            }
        }); 
	});
	
	$("#signupform").submit(function(event){
		event.preventDefault();
		var $button_form = $('#form-registre');
		 if($('#accept-terms').is(':checked')){
            $.ajax({
                type: 'POST',
                url: 'actions/security.php',
                data: $(this).serialize(),
                beforeSend:function(){ 
                    $("#signupform")[0].reset(); 
                    document.getElementById("signup-zipost").disabled = false;
                    document.getElementById("form-registre").disabled = true;
                    $("#signup-zipost").val(""); 
                    $button_form.val('Loading...');             
                },
                success: function(data) {                	
                    if(data == "ok"){
                       alert('Successfully registered user');
                       setTimeout('document.location.reload()',1000);
                    }else{                    	
                        $button_form.val('Create Account');
                        document.getElementById("form-registre").disabled = false;
                        alert(data);
                    }              
                    
                }
            });   
        }else{
            alert('Accept the terms and conditions to continue...');
        }	
		
    });


    $("#resetpassword").submit(function(event){
		event.preventDefault();
		var $button_form = $('#form-respassword');
		var $text_msg = $('#msg-respassword');
		 
            $.ajax({
                type: 'POST',
                url: 'actions/security.php',
                data: $(this).serialize(),
                beforeSend:function(){ 
                    $("#resetpassword")[0].reset();                     
                    document.getElementById("form-respassword").disabled = true;
                    $button_form.val('Loading...');             
                },
                success: function(data) {
                	
                	if(data != "nok"){
                       $('.msgPass').css('display','block');
                       $('.buttonRes').css('display','none');
                       $button_form.val('Reset password');
                       $text_msg.val('Your new password is '+data);                       
                    }else{                    	
                        $button_form.val('Reset password');
                        $('.msgPass').css('display','none');
                        document.getElementById("form-respassword").disabled = false;
                        alert('Unregistered user.');
                    }              
                    
                }
            });   
        	
		
    }); 



});


//credits https://css-tricks.com/snippets/jquery/move-cursor-to-end-of-textarea-or-input/
jQuery.fn.putCursorAtEnd = function() {
	return this.each(function() {
    	// If this function exists...
    	if (this.setSelectionRange) {
      		// ... then use it (Doesn't work in IE)
      		// Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
      		var len = $(this).val().length * 2;
      		this.setSelectionRange(len, len);
    	} else {
    		// ... otherwise replace the contents with itself
    		// (Doesn't work in Google Chrome)
      		$(this).val($(this).val());
    	}
	});
};