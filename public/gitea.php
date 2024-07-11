<?php

include __DIR__ . '/../classes/_includes.php';

use EVE\App;
use EVE\Provider\Gitea;

App::run(Gitea::class);
