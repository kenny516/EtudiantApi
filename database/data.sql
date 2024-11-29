-- Insérer des semestres
INSERT INTO semestre (libelle)
VALUES ('Semestre 1'),
       ('Semestre 2');
INSERT INTO matiere (code_matiere,intitule, credits, coefficient, semestre_id)
VALUES ('MATH101', 'Mathématiques I', 3, 2, 1),
       ('INFO101', 'Introduction à linformatique', 3, 3, 1),
       ('PHY101', 'Physique I', 4, 3, 2),
       ('CHIM101', 'Chimie I', 3, 2, 2);



DO
$$
    DECLARE
        prenoms        TEXT[] := ARRAY [
            'Jean', 'Marie', 'Alice', 'Bob', 'Clément', 'Lucas', 'Sophie', 'Julien', 'Charlotte', 'Antoine', 'Léo', 'Emma', 'Chloé', 'Hugo', 'Isabelle', 'Pierre', 'Léa', 'Michaël', 'Paul', 'Rakoto', 'Rajaonarivelo', 'Tiana', 'Mamy', 'Nivo', 'Hery', 'Voahirana', 'Andriamanitra', 'Fidy', 'Aina', 'Miora', 'Hanta', 'Mialy', 'Tahina', 'Rindra', 'Hery', 'Hélia', 'Nirina', 'Aloys', 'Faly', 'Zo', 'Kanto', 'Rija', 'Mamy', 'Sitraka', 'Lova', 'Ando', 'Liva', 'Rasoa', 'Faniry', 'Raveloson', 'Aina', 'Mahery', 'Samy', 'Tsy', 'Bodo', 'Mialy', 'Sandy', 'Charly', 'Tito', 'Joaquim', 'Kely', 'Bera', 'Vola', 'Rija', 'Manjaka', 'Vénus', 'Thérèse', 'Paulin', 'Tovona', 'Héry', 'Mamy', 'Ihorombe', 'Vincent', 'Raza', 'Meva', 'Rado', 'Riana', 'Miara', 'Mialy', 'Fidy', 'Tina', 'Hanta', 'Lanto', 'Ialy', 'Soa', 'Liva', 'Vololona', 'Narindra', 'Vary', 'Harisoa', 'Sandro', 'Ny', 'Sandrine', 'Sacha', 'Jouan', 'Esther', 'Aloe', 'Avelina', 'Mia', 'Henriette', 'Faly', 'Clémence', 'Anja', 'Nyva', 'Juno', 'Boris', 'Benoit', 'Rivo', 'Joëlle', 'Henri', 'Kary', 'Miora', 'Roland', 'Albertine', 'Lala', 'Kahina', 'Jeanine', 'Davi', 'Elsa', 'Karine', 'Dina', 'Tera', 'Tiana', 'Tia', 'Sao', 'Tovohery', 'Izay', 'Aska', 'Shaza', 'Vola', 'Estelle', 'Lucie', 'Diana', 'Irina', 'Sitraka', 'Bahar', 'Lava', 'Sefa', 'Kely', 'Lalao', 'Soleil', 'Gilbert', 'Manitra', 'Fahefa', 'Nirina', 'Aina', 'Miarisoa', 'Marilyn', 'Hugues', 'Tovo', 'Irensia', 'Fanitra', 'Rakana', 'Fanja', 'Géraldine', 'Alvina', 'Rita', 'Onja', 'Soanala', 'Vahina', 'Nyoto', 'Rivo', 'Poul', 'Mila', 'Fahavalo', 'Hilda', 'Manelisoa', 'Boni', 'Razafy', 'Sissy', 'Alexandra', 'Nadia', 'Mamy', 'Jean-Claude', 'Harisoa', 'Miona', 'Lucienne', 'Valisoa', 'Nirina', 'Mely', 'Jazira', 'Ravela', 'Miarantsoa', 'Kariz', 'Andrana', 'Erick', 'Gérald', 'Fahema', 'Monique', 'Hervé', 'Gaby', 'Jacqueline', 'Lucette', 'Bruno', 'Mosa', 'Arline', 'Nirindra', 'Jocelyne', 'Valencia', 'Dunia', 'Yasmina', 'Aymen', 'Irina', 'Lova', 'Lindsey', 'Tanya', 'Nisa', 'Luciana', 'Vera', 'Nathalie', 'Tiana'
            ];
        noms           TEXT[] := ARRAY [
            'Dupont', 'Lemoine', 'Martin', 'Leclerc', 'Durand', 'Lefevre', 'Robert', 'Berger', 'Moreau', 'Leclerc', 'Sanchez', 'Girard', 'Benoit', 'Boucher', 'Dufresne', 'Joubert', 'Blanc', 'Rabe', 'Andriamihaja', 'Raharimampionona', 'Raveloson', 'Rasolonjatovo', 'Razafindrakoto', 'Raharisoa', 'Rakotomalala', 'Razanadrakoto', 'Ranaivo', 'Ravaonirina', 'Rakotonirina', 'Raza', 'Ranarison', 'Raveloarison', 'Ramaroson', 'Rado', 'Tsara', 'Randriamihaja', 'Tsiory', 'Lova', 'Rakotondramanana', 'Harisoa', 'Razanadrakoto', 'Raobelina', 'Ravelo', 'Raveloarison', 'Haja', 'Tina', 'Rivo', 'Mivo', 'Dine', 'Andriambelo', 'Miarisoa', 'Rakotoharivelo', 'Tanjona', 'Ramiarison', 'Alisoa', 'Avo', 'Tsiahafina', 'Mivo', 'Razanamahasoa', 'Harivelo', 'Rakotonirina', 'Ralalao', 'Sitra', 'Hery', 'Vary', 'Rado', 'Jao', 'Benz', 'Rakotory', 'Razafindramanja', 'Tifisoa', 'Vahimalala', 'Manandafy', 'Hajaina', 'Maherisoa', 'Ratsimandresy', 'Rakotozafy', 'Lalaina', 'Raharilala', 'Ralaivola', 'Jacques', 'Mamy', 'Ratsimbarison', 'Bera', 'Ramarosoa', 'Madagasikara', 'Raveloarison', 'Mirana', 'Hélio', 'Reo', 'Nomena', 'Bourguet', 'Roger', 'Ralahimbola', 'Valisoa', 'Ravo', 'Mijoro', 'Irana', 'Mamisoa', 'Ratsimbazafy', 'Mampi', 'Adama', 'Tahina', 'Rabemananjara', 'Ravelo', 'Mahery', 'Voahangy', 'Fedy', 'Maminirina', 'Rabe', 'Lala', 'Volaha', 'Nirina', 'Hassani', 'Ravelo', 'Harivola', 'Heriniaina', 'Ramarosa', 'Avo', 'Rasolondranto', 'Taolovino', 'Sitraka', 'Mialy', 'Madjer', 'Sy', 'Tsiory', 'Mahara', 'Izaho', 'Lazaina', 'Manandaza', 'Lova', 'Dera', 'Rado', 'Miara', 'Laza', 'Razafy', 'Heriniaina', 'Vahinala', 'Raharisoa', 'Mivo', 'Dera', 'Olivier', 'Sera', 'Raingo', 'Tahina', 'Fandresena', 'Eugène', 'Ravoniaina', 'Raphaël', 'Lyrid', 'Viny', 'Sitraka', 'Faniry', 'Tahirinanto'
            ];
        i              INT;
        date_naissance DATE;
    BEGIN
        FOR i IN 1..27756
            LOOP -- Générer 1 million d'étudiants
        -- Générer une date de naissance aléatoire entre 1990 et 2005
                date_naissance := CURRENT_DATE - (FLOOR(RANDOM() * (365 * 30))) * INTERVAL '1 day';

                -- Insérer un étudiant avec un prénom, un nom malgache et une date de naissance aléatoire
                INSERT INTO etudiant (prenom, nom, date_naissance)
                VALUES (prenoms[(FLOOR(RANDOM() * array_length(prenoms, 1)) + 1)],
                        noms[(FLOOR(RANDOM() * array_length(noms, 1)) + 1)],
                        date_naissance);
            END LOOP;
    END
$$;


-- Fonction pour générer toutes les notes des étudiants pour chaque matière et semestre
DO
$$
DECLARE
    v_note     DECIMAL(15, 2);
    v_etudiant RECORD;
    v_matiere  RECORD;
BEGIN
    FOR v_etudiant IN
        SELECT id FROM etudiant
    LOOP
        FOR v_matiere IN
            SELECT id FROM matiere
        LOOP
            v_note := ROUND(CAST(RANDOM() * (20 - 0) + 0 AS NUMERIC), 2);

            INSERT INTO note (note, matiere_id, etudiant_id)
            VALUES (v_note, v_matiere.id, v_etudiant.id);
        END LOOP;
    END LOOP;
END
$$;

