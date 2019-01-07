$(document).ready(function(){
   $("#loading").hide();
   $("#frmAcceso").on('submit',function(e){

      e.preventDefault();
      $("#formusu").removeClass("has-error");
      $("#mensajeUsu").text("");
      $("#mensajePass").text("");
      $("#loading").show();

      var loginusu=$("#usuario").val();
      var passusus=$("#password").val();
      $("#password").val("");
      $.post("php/Clogin.php?op=verificar",{"usu":loginusu,"pass":passusus},function(data, status){
         data = JSON.parse(data);
         var Mensaje=data.Mensaje;
         var Error=data.Error;
         var rol=data.Rol;

          if(Error==1){
            // error de usuario
             $("#formusu").addClass("has-error");
             $("#mensajeUsu").text(Mensaje);
           }
          else if(Error==2){
            // error de password
            $("#formpass").addClass("has-error");
            $("#mensajePass").text(Mensaje);
         }else{
            $("#loading").hide();
            window.location.replace("admin.php");
         }
       }).always(function(){
         $("#loading").hide();
       });
   });
});

