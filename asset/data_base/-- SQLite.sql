-- SQLite
PRAGMA foreign_keys = ON;

/*DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS seances; 
DROP TABLE IF EXISTS resultats;
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    pseudo VARCHAR (50) NOT NULL,
    password VARCHAR (50) NOT NULL
);
CREATE TABLE seances (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    numbers SMALLINT,
    nom VARCHAR (50),
    qte_results INTEGER,
    users_id INTEGER,
    FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE
);
CREATE TABLE resultats (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    operation VARCHAR(150),
    result VARCHAR(20),
    date DATE ,
    seances_id INTEGER,
    FOREIGN KEY (seances_id) REFERENCES seances (id) ON DELETE CASCADE
);

INSERT INTO users (pseudo,password) VALUES 
                ("serge03","7777");
INSERT INTO seances (numbers,nom,qte_results,users_id) VALUES 
                    (1,"teste",1,1);
INSERT INTO resultats (operation,result,date,seances_id)VALUES
                      ("45+5","50","113531.10000014305",1);


INSERT INTO seances (numbers,nom,qte_results,users_id) VALUES 
                    (1,"teste2",1,2);
INSERT INTO resultats (operation,result,date,seances_id)VALUES
                      ("25/5","5","113531.10000014305",1);
SELECT u.pseudo,s.nom,r.operation,r.result
FROM seances AS s JOIN resultats AS r JOIN users AS u
WHERE s.id = r.seances_id AND u.id = s.users_id AND u.pseudo = "aba";
SELECT * 
FROM seances s LEFT JOIN resultats r
ON s.id = r.seances_id
WHERE s.nom ="teste2";

SELECT pseudo , password FROM users 
    WHERE pseudo = "aba" ;
    INSERT INTO users (pseudo,password) VALUES 
                ("aba","8877");*/