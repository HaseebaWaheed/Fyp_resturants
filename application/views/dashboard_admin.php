
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
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
            <li class="active"><a href="<?=base_url("Dashboard_admin/Models")?>">Models</a></li>
        </ul>
    </div>
</nav>

<div class="container">
     <?php $this->load->view("$view");?>
</div>

</body>
</html>
