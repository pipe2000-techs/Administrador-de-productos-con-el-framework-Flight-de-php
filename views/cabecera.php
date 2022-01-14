<!doctype html>
<html lang="en">
  <head>
    <title>Flight php</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="icon" type="image/png" href="static/icon/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link type="text/css" rel="stylesheet" href="static/css/style.css" />
  </head>
  <body>
    
    <nav class="navbar navbar-expand navbar-light bg-light" id="navbarSupportedContent">
      <div class="collapse navbar-collapse">
        <div class="nav navbar-nav mr-auto">
            <a class="nav-item nav-link active" href="./">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="./">Proyectos</a>
        </div>
        <div class="form-inline mt-2 mt-md-0">
          <a class="nav-item nav-link" >Hola "<?php echo $_SESSION['user']['nom_user']?>"</a>
          <button class="btn btn-danger my-2 my-sm-0" data-toggle="modal" data-target="#exit"><i class="bi bi-box-arrow-right" style="font-size: 1rem;"></i></button>
        </div>
      </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
            