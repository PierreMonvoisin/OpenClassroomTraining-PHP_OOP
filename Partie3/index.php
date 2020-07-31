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
    <?php if ($userConnected || isset($_SESSION['userConnected'])){
      if (isset($_SESSION['userConnected'])) { $user = $_SESSION['userConnected']; }?>
      <h3 class="text-center mb-3"><u>Combat Game</u></h3>
      <?php if ($error) { ?>
        <h4 class="text-center text-danger py-3"><?= $errorMessage ?></h4>
      <?php } else if ($valid) { ?>
        <h4 class="text-center text-success py-3"><?= $validMessage ?></h4>
      <?php } ?>
      <div class="w-100 d-flex">
        <div class="col-6 bg-secondary pt-2 mr-2" style="border-radius: 0.3rem;">
          <h4 class="text-center text-white"><?=  htmlspecialchars($user->name()) ?></h4>
          <div class="w-100 py-3">
            <label class="text-center d-block text-white" for="damagesProgress">Amount of damages : <?= $user->damages() ?>% </label>
            <progress id="damagesProgress" class="w-100" style="height: 3vh;" min="0" max="100" value="<?= $user->damages() ?>"> <?= $user->damages() ?> damages </progress>
          </div>
        </div>
        <div class="col-6 d-flex" style="background-color: #C1C1C1; border-radius: 0.3rem;">
          <div class="list-group m-auto w-100">
            <?php foreach ($manager->userList() as $users){
              if ($users['id'] != $user->id()){ ?>
                <div class="list-group-item w-100">
                  <div class="d-flex col-12">
                    <span style="align-self: center;"><?= $users['name'] ?> : <?= $users['damages'] ?>% dmg</span>
                    <form class="ml-auto d-flex" action="#" method="post">
                      <input type="hidden" name="userToHitId" value="<?= $users['id'] ?>">
                      <input class="btn btn-warning font-weight-bold m-auto" type="submit" name="hitPlayer" value="hit !">
                    </form>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
      </div>
      <form class="w-100" action="#" method="post">
        <input type="submit" class="btn btn-dark btn-block mt-3 mx-auto w-50" name="disconnect" value="Disconnect from account">
      </form>
    <?php } else { ?>
      <h3 class="text-center"><u>Welcome To The Jungle, my friend !</u></h3>
      <p class="text-center">Nombre de personne enregistré : <?= $manager->countUsers(); ?></p>
      <?php if ($error) { ?>
        <h4 class="text-center text-danger pt-3"><?= $errorMessage ?></h4>
      <?php } else if ($valid) { ?>
        <h4 class="text-center text-success pt-3"><?= $validMessage ?></h4>
      <?php } ?>
      <form class="w-100 p-3" action="#" method="post">
        <div class="col-12 form-group mb-4">
          <input class="form-control mx-auto col-8" type="text" name="username" placeholder="Enter your name" maxlength="150" required>
        </div>
        <div class="col-12 d-flex">
          <input type="submit" name="create" class="btn btn-lg btn-block btn-info col-6 mr-2" value="Create">
          <input type="submit" name="use" class="btn btn-lg btn-block btn-success col-6 mt-0" value="Connection">
        </div>
      </form>
    <?php } ?>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
