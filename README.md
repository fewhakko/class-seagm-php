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

