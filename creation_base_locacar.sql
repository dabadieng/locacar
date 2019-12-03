-- base de donn�es: 'baselocacar'
--
create database if not exists baselocacar default character set utf8 collate utf8_general_ci;
use baselocacar;
-- --------------------------------------------------------
-- creation des tables

set foreign_key_checks =0;

-- table agence
drop table if exists agence;
create table agence (
	age_id int not null auto_increment primary key,
	age_nom varchar(50) not null,
	age_departement int not null
)engine=innodb; 

-- table departement
drop table if exists departement;
create table departement (
	dep_id int not null auto_increment primary key,
	dep_code varchar(10) not null, 
	dep_nom varchar(50) not null
	
)engine=innodb; 

-- table location
drop table if exists location;
create table location (
	loc_id int not null auto_increment primary key,
	loc_date_demande datetime not null, 
	loc_date_heure_debut datetime not null,
	loc_date_heure_fin datetime not null,
	loc_statut varchar(50) not null,
	loc_agence_depart int not null,
	loc_agence_arrivee int not null,
	loc_vehicule int not null,
	loc_client int not null,
	loc_operateur int not null,
	loc_date_mise_a_jour datetime not null,
	loc_type_de_reservation varchar(255) not null
)engine=innodb;

-- table options
drop table if exists options;
create table options (
	opt_id int not null auto_increment primary key,
	opt_type varchar(50) not null,
	opt_tarif varchar(50) not null
)engine=innodb; 

-- table client
drop table if exists client;
create table client (
	cli_id int not null auto_increment primary key,
	cli_nom varchar(50) not null,
	cli_login varchar(50) not null,
	cli_mp varchar(500) not null,
	cli_adresse varchar(250) not null,
	cli_cp varchar(250) not null,
	cli_ville varchar(50) not null
)engine=innodb;

-- table vehicule
drop table if exists vehicule;
create table vehicule (
	veh_id int not null auto_increment primary key,
	veh_immatriculation varchar(255) not null,
	veh_marque varchar(255) not null,
	veh_appartient_agence int not null,
	veh_categorie int not null,
	veh_localiser_agence int not null
)engine=innodb; 

-- table categorie
drop table if exists categorie;
create table categorie (
	cat_id int not null auto_increment primary key,
	cat_nom varchar(255) not null
)engine=innodb; 

-- table operateur
drop table if exists operateur;
create table operateur (
	ope_id int not null auto_increment primary key,
	ope_nom varchar(50) not null,
	ope_login varchar(50) not null,
	ope_mp varchar(500) not null,
	ope_profil varchar(250) not null,
	ope_agence int 
)engine=innodb;


-- table type_de_reservation
drop table if exists type_de_reservation;
create table type_de_reservation (
	tdr_id int not null auto_increment primary key,
	tdr_tel varchar(255),
	tdr_ligne varchar(255),
	tdr_agence varchar(255)
)engine=innodb;

-- table plage_horaire
drop table if exists plage_horaire;
create table plage_horaire (
	pla_id int not null auto_increment primary key,
	pla_duree_min int ,
	pla_duree_max int not null
)engine=innodb; 

-- table definir
drop table if exists definir;
create table definir (
	def_id int not null auto_increment primary key,
	def_categorie int not null,
	def_plage_horaire int not null,
	def_prix int not null

	
)engine=innodb; 

-- table equipement
drop table if exists equipement;
create table equipement (
	equ_id int not null auto_increment primary key,
	equ_location int,
	equ_options int
)engine=innodb; 



-- contraintes
alter table agence add constraint cs1 foreign key (age_departement) references departement(dep_id);
alter table location add constraint cs2 foreign key (loc_agence_depart) references agence(age_id);
alter table location add constraint cs3 foreign key (loc_agence_arrivee) references agence(age_id);
alter table location add constraint cs4 foreign key (loc_agence_vehicule) references vehicule(veh_id);
alter table location add constraint cs5 foreign key (loc_client) references client(cli_id);
alter table location add constraint cs6 foreign key (loc_operateur) references operateur(ope_id);
alter table location add constraint cs7 foreign key (loc_type_de_reservation) references location(loc_id);
alter table vehicule add constraint cs8 foreign key (veh_appartient_agence) references agence(age_id);
alter table vehicule add constraint cs9 foreign key (veh_categorie) references categorie(cat_id);
alter table vehicule add constraint cs10 foreign key (veh_localiser_agence) references agence(age_id);
alter table definir add constraint cs11 foreign key (def_plage_horaire) references plage_horaire(pla_id);
alter table definir add constraint cs12 foreign key (def_categorie) references categorie(cat_id);
alter table equipement add constraint cs13 foreign key (equ_location) references location(loc_id);
alter table equipement add constraint cs14 foreign key (equ_options) references options(opt_id);


set foreign_key_checks = 1;

-- jeu de données