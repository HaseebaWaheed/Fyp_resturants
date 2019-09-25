<html>  
<!-- Test Comment -->
 <head>  
   <title><?php echo $title; ?></title>  
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
      <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
      <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
   <style>  
           body  
           {  
                margin:0;
                padding:0;  
                background-color:#000000;  
                color:#FFD164;
           }  
           .box  
           {  
                width:900px;  
                padding:20px;  
               
                border:1px solid #FFD164;  
                border-radius:5px #FFD164;  
                margin-top:10px;  
           }  
           
           .w3layouts-main{
               background-image: url('./assets/bg.jpg');//ye mai  ny sahi kr dia tha 
               background-repeat: repeat-x;
               animation: slideleft 20000s infinite linear;
               -webkit-animation: slideleft 20000s infinite linear;
               background-size: cover;
                    -webkit-background-size:cover;
                    -moz-background-size:cover; 
               background-attachment: fixed;
               position: relative;
                    min-height: 100vh;
               }

               .bg-layer {
               background: rgba(0, 0, 0, 0.7);
                    min-height: 100vh;
               }
      </style>  
 </head>  
 <body>  
 <div class="w3layouts-main">
     <div class="bg-layer">

      <div class="container box">  
           <h3 align="center"><?php echo $title; ?></h3><br />  
           <div class="table-responsive">  
                <table id="model_data" class="table table-bordered table-striped">  
                     <thead>  
                          <tr>  
                                <th width=50%>Name</th>
                                <th width=25%>Dishes</th>
                                 <th width="25%">Delete</th> 
                          </tr>  
                     </thead>  
                </table>  
           </div>  
      </div>  
     </div>
</div>
 </body>  
 </html>  

 <script type="text/javascript" language="javascript" >  
 $(document).ready(function(){
      console.log("ajax Initiated");  
    var dataTable = $('#model_data').DataTable({  
               "processing":true,  
               "serverSide":true,  
               "order":[],  
               "ajax":{  
                    url:"<?php echo base_url() . 'resturants/fetch_model'; ?>",  
                    type:"POST"  
               },  
               "columnDefs":[  
                    {  
                         "targets":[0, 1, 2],  
                         "orderable":false,  
                    }  
               ],  
          });
    
      $(document).on('click', '.delete', function(){  
           var resturant_id = $(this).attr("id");  
           console.log(resturant_id);
           if(confirm("Are you sure you want to delete this?"))  
           {  
                $.ajax({  
                     url:"<?php echo base_url(); ?>Resturants/delete_resturant",  
                     method:"POST",  
                     data:{resturant_id:resturant_id},  
                     success:function(data)  
                     {  
                          alert(data);  
                          dataTable.ajax.reload();  
                     }  
                });  
           }  
           else  
           {  
                return false;
           }  
      });  
      
       
 });  

 </script>