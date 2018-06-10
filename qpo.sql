CREATE TABLE Users(Nro_User INT NOT NULL AUTO_INCREMENT PRIMARY KEY, F_name VARCHAR(20) NOT NULL, L_name VARCHAR(20) NOT NULL, Email VARCHAR(40) NOT NULL, Bday DATE NOT NULL, Sex BOOL NOT NULL, City VARCHAR(30),SU BOOL NOT NULL DEFAULT 0, Updates BOOL Default 0, Alert BOOL Default 0,Verificado BOOL default 0,Existente BOOL default 1);

create table Autenticacao(Nro_User INT NOT NULL AUTO_INCREMENT PRIMARY KEY,Password VARCHAR(30) NOT NULL, Foreign Key (Nro_User) REFERENCES Users(Nro_User));

create table Listas(Nro_list INT NOT NULL PRIMARY KEY,Nro_User INT NOT NULL,Saldo INT NOT NULL,Nome VARCHAR(40),Fechada BOOL DEFAULT 0,Foreign Key (Nro_User) REFERENCES Users(Nro_User));

create table Submissao(Sub_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,Nro_User INT NOT NULL, Nro_list INT NOT NULL,Data DATE NOT NULL,Descricao LONGTEXT NOT NULL,Pagantes LONGTEXT NOT NULL,Eliminada BOOL DEFAULT 0,Valor INT NOT NULL, FOREIGN KEY (Nro_User) REFERENCES Users(Nro_User),FOREIGN KEY (Nro_list) REFERENCES Listas(Nro_list));
