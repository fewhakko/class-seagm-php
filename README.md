# class-seagm-php

#### LoginToken
```
<?php
  require("class.seagm.php");
  $seagm = new SeagmIOS($email,$password);
  print_r($seagm->GetUserToken());
  print_r($seagm->Login($user_token));
?>
```
#### GetListGame
```
foreach ($seagm->getListGame()["cardList"] as $data) {
    print_r($data);
}
```
#### BuyOrder
```
$trade = $seagm->BuyOrderFreeFire("5669",$player_id)["trade"];
if (isset($trade["id"])) {
  $confirm = $seagm->ConfirmOrder($trade["id"]);

  if ($confirm[0]["alert"][0][0] == "Insufficient account balance") {
      echo "คุณมีเงินไม่พอ.";
  } else {
      print_r($seagm->SendMessageOrder($trade["orders"],$player_id));
  }
}
```

