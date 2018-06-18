#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: t-User
#------------------------------------------------------------

CREATE TABLE t_User(
        idUser      Int  Auto_increment  NOT NULL ,
        useName     Varchar (20) NOT NULL ,
        usePassword Varchar (20) NOT NULL
	,CONSTRAINT t_User_PK PRIMARY KEY (idUser)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_mandate
#------------------------------------------------------------

CREATE TABLE t_mandate(
        idMandate    Int  Auto_increment  NOT NULL ,
        manName      Varchar (50) NOT NULL ,
        manStartDate Date NOT NULL ,
        manEndDate   Date NOT NULL ,
        manComment   Varchar (255) NOT NULL ,
        idUser       Int NOT NULL
	,CONSTRAINT t_mandate_PK PRIMARY KEY (idMandate)

	,CONSTRAINT t_mandate_t_User_FK FOREIGN KEY (idUser) REFERENCES t_User(idUser)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_worktime
#------------------------------------------------------------

CREATE TABLE t_worktime(
        idWorktime   Int  Auto_increment  NOT NULL ,
        worStartTime Datetime NOT NULL ,
        worEndTime   Datetime NOT NULL ,
        worComment   Varchar (255) NOT NULL ,
        idMandate    Int NOT NULL
	,CONSTRAINT t_worktime_PK PRIMARY KEY (idWorktime)

	,CONSTRAINT t_worktime_t_mandate_FK FOREIGN KEY (idMandate) REFERENCES t_mandate(idMandate)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: t_image
#------------------------------------------------------------

CREATE TABLE t_image(
        idImage   Int  Auto_increment  NOT NULL ,
        imgPath   Varchar (50) NOT NULL ,
        idMandate Int NOT NULL
	,CONSTRAINT t_image_PK PRIMARY KEY (idImage)

	,CONSTRAINT t_image_t_mandate_FK FOREIGN KEY (idMandate) REFERENCES t_mandate(idMandate)
)ENGINE=InnoDB;

