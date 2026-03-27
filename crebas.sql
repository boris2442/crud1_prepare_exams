/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  27/03/2026 14:37:10                      */
/*==============================================================*/


drop table if exists MODELES;

drop table if exists POSSEDER;

drop table if exists PROPRIETAIRES;

drop table if exists VEHICULES;

/*==============================================================*/
/* Table : MODELES                                              */
/*==============================================================*/
create table MODELES
(
   MODELE_ID            int not null,
   LIBELLE              char(255),
   primary key (MODELE_ID)
);

/*==============================================================*/
/* Table : POSSEDER                                             */
/*==============================================================*/
create table POSSEDER
(
   VEHICULE_ID          int not null,
   PROPRIETAIRES_ID     int not null,
   primary key (VEHICULE_ID, PROPRIETAIRES_ID)
);

/*==============================================================*/
/* Table : PROPRIETAIRES                                        */
/*==============================================================*/
create table PROPRIETAIRES
(
   PROPRIETAIRES_ID     int not null,
   NOM                  char(255),
   PRENOM               char(255),
   CONTACT              char(255),
   primary key (PROPRIETAIRES_ID)
);

/*==============================================================*/
/* Table : VEHICULES                                            */
/*==============================================================*/
create table VEHICULES
(
   VEHICULE_ID          int not null,
   MODELE_ID            int not null,
   DATE_IMMATRICULATION datetime,
   COULEUR              char(255),
   primary key (VEHICULE_ID)
);

alter table POSSEDER add constraint FK_POSSEDER foreign key (PROPRIETAIRES_ID)
      references PROPRIETAIRES (PROPRIETAIRES_ID) on delete restrict on update restrict;

alter table POSSEDER add constraint FK_POSSEDER2 foreign key (VEHICULE_ID)
      references VEHICULES (VEHICULE_ID) on delete restrict on update restrict;

alter table VEHICULES add constraint FK_APPARTENIR foreign key (MODELE_ID)
      references MODELES (MODELE_ID) on delete restrict on update restrict;

