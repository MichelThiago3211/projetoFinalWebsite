<?php

// Usado pelo JavaScript, caso ele precise acessar o valor de uma variável de ambiente
include "env.php";
echo $_ENV[$_GET["var"]];