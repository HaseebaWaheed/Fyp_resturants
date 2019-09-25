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
          
                                   <!-- JCrop Files -->
          <link rel="stylesheet" type="css/text" href="<?php echo base_url();?>src/css/jquery.Jcrop.css"/>
          <!-- <script src="<?php echo base_url();?>src/js/jquery.min.js"></script> -->
          <script src="<?php echo base_url();?>src/js/jquery.Jcrop.min.js"></script>
          <script src="<?php echo base_url();?>src/js/jquery.color.js"></script>
                                   <!-- End Of JCrop Files -->

                                   <!-- Temp Addition -->
          
          
          <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/core.js"></script> -->
          <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
          <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/2.0.4/css/Jcrop.min.css"/> -->
          <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/2.0.4/js/Jcrop.min.js"></script> -->

                                   <!-- End of Temp Addition -->

          <!-- <link href="<?php echo base_url();?>dist/rcrop.css.map" media="screen" rel="stylesheet" type="text/css"/> -->
          <!-- <link href="<?php echo base_url();?>dist/rcrop.css" media="screen" rel="stylesheet" type="text/css"/> -->
          <!-- <link href="<?php echo base_url();?>dist/rcrop.min.css" media="screen" rel="stylesheet" type="text/css"/> -->
          <!-- <script src="<?php echo base_url();?>dist/rcrop.min.js"></script> -->
          <!-- <script src="<?php echo base_url();?>libs/jquery.js" ></script> -->
          <!-- <script src="<?php echo base_url();?>src/js/rcrop.js"></script> -->
          <!-- <link rel="stylesheet" href="<?php echo base_url();?>src/scss/rcrop.scss"/> -->

          
     <style>  
           body  
           {  
                margin:0;
                padding:0;  
                background-color:#f1f1f1;  
           }  
           .box  
           {  
                width:900px;  
                padding:20px;  
                background-color:#fff;  
                border:1px solid #ccc;  
                border-radius:5px;  
                margin-top:10px;  
           }
           #cropped-original, #cropped-resized{
                padding: 20px;
                border: 4px solid #ddd;
                min-height: 60px;
                margin-top: 20px;
            }
            #cropped-original img, #cropped-resized img{
                margin: 5px;
            } 

      </style>  
 </head>  
 <body>  
 
      <div class="container box">  
           <h3 align="center"><?php echo $title; ?></h3><br />  
           <div class="table-responsive">  
                <br />  
                <button type="button" id="add_button" data-toggle="modal" data-target="#modelModal" class="btn btn-info btn-lg">Add</button>  
                <br /><br />  
                <table id="model_data" class="table table-bordered table-striped">  
                     <thead>  
                          <tr>  
                               <th width="20%">Image</th>  
                               <th width=20%>Name</th>
                               <th width="20%">Details</th>
                               <th width="15%">Edit</th>  
                               <th width="15%">Delete</th> 
                               <th width="10"> Add Model</th>
                          </tr>  
                     </thead>  
                </table>  
           </div>  
      </div>  
 </body>  
 </html>  
 <div id="modelModal" class="modal fade">  
     <div class="modal-dialog">  
          <form method="post" id="model_form" enctype="multipart/form-data"> 
               <div class="modal-content">  
                    <div class="modal-header">  
                         <button type="button" class="close" data-dismiss="modal">&times;</button>  
                         <h4 class="modal-title">Crop Dish</h4>  
                    </div>  
                    <div class="modal-body">  
                         <label>Enter Name</label>  
                         <input type="text" name="name" id="name" class="form-control" />  
                         <br />  
                         <label> Servings</label>
                         <input type="text "name= "servings" id="servings" class="form-control"/>
                         <br />         
                         <label> Ingridients </label>
                         <input type="text "name= "ingridients" id="ingridients" class="form-control"/>
                         <br /> 
                         <label> Price </label>
                         <input type="text "name= "price" id="price" class="form-control"/>
                         <br />


                         <div class="image-wrapper">
                              <img id="dish_source" src="<?php echo(base_url());?>uploads/<?php echo $model_pic; ?>" alt="menu_card image" >
                         </div>
                    </div>
                    <div class="modal-body">  
                         <span id="model_uploaded_image"></span>  
                    </div>  
                    <div class="modal-footer">  
                         <input type="hidden" name="model_id" id="model_id" />  
                         <input type="hidden"  name = "operation" id="operation" value = "Add" />
                         <input type="hidden" id="dish_source" name="dish_source" value = "<?php echo base_url();?>uploads/<?php echo $model_pic; ?>"/>
                         <input type="hidden" id="x" name="x">
                         <input type="hidden" id="y" name="y">
                         <input type="hidden" id="h" name="h">
                         <input type="hidden" id="w" name="w">
                         <input type="submit"  name="action" id="action" class="btn btn-success" value="Add" />  
                         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                    </div>  
               </div>  
          </form>  
     </div>
