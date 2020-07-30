<?php include 'index_ctrl.php'; ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <title>Character selection menu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body class="container-fluid w-50 pt-5">
      <div class="jumbotron p-5">
        <h3 class="text-center"><u>Welcome To The Jungle, my friend !</u></h3>
        <?php if ($error) { ?>
          <h4 class="text-center text-danger pt-3"><?= $errorMessage ?></h4>
        <?php } else if ($valid) { ?>
          <h4 class="text-center text-success pt-3"><?= $validMessage ?></h4>
        <?php } ?>
        <form class="w-100 p-3" action="#" method="post">
          <div class="col-12 form-group mb-5">
            <input class="form-control mx-auto col-8" type="text" name="username" placeholder="Enter your name" maxlength="150" required>
          </div>
          <div class="col-12 d-flex">
            <input type="submit" name="create" class="btn btn-lg btn-block btn-info col-6 mr-2" value="Create">
            <input type="submit" name="use" class="btn btn-lg btn-block btn-success col-6 mt-0" value="Connection">
          </div>
        </form>
      </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
