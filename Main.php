<?php
include("Tabla.php");


$columns = array("Nombre" => "35", "Apellido" => "37", "Telefono" => "15");
$myTable = new Tabla("Contactos", $columns);
$myTable->addData(array("Nombre" => "Daniel", "Apellido" => "Vargas", "Telefono" => "3007682141"));
$myTable->addData(array("Nombre" => "Pedro", "Apellido" => "Gómez", "Telefono" => "3007682141"));
$myTable->addData(array("Nombre" => "Juan", "Apellido" => "Vargas", "Telefono" => "3007682141"));
$myTable->addData(array("Nombre" => "Santiago", "Apellido" => "Vargas", "Telefono" => "3007682141"));
$myTable->getContactByColumnName("Nombre", "Daniel");
$myTable->getAllContacts();
//$myTable->deleteAllContacts();
$myTable->deleteContactByFullName(array("Nombre" => "Daniel", "Apellido" => "Vargas"));
$myTable->changeContactInfo(array("Nombre" => "Santiago"), array("Nombre" => "Geronimo", "Apellido" => "Gonzalez"));

$myTable->getAllContacts();
