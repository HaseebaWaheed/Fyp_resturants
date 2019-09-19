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

          <script src="./libs/jquery.js" ></script>
          <script src="./dist/rcrop.min.js" ></script>
          <link href="./dist/rcrop.min.css" media="screen" rel="stylesheet" type="text/css">

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

      </style>  
 </head>  
 <body>  
 <h1><?php  $id = $this->session->get_userdata('model_id');
               foreach($id as $value)
               {
                    echo $value;
               }
               echo $model_pic;
 ?></h1>
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
                            <img id='image-3' class="form form-control" src="<?php echo(base_url());?>/uploads/<?php echo $model_pic; ?>" alt="menu image" height="500px"width=""/>

                     <div class="modal-body">  
                          <span id="model_uploaded_image"></span>  
                     </div>  
                     <div class="modal-footer">  
                          <input type="hidden" name="model_id" id="model_id" />  
                          <input type="hidden"  name = "operation" id="operation" value = "Add" />
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
                     
     $('#image-3').rcrop({
                    minSize : [200,200],
                    preserveAspectRatio : true,
                    
                    preview : {
                        display: true,
                        size : [100,100],

                    }
                });
                
      $('#image-3').on('rcrop-changed', function(){
                var srcOriginal = $(this).rcrop('getDataURL');
                var srcResized = $(this).rcrop('getDataURL', 50,50);
                    
                $('#cropped-original').append('<img src="'+srcOriginal+'">');
               $('#cropped-resized').append('<img src="'+srcResized+'">');
          });   
               
     //var dataTable = $('#model_data').DataTable({
     //          "processing":true,
     //          "serverSide":true,
     //          "order":[],
     //          "ajax":{
     //               url:"<?php //echo base_url() . 'dishes/fetch_model'; ?>//",
     //               type:"POST"
     //          },
     //          "columnDefs":[
     //               {
     //                    "targets":[0, 3, 4],
     //                    "orderable":false,
     //               }
     //          ],
     //     });
      $(document).on('submit', '#model_form', function(event){  
           event.preventDefault();  
           var name = $('#name').val();
           var action = $('#action').val();  
           var extension = $('#model_image').val().split('.').pop().toLowerCase();  
           if(extension != '')  
           {  
               
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert("Invalid Image File");  
                     $('#model_image').val('');  
                     return false;  
                }  
           }       
           if(name != '')  
           {  
          
                $.ajax({  
                     url:"<?php echo base_url() . 'dishes/model_action'?>",  
                     method:'POST',  
                     data:new FormData(this),  
                     contentType:false,  
                     processData:false,  
                     success:function(data)  
                     {  
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
                url:"<?php echo base_url(); ?>dishes/fetch_single_model",  
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
                     url:"<?php echo base_url(); ?>dishes/delete_single_model",  
                     method:"POST",  
                     data:{model_id:model_id},  
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
      
      $(document).on('click', '.addModel', function(){  
          var model_id = $(this).attr("id");  
           $.ajax({  
                url:"<?php echo base_url(); ?>menu/model_action",  
                method:"POST",  
                data:{
                     model_id:model_id,
                     operation:"addModel"
                     },  
                dataType:"json",  
                success:function(data)  
                {  
                    window.location.href = './dish_model_controller';

                }  
           })  
      }); 
 });  
 </script>  