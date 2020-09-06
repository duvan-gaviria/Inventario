$(document).ready(function() {

  $('#saveequipo').click(function() {
      let dataform =$('#insertequiclaro').serialize();
          $.ajax({
            url:'InsertEquipFinaClaro.php',
            type:'POST',
            data: dataform,
            success: function(response) {
           
         $('#resultadocliente').html(response );
            
            }
        });
        });
        
        
    
 
});