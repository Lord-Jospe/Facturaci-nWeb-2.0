<?php
session_start();
session_destroy();

header("Location: ../../index.html"); // Redirigir con parámetro de error
