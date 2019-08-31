
<!DOCTYPE html>
<html lang="en">
<head>
    <title>model_controller</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script
        src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Admin</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="<?=base_url("model_controller/Models")?>">Models</a></li>
        </ul>
    </div>
</nav>

<div class="container">
<div class="panel panel-default">
        <div class="panel-heading">Gallery Management</div>

        <div class="panel-body">
            <div class="collapse" id="UploadPhotos">
                <div class="well well-sm">
                    <div class="modal-body">
                        <div action='<?=base_url("Model_controller/gallery_upload/".$id)?>' id="dropzone" class="dropzone"> </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="col-md-2">
                        <a class="btn btn-success" data-toggle="collapse" href="#UploadPhotos" aria-expanded="false" aria-controls="UploadPhotos">
                            <i class="fa fa-photo"></i> Add Photos
                        </a>
                    </th>
                    
                   
                    <th class="col-md-2 text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($gallerey as $gallery){ ?>
                <tr  id="tr_<?php echo $gallery->id;?>">
                    <td>
                        <a href='<?php echo base_url("uploads/".$gallery->image); ?>'>
                            <img src='<?php echo base_url("uploads/".$gallery->image); ?>' href='<?php echo base_url("assets/uploads/product/gallery/".$gallery->image); ?>' class="img-responsive colorbox">
                        </a>
                    </td>
                    <td style="padding:35px">
                        <button class="btn btn-danger btn-block btn-md deleteImg" data-id="<?php echo $gallery->id;?>" name="<?php echo $gallery->id;?>">Delete</button>
                    </td>
                </tr>
                <?php } ?>
                
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <script src="<?=base_url('assets/plugins/dropzone/dropzone.min.js'); ?>"></script>
    <script src="<?=base_url('assets/plugins/colorbox/jquery.colorbox.js');?>"></script>

    <script>
    $(document).ready(function(){
        $(".colorbox").colorbox({rel:'colorbox'});
        $(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
    });

    $(function() {
        //Drop zone functions
        Dropzone.options.dropzone = {
            init: function () {
                this.on("addedfile", function(file) {
                    console.log("Upload Processing...");
                    console.log(file);
                });

                this.on('complete', function (file) {
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                        location.reload();
                    }
                });
            }
        };
        $(".deleteImg").click(function() {
            if (confirm('Are you sure you want to delete?')) {
                var image_ids = [];
                image_ids.push(parseInt($(this).data('id')));
                $.post('<?= base_url("Model_controller/gallery_delete") ?>', {
                    image_ids: image_ids,
                    function(resp){
                        //alert(resp);
                   // console.log(resp);
                    location.reload();
                    }
                });
               
            }
        });
   

        
    });
       
</script>
</body>
</html>