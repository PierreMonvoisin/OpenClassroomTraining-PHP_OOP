<?php include 'controller/index.ctrl.php'; ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <title>Character Selection Menu</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style>
    progress[value]::-moz-progress-bar, progress {
      border-radius: 0.25rem;
    }
    #expProgress::-moz-progress-bar {
      background-color: green;
    }
  </style>
</head>
<body class="container-fluid w-50 pt-5">
  <div class="jumbotron p-5 mt-2">
    <!-- If the user is connected -->
    <?php if ($userConnected || isset($_SESSION['userConnected'])){
      if (isset($_SESSION['userConnected'])) { $user = $_SESSION['userConnected']; }?>
      <h2 class="text-center mb-3"><u>Combat Game</u></h2>
      <?php if ($error) { ?>
        <h4 class="text-center text-danger py-3"><?= htmlspecialchars($errorMessage) ?></h4>
      <?php } else if ($valid) { ?>
        <h4 class="text-center text-success py-3"><?= htmlspecialchars($validMessage) ?></h4>
      <?php } ?>
      <div class="w-100 d-flex flex-wrap">
        <!-- User account header -->
        <div class="col-12 bg-secondary pt-2 mt-2 mb-3" style="border-radius: 0.3rem;">
          <h3 class="text-center text-white"><?=  htmlspecialchars($user->name()) ?></h3>
          <!-- EXP -->
          <label class="text-center d-block text-white" for="expProgress">EXP : 50 / 100</label>
          <progress id="expProgress" class="w-100" style="height: 1vh;" min="0" max="100" value="50">50</progress>
          <!-- Damages -->
          <div class="w-100 py-3">
            <label class="text-center d-block text-white" for="damagesProgress">Amount of damages : <?= htmlspecialchars($user->damages()) ?>% </label>
            <progress id="damagesProgress" class="w-100" style="height: 3vh;" min="0" max="100" value="<?= htmlspecialchars($user->damages()) ?>"> <?= htmlspecialchars($user->damages()) ?> damages </progress>
          </div>
        </div>
        <!-- Users list -->
        <div class="col-7 d-flex" style="background-color: #C1C1C1; border-radius: 0.3rem;">
          <div class="list-group m-auto w-100 py-2">
            <?php foreach ($manager->userList() as $users){
              if ($users['id'] != $user->id()){
                if ($users['type'] == 'wizard'){ $border = 'solid #5CC146'; }
                else if ($users['type'] == 'warrior'){ $border = 'solid #58463C'; }
                if ($users['asleep_for'] != 0){ $border = 'dashed #001F24'; } ?>
                <div style="border-left: 8px <?= $border ?>" class="list-group-item w-100">
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
        <?php
        $bg_color = '#C1C1C1';
        $defaultHitText = 'Simple hit that deal 5 damages to your opponent.';
        $specialHitText = 'Special hit';
        if ($user->type() == 'wizard'){
          $bg_color = '#5CC146';
          $specialHitText = 'A spell that hit for less damage but has a chance to put your target asleep.';
        }
        else if ($user->type() == 'warrior'){
          $bg_color = '#58463C';
          $specialHitText = 'You have a chance to block incoming attacks for a third of the damage.';
        } ?>
        <!-- User stats -->
        <div class="col-5 text-white p-2" style="background-color: <?= $bg_color ?>;border-radius: 0.3rem;">
          <h4 class="text-center"><u><?= htmlspecialchars(strtoupper($user->type())) ?></u></h4>
          <div class="d-flex flex-wrap">
            <p class="col-3 text-center px-0">Hit :</p>
            <p class="col-9"><?= $defaultHitText ?></p>
            <p class="col-3 text-center px-0">Special :</p>
            <p class="col-9"><?= $specialHitText ?></p>
            <?php if ($user->isAsleep()){ ?>
              <p class="col-3 text-center px-0">Asleep <wbr>Until</p>
              <?php $revival = $user->displayRevivalDate(); ?>
              <p class="col-9">The <?= htmlspecialchars($revival['date']) ?><br>At <?= htmlspecialchars($revival['time']) ?></p>
            <?php } ?>
          </div>
        </div>
      </div>
      <form class="w-100" action="#" method="post">
        <input type="submit" class="btn btn-dark btn-block mt-3 mx-auto w-50" name="disconnect" value="Disconnect from account">
      </form>
    <?php } else { ?>
    <!-- If the user is not connected -->
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
