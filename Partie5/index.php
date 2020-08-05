<?php include 'controller/index.ctrl.php'; ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <title>Character Selection Menu</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="container-fluid w-50 pt-5">
  <div class="jumbotron p-5 mt-2">
    <?php if ($userConnected || isset($_SESSION['userConnected'])){
      if (isset($_SESSION['userConnected'])) { $user = $_SESSION['userConnected']; }?>
      <h2 class="text-center mb-3"><u>Combat Game</u></h2>
      <?php if ($error) { ?>
        <h4 class="text-center text-danger py-3"><?= htmlspecialchars($errorMessage) ?></h4>
      <?php } else if ($valid) { ?>
        <h4 class="text-center text-success py-3"><?= htmlspecialchars($validMessage) ?></h4>
      <?php } ?>
      <div class="w-100 d-flex flex-wrap">
        <div class="col-12 bg-secondary pt-2 mt-2 mb-3" style="border-radius: 0.3rem;">
          <h3 class="text-center text-white"><?=  htmlspecialchars($user->name()) ?></h3>
          <div class="w-100 py-3">
            <label class="text-center d-block text-white" for="damagesProgress">Amount of damages : <?= htmlspecialchars($user->damages()) ?>% </label>
            <progress id="damagesProgress" class="w-100" style="height: 3vh;" min="0" max="100" value="<?= htmlspecialchars($user->damages()) ?>"> <?= htmlspecialchars($user->damages()) ?> damages </progress>
          </div>
        </div>
        <?php $bg_color = '#C1C1C1';
        if ($user->type() == 'wizard'){
          $bg_color = '#5CC146';
        }
        else if ($user->type() == 'warrior'){
          $bg_color = '#58463C';
        } ?>
        <div class="col-5 d-flex text-white py-2" style="background-color: <?= $bg_color ?>;border-radius: 0.3rem;">
          <h4 class="text-center mx-auto"><u><?= htmlspecialchars(strtoupper($user->type())) ?></u></h4>
        </div>
        <div class="col-7 d-flex" style="background-color: #C1C1C1; border-radius: 0.3rem;">
          <div class="list-group m-auto w-100">
            <?php foreach ($manager->userList() as $users){
              if ($users['id'] != $user->id()){ ?>
                <div class="list-group-item w-100">
                  <div class="d-flex col-12">
                    <span style="align-self: center;"><?= htmlspecialchars($users['name']) ?> : <?= htmlspecialchars($users['damages']) ?>% dmg</span>
                    <form class="ml-auto d-flex" action="#" method="post">
                      <input type="hidden" name="userToHitId" value="<?= $users['id'] ?>">
                      <input class="btn btn-warning font-weight-bold m-auto" type="submit" name="hitPlayer" value="hit !">
                    </form>
                    <?php if ($user->type() === 'wizard'){ ?>
                      <form class="ml-auto d-flex" action="#" method="post">
                        <input type="hidden" name="userToHitId" value="<?= $users['id'] ?>">
                        <input class="btn btn-info font-weight-bold m-auto" type="submit" name="spell" value="spell !">
                      </form>
                    <?php } ?>
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
      <p class="text-center">Nombre de personne enregistré : <?= $manager->countUsers() ?: 0; ?></p>
      <?php if ($error) { ?>
        <h4 class="text-center text-danger pt-3"><?= $errorMessage ?></h4>
      <?php } else if ($valid) { ?>
        <h4 class="text-center text-success pt-3"><?= $validMessage ?></h4>
      <?php } ?>
      <form class="w-100 p-3" action="#" method="post">
        <div class="col-12 form-group mb-4">
          <input class="form-control mx-auto col-8" type="text" name="username" placeholder="Enter your name" maxlength="150" autofocus autocomplete="name" required>
        </div>
        <div class="col-8 flex-wrap collapse mb-2 mx-auto" id="selection">
          <input type="submit" name="create" class="btn btn-block btn-success mb-2" value="Validate your type">
          <div class="d-flex">
            <input type="radio" name="type" value="warrior" class="mx-4">
            <input type="text" class="form-control bg-white text-center" value="Warrior" readonly>
          </div>
          <div class="d-flex">
            <input type="radio" name="type" value="wizard" class="mx-4">
            <input type="text" class="form-control bg-white text-center" value="Wizard" readonly>
          </div>
        </div>
        <div class="col-12 d-flex">
          <button type="button" id="createButton" data-toggle="collapse" data-target="#selection" class="btn btn-lg btn-block btn-info col-6 mr-2">Create</button>
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
