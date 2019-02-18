$(".nav-tour").addClass('active');
    $(".nav-tour-mang").addClass('active');


    $(document).ready(function(){  
    $('#tabTour').bootstrapTable({
      url: 'actions/getTour.php',
      columns: [{
          field: 'img',
          title: 'Tour image',
          width: '15%',
          align: 'center',
          valign: 'middle',
      },{
          field: 'name',
          title: 'Tour title',
          width: '20%'          
      },{
          field: 'catg',
          title: 'Category',
          width: '15%'
      },{
          field: 'place',
          title: 'Place',
          align: 'center'
      },{
          field: 'fech',
          title: 'Tour date',
          align: 'center'
      },{
          field: 'feat',
          title: 'Featured',
          align: 'center',
          valign: 'middle',
      },{
          field: 'opc',
          title: 'Opciones',
          align: 'center',
          valign: 'middle',
          width: '14%' 
      },]
    });
   

    $("body").on("click",".content-times-range button span i",function(event){
            event.preventDefault();             
            $('#btn-'+event.target.id).remove();             
    });

    $("body").on("click",".content-types-price button span i",function(event){
            event.preventDefault();             
            $('#btn-'+event.target.id).remove();
            $("#list-type option[value='']").attr("selected",true); 
            $('#price').val('');
            var id = event.target.id.split('-');
            $("#list-type option[value=" + id[1] + "]").removeAttr('disabled');            
    });


    var mjs_show = getQueryVariable('update');
    if(mjs_show == "ok"){        
        $('.alert-catg-success').show();
        $("#tabTour").bootstrapTable('refresh');
    }else{
        hhiden_all();
    }
    

  });

   $( window ).on("load", function() {
      $(".loader").fadeOut("slow");
   });

   function getQueryVariable(variable) {
        var query =  window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0; i < vars.length; i++) {
            var pair = vars[i].split("="); 
            if (pair[0] == variable) {
                return pair[1];
            }
        }
        return false;
    }

   function hhiden_all(){
      $('.alert-catg-success').hide();
      $('.alert-problem').hide();
      $('.alert-catg-del').hide();  
      $('.alert-catg--new').hide();
      $('.alert-time').hide(); 
      $('.alert-price').hide();
      $('.alert-problem').html("");
      $('.alert-problem').html("There was a problem. <strong>Try again later.</strong>."); 
   }

   function showForm(){
      hhiden_all();
      $('.table-tour').hide("slow");
      $('.new-tour').show("slow");
   }

   function hideForm(){
      hhiden_all();
      $('.new-tour').hide("slow");
      $('.table-tour').show("slow");
      $("#tabTour").bootstrapTable('refresh');      
   }

   function updateViewTour(obj,id){
        hhiden_all();
        $.get("actions/TourAction.php", {action:"updateViewTour", id:id, visible:obj.checked}, function(data){            
            if(data == 'ok'){
                $('.alert-catg-success').show();
                $("#tabTour").bootstrapTable('refresh');                
            }else{
               $('.alert-problem').show();
                
            }
        }); 
    }

    function tourDel(id){
      var form_data = new FormData();
      form_data.append("idTourDel", id);
      form_data.append("action", 'deleteTour');     
      hhiden_all();
      $(".loader").fadeIn("slow");
          $.get("actions/TourAction.php", {action:"deleteTour", idTourDel:id}, function(data){
              $(".loader").fadeOut("slow");
              if(data == 'ok'){
                  $('.alert-catg-del').show();                          
                  $("#tabTour").bootstrapTable('refresh');
              }else{
                  $('.alert-problem').show();
              }
                  
          });

    }


    function tourViewUp(id, vis){
        hhiden_all();
        $.get("actions/TourAction.php", {action:"tourViewUp", idart:id, visible: vis}, function(data){
            
            if(data == 'ok'){
                $('#tabTour').bootstrapTable('refresh');
                $('.alert-catg-success ').show();
            }else{
                $('.alert-problem').show();
            }
           
        }); 
     }



     function addTime(){
        var startTime = document.getElementById("time");
        var time = startTime.value;
        if(time.length == 0){
          return false;
        }else{
          $('#time').val('');
          var sep = time.split(":");
          var identy = sep[0]+'-'+sep[1];
          $('.content-times-range').append('<button type="button" class="btn btn-warning btntimes" id="btn-'+identy+'" name="btn-'+identy+'">'+time+'<span class="badge badge-light"><i id="'+identy+'" class="fa fa-remove"></i></span></button>');
        }
     }


     function addPrice(){
        var type_pr = $('#list-type').val();        
        var type_pr_txt = $('select[name="list-type"] option:selected').text()
        var price = $('#price').val();
        var conver_price = parseFloat(price);
        if(type_pr.length == 0){
          return false;
        }else if(price.length == 0){
          return false;
        }else{
          $("#list-type option[value='']").attr("selected",true);
          $("#list-type option[value="+type_pr+"]").attr("disabled","disabled");
          $('#price').val('');
          conver_price = trunk(conver_price).toString().split('.');

          $('.content-types-price').append('<button type="button" class="btn btn-warning btntypes" id="btn-'+type_pr+'-'+conver_price[0]+'-'+conver_price[1]+'" name="btn-'+type_pr+'-'+conver_price[0]+'-'+conver_price[1]+'">'+type_pr_txt+' : '+conver_price+' $US <span class="badge badge-light"><i id="'+type_pr+'-'+conver_price[0]+'-'+conver_price[1]+'" class="fa fa-remove"></i></span></button>');
          
        } 

     }

    function trunk(n) {
        let t=n.toString();
        let regex=/(\d*.\d{0,2})/;
        return t.match(regex)[0];
    }

    function imgList(evt) {
      var files = evt.target.files; 
   
      for (var i = 0, f; f = files[i]; i++) {          
        if (!f.type.match('image.*')) {
          continue;
        }   
        var reader = new FileReader(); 
        reader.onload = (function(theFile) {
            return function(e) {
              
             document.getElementById("imglist").innerHTML = ['<img class="form-control" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
            };
        })(f); 
        reader.readAsDataURL(f);
        }
    }

    function imgDetail(evt) {
      var files = evt.target.files; 
   
      for (var i = 0, f; f = files[i]; i++) {          
        if (!f.type.match('image.*')) {
          continue;
        }   
        var reader = new FileReader(); 
        reader.onload = (function(theFile) {
            return function(e) {
             
             document.getElementById("imgdetail").innerHTML = ['<img class="form-control" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
            };
        })(f); 
        reader.readAsDataURL(f);
        }
    }


    function searchTour(id){      
        location.href="searchtour?tour="+id;
    }

    function updateTour(id){
        location.href="edittour?tour="+id;
    }


    document.getElementById('filelist').addEventListener('change', imgList, false);
    document.getElementById('filedetail').addEventListener('change', imgDetail, false);

    $("#form-new-tour").submit(function(event){

      event.preventDefault();
      if($(".content-times-range").find('button').length == 0){
        $('.alert-time').show();
        return false;
      }else if($(".content-types-price").find('button').length == 0){
        $('.alert-price').show();
        return false;
      }else{
        var schedule = [];
        var hijos = $(".content-times-range").find('button');
        hijos.each(function() { 
          var list_shuedul = $(this).attr("id").split('-');
          schedule.push(list_shuedul[1]+'-'+list_shuedul[2]);

        });

        var price = [];
        var hijos = $(".content-types-price").find('button');
        hijos.each(function() { 
          var list_prices = $(this).attr("id").split('-');
          var pric = "";
          if(list_prices[3] === 'undefined'){
              pric = list_prices[2].toString();
          }else{
              pric = list_prices[2].toString()+'.'+list_prices[3].toString();
          }
          
          price.push(list_prices[1]+'-'+pric);
          
        });

        hhiden_all();
        
        var form_data = new FormData();
        var catg = $('#list-catg').val();
        var name = $('#name').val();
        var itinerary = $('#itinerary').val();
        var descripsmall = $('#descripsmall').val();
        var datetour = $('#datetour').val();
        var place = $('#place').val();
        var duration = $('#duration').val();
        var lang = $('#lang').val();         
        var feature = $('#feat').prop("checked");
        var active = $('#active').prop("checked");      
        var imgsmall = $('#filelist').prop('files')[0];
        var imglarge = $('#filedetail').prop('files')[0];

        form_data.append("catg", catg);
        form_data.append("name", name);
        form_data.append("itinerary", itinerary);
        form_data.append("descripsmall", descripsmall);
        form_data.append("datetour", datetour);
        form_data.append("place", place);
        form_data.append("schedule", schedule.toString());
        form_data.append("price", price.toString());
        form_data.append("action", 'createNew');
        form_data.append("duration", duration);
        form_data.append("lang", lang);        
        form_data.append("feature", feature);
        
        form_data.append("imgsmall", imgsmall);
        form_data.append("imglarge", imglarge);

        $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                url: 'actions/TourAction.php',
                data: form_data,
                beforeSend: function () { 
                    $(".loader").fadeIn("slow");                    
                },
                success: function(data) {
                    $(".loader").fadeOut("slow");                    
                    if(data == 'ok'){
                      $("#form-new-tour")[0].reset();
                      $('#imgdetail').html("");
                      $('#imglist').html("");  
                      $('.content-times-range').html("");
                      hideForm();                       
                      $('.alert-catg--new').show();                      
                    }else if(data == 'typePassError'){
                      $('.alert-problem').html("");
                      $('.alert-problem').html("<p>You must choose a price for a <strong>type of adult pass</strong>.</p>");
                      $('.alert-problem').show();
                    }else if(data == 'err'){
                      $('.alert-problem').show();
                    }else{
                      $('.alert-problem').html("");
                      $('.alert-problem').html("<p>There was a problem with the images. <strong>Try again.</strong>.</p>");
                      $('.alert-problem').show();
                    }                     
                }
        });
      }
      
    });