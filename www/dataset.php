<?php

//composer require fzaninotto/faker
require "../_include/inc_config.php";
require_once '../vendor/autoload.php';
// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create("fr_FR");


?>
<!DOCTYPE html>
<html>

<head>
    <?php require "../_include/inc_head.php" ?>
</head>

<body>
    <header>
        <?php require "../_include/inc_entete.php" ?>
    </header>
    <nav>
        <?php require "../_include/inc_menu.php"; ?>
    </nav>
    <div id="contenu">
        <pre>
        <?php
        //création des départements 
        echo "<h1>Création des départements</h1>";
        $link->query($departement);

        // création des agences 
        echo "<h1>Création des agences</h1>";
        $sql = "insert into agence values ";
        $nbagence = 20;
        $data = [];
        for ($i = 1; $i <= $nbagence; $i++) {
            $nom = $faker->company;
            $age_departement = rand(1, 67);
            $data[] = "(null,'Agence $nom','$age_departement')";
        }
        $link->query($sql . implode(",", $data));


        //création de la table options ( id   (pk), type, tarif )
        echo "<h1>Création des options </h1>";
        $sql = "insert into options  values ";
        $data = [];
        $nombreOption = 6;
        $option = [];
        $indice = 1;
        $listeOption = array("climatisation" => 10, "GPS" => 7, "pneus neige" => 23, "lecteur video" => 5, "minibar" => 15);
        foreach ($listeOption as  $opt_type => $opt_tarif_en_euro) {
            $option[] = $indice++;
            $data[] = "(null,'$opt_type','$opt_tarif_en_euro')";
        }
        $link->query($sql . implode(",", $data));


        //création de la table client ( id   (pk), nom, login, MP, adresse, CP, Ville )
        $nombreClient = 200;

        //création de la table client ( id   (pk), nom, login, MP, adresse, CP, Ville )
        echo "<h1>Création des clients </h1>";

        $sql = "insert into client  values ";
        $data = [];
        $nombreClient = 200;
        for ($i = 1; $i <= $nombreClient; $i++) {
            $nom = $faker->name;                // nom d'un client
            $cli_login = $faker->email;         // login
            $cli_adresse = $faker->address;     //adresses
            $cli_ville = $faker->city;          //villes
            $mot_de_passe = password_hash($i, PASSWORD_DEFAULT);   //crypter le mot de passe
            $data[] = "(null,'$nom','$cli_login',' $mot_de_passe','$cli_adresse','code_postal $i','$cli_ville')";
        }
        $link->query($sql . implode(",", $data));


        echo "<h1>Création des catégories </h1>";
        $sql = "insert into categorie  values ";
        $data = [];
        $categorie = array("petit", "moyen", "grand", "utilitaire", "prestige", "camping car");
        foreach ($categorie as $cle => $valeur) {
            $data[] = "(null,'$valeur')";
        }
        $link->query($sql . implode(",", $data));

        // création des véhicules 
        echo "<h1>création des véhiculees</h1>";
        /* ordre des chanps de la tables vehicules 
         id / immatriculation / marque / appartient_agence  / catégorie / localisation 
        */
        $sql = "insert into vehicule values ";
        $nbvehicule = 200;
        $marque = array("Ford", "Lexus", "Toyota", "Mazda", "Mercedes-Benz", "Porsche", "Honda");
        $nbmarque = count($marque);
        $nbcateg = count($categorie);
        $data = [];

        for ($i = 1; $i < $nbvehicule; $i++) {
            $veh_immatriculation = strtoupper($faker->bothify('##???##'));
            $hasard_marque = rand(0, $nbmarque - 1);
            $veh_marque = $marque[$hasard_marque];
            $veh_categorie = rand(1, $nbcateg);
            $veh_appartient_agence = rand(1, 20);
            $veh_localiser_agence = rand(1, 20);
            $data[] = "(null,'$veh_immatriculation','$veh_marque','$veh_appartient_agence', '$veh_categorie', '$veh_localiser_agence')";
        }
        $link->query($sql . implode(",", $data));


        //création de la table operarteur  ( id   (pk), ope_nom, ope_login,ope_mp, ope_profil )
        echo "<h1>Création des operateur des agences </h1>";
        $sql = "insert into operateur  values ";
        $data = [];
        for ($i = 1; $i <= $nbagence; $i++) {
            for ($j = 1; $j < 3; $j++) {
                $ope_nom = $faker->name;                // nom d'un client
                $ope_login = $faker->email;         // login
                $ope_mp = password_hash($i, PASSWORD_DEFAULT);   //crypter le mot de passe
                $ope_profil = "gestionnaire";
                $data[] = "(null,' $ope_nom','$cli_login',' $ope_mp ','$ope_profil','$i')";
            }
        }
        $link->query($sql . implode(",", $data));


        echo "<h1>Création des opérateurs du SRC</h1>";
        $nbOpeSrc = 10;
        for ($i = 1; $i <= $nbOpeSrc; $i++) {
            for ($j = 1; $j < 3; $j++) {
                $ope_nom = $faker->name;                // nom d'un client
                $ope_login = $faker->email;         // login
                $ope_mp = password_hash($i, PASSWORD_DEFAULT);   //crypter le mot de passe
                $ope_profil = "src";
                $data[] = "(null,' $ope_nom','$cli_login',' $ope_mp ','$ope_profil',null)";
            }
        }

        $link->query($sql . implode(",", $data));

        // création de la table des locations
        /* les champs dans l'ordre déclarés
        id, , date demande, date/heure début, date/heure fin, status, agence depart
        agence arrivéé, vehicule, client, operateur, date mise a jour, type reservation
        */
        $sql = "insert into location  values ";
        $data = [];
        echo "<h1>Création de la table location</h1>";
        $status = array("initialiser", "en cours", "valider");
        $typeresa = array("tel", "ligne", "agence");
        $nblocation = 200;
        for ($i = 1; $i <= $nblocation; $i++) {
            $datedemande = mktime(rand(0, 23), rand(0, 59), 0, rand(1, 12), rand(1, 30), 2019);
            $debut = $datedemande + rand(1, 3) * 24 * 60 * 60;
            $fin = $debut + rand(15, 60) * 24 * 60 * 60;

            // formatage des dates
            $datedemande = date("Y-m-d", $debut);
            $debut = date("Y-m-d-H-i-s", $debut);
            $fin = date("Y-m-d-H-i-s", $fin);

            shuffle($status);
            $locstatus = $status[0];

            $loc_agence_depart = rand(1, $nbagence);
            $loc_agence_arrivee = rand(1, $nbagence);
            $loc_vehicule = rand(1, $nbvehicule);
            $client = rand(1, $nombreClient);
            $loc_operateur = rand(1, 50);
            $dateMaj = $debut;

            shuffle($typeresa);
            $loc_type = $typeresa[0];
            $data[] = "(null,'$datedemande','$debut','$fin','$locstatus','$loc_agence_depart','$loc_agence_arrivee','$loc_vehicule','$client','$loc_operateur','$dateMaj','$loc_type')";
        }
        $link->query($sql . implode(",", $data));

        // création de la table plage horaire 
        // id, duree min, duréé max
        echo "<h1>Création table plage_horaire</h1>";
        $sql = "insert into plage_horaire values(null, 0, 11),(null,12,23),(null,24,7200)";
        $link->query($sql);


        // création de la table definir 
        // id, prix, plage horaire, categorie 
        echo "<h1>Création de la table definir</h1>";
        $sql =  "
        insert into definir values 
        (null, 1, 1, 8),(null, 1, 2, 7),(null, 1, 3, 6),
        (null, 2, 1,10),(null, 2,2,9), (null, 2, 3, 8),
        (null, 3, 1, 14), (null, 3, 2, 12), (null, 3, 3, 10), 
        (null, 4, 1, 6), (null, 4, 2, 5), (null,4,3,4),
        (null,5,1,27), (null, 5,2,24), (null,5,3,20),
        (null,6,1,35), (null,6,2,34), (null,6,3,30)
        ";
        $link->query($sql);



        // création de la table equipement
        // id, location, option
        echo "<h1>Créaation de la table equipement</h1>";
        $data = [];
        $sql = "insert into equipement values";
        for ($i = 1; $i <= $nblocation; $i++) {
            $a = rand(0, 5);
            if ($a >= 1) {
                shuffle($option);
                for ($l = 0; $l < $a; $l++) {
                    $equ_option = $option[$l];
                    $data[] = "(null,' $i',$equ_option)";
                }
            }else{
                $data[] = "(null,' $i',null)";
            }
        }


        $link->query($sql . implode(",", $data));

        ?>
        

        </pre>
    </div>
    <hr>
    <footer>
        <?php require "../_include/inc_pied.php"; ?>
    </footer>
</body>

</html>