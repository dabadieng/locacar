
-- 1 Liste des agences avec le nombre de véhicules présents.
    select age_id, age_nom, count(veh_id) nombre_véhicules
    from agence, vehicule 
    where veh_localiser_agence=age_id
    group by age_id; 

-- 2 Liste des véhicules par agence.
    select veh_id, veh_immatriculation, age_id, age_nom
    from vehicule,agence
    where veh_appartient_agence=age_id
    order by age_id;

-- 3 Liste des locations par statut pour une agence donnée.
    select loc_id, loc_statut, age_nom
    from agence, location 
    where age_id=loc_agence_depart and loc_agence_depart=1
    group by loc_id, loc_statut; 

-- 4 Liste des locations entre 2 dates données pour une agence donnée.
    -- date1 = '2019-08-15' , date2= '2019-08-15', idagence=1
    select loc_id, loc_agence_depart,loc_date_heure_debut, loc_date_heure_fin
    from location
    where '2019-08-01-00-00-00'>=loc_date_heure_debut and '2019-09-01-00-00-00'<=loc_date_heure_fin
    and loc_agence_depart=1; 

-- 5 Nombre de locations par agence et par statut.
    select loc_id,loc_agence_depart, loc_statut, count(loc_id) nombre
    from location
    group by loc_agence_depart, loc_statut; 

-- 6 Liste des agences par département.
    select*
    from agence
    group by age_departement; 

-- 7 Chiffre d’affaire d’une agence donnée.

    -- vue donnant le nombre d'heures pour une location donnée 
    create or replace view loc_duree as
    select loc_id,loc_date_heure_debut,loc_date_heure_fin, timestampdiff(hour, loc_date_heure_debut, loc_date_heure_fin) duree 
    from location;

    -- vue donnant le prix de la location hors options :
    create or replace view loc_prix as 
    select loc_id, def_prix*duree prixHorsOptions
    from loc_duree, plage_horaire, definir, categorie
    where cat_id=def_categorie  
    and pla_id=def_plage_horaire 
    and duree between pla_duree_min and pla_duree_max;

    --vue donnant le prix des options par location 
    create or replace view loc_option as
    select  equ_location, sum(opt_tarif) prixopt 
    from options, equipement, location 
    where equ_options=opt_id and equ_location=loc_id
    group by loc_id;

    -- requête 
    select loc_id, age_id, age_nom, sum(prixHorsOptions + prixopt) total
    from loc_option, loc_prix, agence
    where equ_location=loc_id
    and age_id = 1; 



-- 8 Requête donnant la durée (en nombre d’heures) d’une location.
    select loc_id,loc_date_heure_debut,loc_date_heure_fin, timestampdiff(hour, loc_date_heure_debut, loc_date_heure_fin) duree 
    from location
    where loc_id=1; 

-- 9 Liste les véhicules libres dans une agence donnée et entre deux dates données. 
    select age_id, age_nom, veh_id, veh_immatriculation, veh_localiser_agence
    from vehicule, agence 
    where veh_localiser_agence=age_id and veh_localiser_agence=2 and veh_id not in 
    (select loc_vehicule 
    from location
    where (loc_date_heure_debut<'2019-02-01' 
    and loc_date_heure_fin>'2019-03-01')); 

-- 10 Requête donnant le prix d’une location (hors options sur le véhicule).
    create or replace view loc_duree as 
    select loc_id, cat_id, cat_nom, timestampdiff(hour, loc_date_heure_debut, loc_date_heure_fin) duree 
    from location, vehicule, categorie 
    where loc_vehicule=veh_id and veh_categorie=cat_id; 

    -- requette
    select loc_id, def_prix*duree prix 
    from loc_duree, plage_horaire, definir 
    where cat_id=def_categorie  
    and pla_id=def_plage_horaire 
    and duree between pla_duree_min and pla_duree_max;


-- 11 Requête donnant le montant total des options attachées à chaque véhicule.
    create or replace view loc_option as
    select  equ_location, veh_immatriculation, veh_marque, sum(opt_tarif) prixopt 
    from options, equipement, location, vehicule 
    where equ_options=opt_id and equ_location=loc_id and veh_id=loc_vehicule
    group by veh_id;

    -- requête
    select  equ_location, veh_immatriculation, veh_marque, sum(opt_tarif) prixopt 
    from options, equipement, location, vehicule 
    where equ_options=opt_id and equ_location=loc_id and veh_id=loc_vehicule
    group by veh_id;
