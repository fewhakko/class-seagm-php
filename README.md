# class-seagm-php

#### LoginToken
```
<?php
  require("class.seagm.php");
  $api = new FivemAPI();
  
  $server = $api->ServerInfo("127.0.0.1", "30120"); //Change 127.0.0.1 to your IP Server //Change 30120 to your Port Server
  echo json_encode($server);
?>
```

