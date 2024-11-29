CREATE DATABASE note_releve;
\c note_releve;

CREATE TABLE semestre
(
    semestre_id SERIAL,
    libelle     VARCHAR(50),
    PRIMARY KEY (semestre_id)
);
CREATE TABLE matiere
(
    matiere_id   SERIAL,
    code_matiere VARCHAR(50),
    semestre_id  INT NOT NULL,
    intitule     VARCHAR(100),
    credits      INT,
    coefficient  INT,
    PRIMARY KEY (matiere_id),
    FOREIGN KEY (semestre_id) REFERENCES semestre (semestre_id)
);



CREATE TABLE etudiant
(
    etudiant_id    SERIAL,
    prenom         VARCHAR(50),
    nom            VARCHAR(50),
    date_naissance DATE,
    PRIMARY KEY (etudiant_id)
);

CREATE TABLE note
(
    note_id     SERIAL,
    note        DECIMAL(15, 2),
    matiere_id  INT NOT NULL,
    etudiant_id INT NOT NULL,
    PRIMARY KEY (note_id),
    FOREIGN KEY (matiere_id) REFERENCES matiere (matiere_id),
    FOREIGN KEY (etudiant_id) REFERENCES etudiant (etudiant_id)
);
