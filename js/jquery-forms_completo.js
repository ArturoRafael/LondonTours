$(function() { 
      ViewCountry();
    $('#form-contact').submit(function(event) {
        event.preventDefault();
        $("#form-contact")[0].reset();
        alert("Thanks for choosing us. Soon we will respond to your email.");      
        
    });

});


function changeValue(tipo, idtipo){

  var num = $('#tPrecio'+idtipo);

  if(tipo == "minus"){

    if(num.val() != "Free"){
      var numFlot = parseFloat(num.val());
      var tiketActual = $('.value-'+idtipo).text();
      if(tiketActual != "0"){
        tiketActual = parseInt(tiketActual) - 1;
        var updateTotal = tiketActual * trunk(numFlot);
        updateTotal = trunk(updateTotal);
        $('.value-'+idtipo).text(tiketActual);
        $('#total-'+idtipo).text(updateTotal+" US$");
      }else{
        return false;
      }
    }else{
      var tiketActual = $('.value-'+idtipo).text();
      if(tiketActual != "0"){
        tiketActual = parseInt(tiketActual) - 1;
        $('.value-'+idtipo).text(tiketActual);
      }else{
        return false;
      }
      
    }

  }else if(tipo == "plus"){
    var tiketActual = $('.value-'+idtipo).text();
    var numFlot = parseFloat(num.val());
    
    tiketActual = parseInt(tiketActual) + 1;
       
    if(num.val() != "Free"){
      
      var updateTotal = tiketActual * trunk(numFlot);
      updateTotal = trunk(updateTotal);
      $('.value-'+idtipo).text(tiketActual);
      $('#total-'+idtipo).text(updateTotal+" US$");
    }else{      
      $('.value-'+idtipo).text(tiketActual);
    }

  }else{
    return false;
  }
}

function trunk(n) {
  let t=n.toString();
  let regex=/(\d*.\d{0,1})/;
  return t.match(regex)[0];
}

function ViewCountry(){
        document.getElementById("signup-zipost").disabled = false;       
        $.post("actions/countryAction.php", {actionC:"addInputCountry"}, function(data){
            var myObjStr = [];
            var text = "";            
            if(data != 'err'){             
                 myObjStr = JSON.parse(data);
                 myObjStr.sort();
                 for (var i = 0; i < myObjStr.length; i++) {
                    text = "";
                    text += "<option value='"+myObjStr[i]['id_city']+"'>";
                    text +=  myObjStr[i]['city'];
                    text += "</option>";
                    document.getElementById("signup-country").innerHTML += text;
                 }
            }else{
                document.getElementById("signup-zipost").innerHTML += "";
            }             
        }); 
      }

function ViewZip(obj){ 

var select = document.getElementById("signup-country");
var options=document.getElementsByTagName("option");
var value = select.value;    

    $.post("actions/countryAction.php", {actionZ:"addInputZip", obj:value }, function(data){
        var myObjStr = [];
        var text = "";             
        if(data != 'err'){
             myObjStr = JSON.parse(data);
             myObjStr.sort();
             for (var i = 0; i < myObjStr.length; i++) {
                text = "";
                text += "<option value='"+myObjStr[i]['zip_postal'] +"' selected>";
                text +=  myObjStr[i]['zip_postal'];
                text += "</option>";
                document.getElementById("signup-zipost").innerHTML += text;
             }
        }else{
            document.getElementById("signup-zipost").innerHTML += "";
        }
        if(myObjStr.length < 2){ 
          document.getElementById("signup-zipost").disabled = true;
        }            
    }); 
}


$("#form_search").submit(function(event){
    event.preventDefault();
    $.ajax({
            type: 'POST',
            url: 'actions/security.php',
            data: $(this).serialize(),
            beforeSend:function(){         
            },
            success: function(data) {
                window.location.replace(data);
            }
        }); 
  });
 