</div> 
 

<script type="text/javascript" language="javascript" >  
     $(document).ready(function(){  
          $('#add_button').click(function(){  
               $('#model_form')[0].reset();  
               $('.modal-title').text("Add model");  
               $('#action').val("Add");  
               $('#model_uploaded_image').html(''); 
          });  
           $('#dish_source').Jcrop({
               onSelect:    showCoords,
               bgColor:     'black',
               bgOpacity:   .4,
           });


     
          // $('#image-3').rcrop({
          //                // minSize : [100,100],
          //                preserveAspectRatio : false,
          //                // full:true,
          //                preview : {
          //                    display: true,
          //                    size : [200,200],
          //                    wrapper : '#custom-preview-wrapper'
          //                }
          //            });     
          //  $('#image-3').on('rcrop-changed', function(){
          //            var srcOriginal = $(this).rcrop('getDataURL');
          //            var srcResized = $(this).rcrop('getDataURL', 50,50);
                         
          //            $('#cropped-original').append('<img src="'+srcOriginal+'">');
          //           $('#cropped-resized').append('<img src="'+srcResized+'">');
          //      });   
          
          
          


          var dataTable = $('#model_data').DataTable({  
               "processing":true,  
               "serverSide":true,  
               "order":[],  
               "ajax":{  
                    url:"<?php echo base_url() . 'Dishes/fetch_model'; ?>",  
                    type:"POST"  
               },  
               "columnDefs":[  
                    {  
                         "targets":[0,2, 3],  
                         "orderable":false,  
                    }  
               ],  
          });
          $(document).on('submit', '#model_form', function(event){
               console.log("Form Submitted");  
               event.preventDefault();  
               var name = $('#name').val();
               var servings = $("#servings").val();
               var price = $("#price").val();
               var ingridients = $("#ingridients").val()
               // var action = $('#action').val();  
               // var extension = $('#model_image').val().split('.').pop().toLowerCase();  
               // if(extension != '')  
               // {  
               
               //      if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
               //      {  
               //           alert("Invalid Image File");  
               //           $('#model_image').val('');  
               //           return false;  
               //      }  
               // }
               if(name != '' && servings != '' && price != '' && ingridients != '')  
               {  
          
                    $.ajax({  
                         url:"<?php echo base_url() . 'Dishes/model_action'?>",  
                         method:'POST',  
                         data:new FormData(this),  
                         contentType:false,  
                         processData:false,  
                         success:function(data)  
                         {
                              console.log("form success");  
                               alert(data);  
                              $('#model_form')[0].reset();  
                              $('#modelModal').modal('hide');  
                              dataTable.ajax.reload();  
                         }  
                    });  
               
               }  
               else  
               {  
                     alert("Fields are Required");  
    
               }  
          });  
          $(document).on('click', '.update', function(){  
               var model_id = $(this).attr("id");  
               $.ajax({  
                    url:"<?php echo base_url(); ?>Dishes/fetch_single_model",  
                    method:"POST",  
                    data:{model_id:model_id},  
                    dataType:"json",  
                    success:function(data)  
                    {  
                         $('#modelModal').modal('show');  
                         $('#name').val(data.name);  
                         $('.modal-title').text("Edit model");  
                         $('#model_id').val(model_id);  
                         $('#model_uploaded_image').html(data.model_image);  
                         $('#operation').val("Edit");
                         $('#action').val("Edit");  
                    }  
               })  
          });  
          $(document).on('click', '.delete', function(){  
               var model_id = $(this).attr("id");  
               if(confirm("Are you sure you want to delete this?"))  
               {  
                    $.ajax({  
                         url:"<?php echo base_url(); ?>Dishes/delete_single_model",  
                         method:"POST",  
                         data:{model_id:model_id},  
                         success:function(data)  
                         {  
                             // alert(data);  
                              dataTable.ajax.reload();  
                         }  
                    });  
               }  
               else  
               {  
                    return false;
               }  
          });  
      
          $(document).on('click', '.addModel', function(){  
               var model_id = $(this).attr("id");  
               $.ajax({  
                    url:"<?php echo base_url(); ?>Menu/model_action",  
                    method:"POST",  
                    data:{
                         model_id:model_id,
                         operation:"addModel"
                    },  
                    dataType:"json",  
                    success:function(data)  
                    {  
                         window.location.href = './Dish_model_controller';

                    }  
               })  
          }); 

        

     });
     function showCoords(c)
     {
          // variables can be accessed here as
          // c.x, c.y, c.x2, c.y2, c.w, c.h

          $("#x").val(c.x);
          $("#y").val(c.y);
          $("#w").val(c.w);
          $("#h").val(c.h);

     };  
</script>  