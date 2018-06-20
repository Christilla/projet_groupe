<?php
// Demarre la session
session_start();
var_dump($_SESSION);
// import de la classe Routing ( pour l'utiliser)
use BWB\Framework\mvc\Routing;
// pour beneficier de l'autoload de composer
include "vendor/autoload.php";

// A chaque requete emise nous lançons le mecanisme de routage
(new Routing())->execute();
