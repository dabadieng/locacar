<?php
const MODE_PROD=false;
session_start();
const DB_SERVER = "localhost";
const DB_NAME = "baselocacar";
const DB_USER = "root";
const DB_PWD="";
//création d'un object connexion 
$link = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER,DB_PWD);
//définit le charset pour les échanges de données avec le serveur de BDD
$link->exec("SET CHARACTER SET UTF8");
//Définit le mode de la méthode fetch par défaut
$link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//déclenche une exception en cas d'erreur : stop l'éxécution
$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$nomApplication = "LocaCar";
$menu=array(
    ["creerdatabase.php","RAZ BDD"],
    ["dataset.php","jeu de données"]
);

require "inc_fonction.php";

// liste des départements 
$departement = "
INSERT INTO departement VALUES (null,'01', 'Ain');
INSERT INTO departement VALUES (null,'02', 'Aisne');
INSERT INTO departement VALUES (null,'03', 'Allier');
INSERT INTO departement VALUES (null,'04', 'Alpes-de-Haute-Provence');
INSERT INTO departement VALUES (null,'05', 'Hautes-Alpes');
INSERT INTO departement VALUES (null,'06', 'Alpes-Maritimes');
INSERT INTO departement VALUES (null,'07', 'Ardèche');
INSERT INTO departement VALUES (null,'08', 'Ardennes');
INSERT INTO departement VALUES (null,'09', 'Ariège');
INSERT INTO departement VALUES (null,'10', 'Aube');
INSERT INTO departement VALUES (null,'11', 'Aude');
INSERT INTO departement VALUES (null,'12', 'Aveyron');
INSERT INTO departement VALUES (null,'13', 'Bouches-du-Rhône');
INSERT INTO departement VALUES (null,'14', 'Calvados');
INSERT INTO departement VALUES (null,'15', 'Cantal');
INSERT INTO departement VALUES (null,'16', 'Charente');
INSERT INTO departement VALUES (null,'17', 'Charente-Maritime');
INSERT INTO departement VALUES (null,'18', 'Cher');
INSERT INTO departement VALUES (null,'19', 'Corrèze');
INSERT INTO departement VALUES (null,'2A', 'Corse-du-Sud');
INSERT INTO departement VALUES (null,'2B', 'Haute-Corse');
INSERT INTO departement VALUES (null,'21', 'Côte-d\'Or');
INSERT INTO departement VALUES (null,'22', 'Côtes-d\'Armor');
INSERT INTO departement VALUES (null,'23', 'Creuse');
INSERT INTO departement VALUES (null,'24', 'Dordogne');
INSERT INTO departement VALUES (null,'25', 'Doubs');
INSERT INTO departement VALUES (null,'26', 'Drôme');
INSERT INTO departement VALUES (null,'27', 'Eure');
INSERT INTO departement VALUES (null,'28', 'Eure-et-Loir');
INSERT INTO departement VALUES (null,'29', 'Finistère');
INSERT INTO departement VALUES (null,'30', 'Gard');
INSERT INTO departement VALUES (null,'31', 'Haute-Garonne');
INSERT INTO departement VALUES (null,'32', 'Gers');
INSERT INTO departement VALUES (null,'33', 'Gironde');
INSERT INTO departement VALUES (null,'34', 'Hérault');
INSERT INTO departement VALUES (null,'35', 'Ille-et-Vilaine');
INSERT INTO departement VALUES (null,'36', 'Indre');
INSERT INTO departement VALUES (null,'37', 'Indre-et-Loire');
INSERT INTO departement VALUES (null,'38', 'Isère');
INSERT INTO departement VALUES (null,'39', 'Jura');
INSERT INTO departement VALUES (null,'40', 'Landes');
INSERT INTO departement VALUES (null,'41', 'Loir-et-Cher');
INSERT INTO departement VALUES (null,'42', 'Loire');
INSERT INTO departement VALUES (null,'43', 'Haute-Loire');
INSERT INTO departement VALUES (null,'44', 'Loire-Atlantique');
INSERT INTO departement VALUES (null,'45', 'Loiret');
INSERT INTO departement VALUES (null,'46', 'Lot');
INSERT INTO departement VALUES (null,'47', 'Lot-et-Garonne');
INSERT INTO departement VALUES (null,'48', 'Lozère');
INSERT INTO departement VALUES (null,'49', 'Maine-et-Loire');
INSERT INTO departement VALUES (null,'50', 'Manche');
INSERT INTO departement VALUES (null,'51', 'Marne');
INSERT INTO departement VALUES (null,'52', 'Haute-Marne');
INSERT INTO departement VALUES (null,'53', 'Mayenne');
INSERT INTO departement VALUES (null,'54', 'Meurthe-et-Moselle');
INSERT INTO departement VALUES (null,'55', 'Meuse');
INSERT INTO departement VALUES (null,'56', 'Morbihan');
INSERT INTO departement VALUES (null,'57', 'Moselle');
INSERT INTO departement VALUES (null,'58', 'Nièvre');
INSERT INTO departement VALUES (null,'59', 'Nord');
INSERT INTO departement VALUES (null,'60', 'Oise');
INSERT INTO departement VALUES (null,'61', 'Orne');
INSERT INTO departement VALUES (null,'62', 'Pas-de-Calais');
INSERT INTO departement VALUES (null,'63', 'Puy-de-Dôme');
INSERT INTO departement VALUES (null,'64', 'Pyrénées-Atlantiques');
INSERT INTO departement VALUES (null,'65', 'Hautes-Pyrénées');
INSERT INTO departement VALUES (null,'66', 'Pyrénées-Orientales');
INSERT INTO departement VALUES (null,'67', 'Bas-Rhin';
INSERT INTO departement VALUES (null,'68', 'Haut-Rhin';
INSERT INTO departement VALUES (null,'69', 'Rhône');
INSERT INTO departement VALUES (null,'70', 'Haute-Saône');
INSERT INTO departement VALUES (null,'71', 'Saône-et-Loire');
INSERT INTO departement VALUES (null,'72', 'Sarthe');
INSERT INTO departement VALUES (null,'73', 'Savoie');
INSERT INTO departement VALUES (null,'74', 'Haute-Savoie');
INSERT INTO departement VALUES (null, '75','Paris');
INSERT INTO departement VALUES (null,'76', 'Seine-Maritime');
INSERT INTO departement VALUES (null,'77', 'Seine-et-Marne');
INSERT INTO departement VALUES (null,'78', 'Yvelines');
INSERT INTO departement VALUES (null,'79', 'Deux-Sèvres');
INSERT INTO departement VALUES (null,'80', 'Somme');
INSERT INTO departement VALUES (null,'81', 'Tarn');
INSERT INTO departement VALUES (null,'82', 'Tarn-et-Garonne');
INSERT INTO departement VALUES (null,'83', 'Var');
INSERT INTO departement VALUES (null,'84', 'Vaucluse');
INSERT INTO departement VALUES (null,'85', 'Vendée');
INSERT INTO departement VALUES (null,'86', 'Vienne');
INSERT INTO departement VALUES (null,'87', 'Haute-Vienne');
INSERT INTO departement VALUES (null,'88', 'Vosges');
INSERT INTO departement VALUES (null,'89', 'Yonne');
INSERT INTO departement VALUES (null,'90', 'Territoire de Belfort');
INSERT INTO departement VALUES (null,'91', 'Essonne');
INSERT INTO departement VALUES (null,'92', 'Hauts-de-Seine');
INSERT INTO departement VALUES (null,'93', 'Seine-Saint-Denis');
INSERT INTO departement VALUES (null,'94', 'Val-de-Marne');
INSERT INTO departement VALUES (null,'95', 'Val-d\'Oise');';
"; 

