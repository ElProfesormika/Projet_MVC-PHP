-- =================================================================
-- Base SOUTENANCES version 4
-- Marc LEMERCIER, le 3-25 avril 2025
-- =================================================================


-- =================================================================
-- table personne
-- =================================================================

create table if not exists personne (
 id integer unsigned not null,
 nom varchar(40) not null,
 prenom varchar(40) not null,
 role_responsable boolean,
 role_examinateur boolean,
 role_etudiant boolean,
 login varchar(20) unique not null,
 password varchar(20) not null,
 primary key (id) 
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;


-- =================================================================
-- table projet
-- =================================================================

create table if not exists projet (
 id integer unsigned not null,
 label varchar(60) not null,
 responsable integer unsigned not null,
 groupe integer unsigned not null,  
 primary key (id),
 foreign key (responsable) references personne(id) on delete cascade 
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

-- =================================================================
-- table creneaux
-- =================================================================

create table if not exists creneau (
 id integer unsigned not null,
 projet integer unsigned not null,
 examinateur integer unsigned not null,
 creneau datetime,
 primary key (id),
 foreign key (projet) references projet(id) on delete cascade,
 foreign key (examinateur) references personne(id) on delete cascade 
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

-- format de la date : '2000Ò-01-01 00:00:00'

-- =================================================================
-- table des rdv
-- =================================================================

create table if not exists rdv (
id integer unsigned not null,
creneau  integer unsigned not null,
etudiant integer unsigned not null, 
primary key (id),
foreign key (creneau) references creneau(id) on delete cascade, 
foreign key (etudiant) references personne(id) on delete cascade 
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;