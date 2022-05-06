<?php
  //.atoum.php

  use mageekguy\atoum;
  use mageekguy\atoum\reports;

  $coveralls = new reports\asynchronous\coveralls('src', 'OoOom8E8HUHEjSksqBtI1rtZbgr6E3OhE');
  $coveralls->addWriter();
  $runner->addReport($coveralls);

  $script->addDefaultReport();