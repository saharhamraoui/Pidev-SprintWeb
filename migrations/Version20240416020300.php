<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416020300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cabinet CHANGE id id VARCHAR(255) NOT NULL, CHANGE id_medecin id_medecin INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cabinet ADD CONSTRAINT FK_4CED05B0C547FAB6 FOREIGN KEY (id_medecin) REFERENCES user (iduser)');
        $this->addSql('DROP INDEX id_medecinfk ON cabinet');
        $this->addSql('CREATE INDEX IDX_4CED05B0C547FAB6 ON cabinet (id_medecin)');
        $this->addSql('ALTER TABLE campaign CHANGE idCamp idcamp VARCHAR(255) NOT NULL, CHANGE titre titre VARCHAR(35) NOT NULL, CHANGE description description VARCHAR(6000) NOT NULL, CHANGE current current DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY frK_idUser');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_1');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY frK_idUser');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_1');
        $this->addSql('ALTER TABLE commande CHANGE idCommande idcommande VARCHAR(255) NOT NULL, CHANGE dateCommande datecommande DATE DEFAULT NULL, CHANGE idUser iduser INT DEFAULT NULL, CHANGE restaurantId restaurantid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D145ED7B1 FOREIGN KEY (restaurantid) REFERENCES restaurant (restaurantid)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D5E5C27E9 FOREIGN KEY (iduser) REFERENCES user (iduser)');
        $this->addSql('DROP INDEX restaurantid ON commande');
        $this->addSql('CREATE INDEX IDX_6EEAA67D145ED7B1 ON commande (restaurantid)');
        $this->addSql('DROP INDEX frk_iduser ON commande');
        $this->addSql('CREATE INDEX IDX_6EEAA67D5E5C27E9 ON commande (iduser)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT frK_idUser FOREIGN KEY (idUser) REFERENCES user (idUser) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_1 FOREIGN KEY (restaurantId) REFERENCES restaurant (restaurantId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY donation_ibfk_1');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY donation_ibfk_1');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY idDonator_FK');
        $this->addSql('ALTER TABLE donation CHANGE idCamp idcamp VARCHAR(255) DEFAULT NULL, CHANGE idDonator iddonator INT DEFAULT NULL');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A0125BB390 FOREIGN KEY (idcamp) REFERENCES campaign (idcamp)');
        $this->addSql('DROP INDEX iddonator_fk ON donation');
        $this->addSql('CREATE INDEX IDX_31E581A06E3DA6D7 ON donation (iddonator)');
        $this->addSql('DROP INDEX idcamp ON donation');
        $this->addSql('CREATE INDEX IDX_31E581A0125BB390 ON donation (idcamp)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT donation_ibfk_1 FOREIGN KEY (idCamp) REFERENCES campaign (idCamp) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT idDonator_FK FOREIGN KEY (idDonator) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE ingredients DROP FOREIGN KEY ingredients_ibfk_1');
        $this->addSql('ALTER TABLE ingredients CHANGE idIng iding VARCHAR(255) NOT NULL, CHANGE idRec idrec INT DEFAULT NULL');
        $this->addSql('DROP INDEX idrec ON ingredients');
        $this->addSql('CREATE INDEX IDX_4B60114F7D00914B ON ingredients (idrec)');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT ingredients_ibfk_1 FOREIGN KEY (idRec) REFERENCES recette (idRec)');
        $this->addSql('DROP INDEX fk_keyIdCommande ON livraison');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY fk_livreur_user');
        $this->addSql('ALTER TABLE livraison CHANGE idLivraison idlivraison VARCHAR(255) NOT NULL, CHANGE idLivreur idlivreur INT DEFAULT NULL');
        $this->addSql('DROP INDEX frk_idlivreur ON livraison');
        $this->addSql('CREATE INDEX IDX_A60C9F1F347E1C03 ON livraison (idlivreur)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT fk_livreur_user FOREIGN KEY (idLivreur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY menu_ibfk_1');
        $this->addSql('ALTER TABLE menu CHANGE idP idp VARCHAR(255) NOT NULL, CHANGE restaurantId restaurantid VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX restaurantid ON menu');
        $this->addSql('CREATE INDEX IDX_7D053A93145ED7B1 ON menu (restaurantid)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT menu_ibfk_1 FOREIGN KEY (restaurantId) REFERENCES restaurant (restaurantId)');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY id_cabinetFK');
        $this->addSql('DROP INDEX id_cabinetFK ON rdv');
        $this->addSql('ALTER TABLE rdv DROP id_cabinet, CHANGE id id VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(50) NOT NULL, CHANGE dateRdv daterdv DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86BF396750 FOREIGN KEY (id) REFERENCES cabinet (id)');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY recette_ibfk_1');
        $this->addSql('ALTER TABLE recette CHANGE nomRec nomrec VARCHAR(35) NOT NULL, CHANGE categoryR categoryr VARCHAR(35) NOT NULL, CHANGE prep prep VARCHAR(35) NOT NULL, CHANGE description description VARCHAR(6000) NOT NULL, CHANGE date date VARCHAR(35) NOT NULL, CHANGE idUser iduser INT DEFAULT NULL, CHANGE imageRec imagerec VARCHAR(35) NOT NULL');
        $this->addSql('DROP INDEX iduser ON recette');
        $this->addSql('CREATE INDEX IDX_49BB63905E5C27E9 ON recette (iduser)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT recette_ibfk_1 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY fk_userIdreservation');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY fk_tableIdreservation');
        $this->addSql('ALTER TABLE reservation CHANGE reservationId reservationid VARCHAR(255) NOT NULL, CHANGE dateTime datetime VARCHAR(255) NOT NULL, CHANGE tableId tableid VARCHAR(255) DEFAULT NULL, CHANGE numberOfPersons numberofpersons VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX tableid ON reservation');
        $this->addSql('CREATE INDEX IDX_42C84955641DE74B ON reservation (tableid)');
        $this->addSql('DROP INDEX iduser ON reservation');
        $this->addSql('CREATE INDEX IDX_42C84955F132696E ON reservation (userid)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk_userIdreservation FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk_tableIdreservation FOREIGN KEY (tableId) REFERENCES restauranttable (tableId)');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY fk_userIdrestaurant');
        $this->addSql('ALTER TABLE restaurant CHANGE restaurantId restaurantid VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(150) NOT NULL, CHANGE address address VARCHAR(150) NOT NULL, CHANGE description description VARCHAR(150) NOT NULL, CHANGE imagePath imagepath VARCHAR(150) NOT NULL');
        $this->addSql('DROP INDEX iduser ON restaurant');
        $this->addSql('CREATE INDEX IDX_EB95123FF132696E ON restaurant (userid)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT fk_userIdrestaurant FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE restauranttable DROP FOREIGN KEY fk_restaurantIdtable');
        $this->addSql('ALTER TABLE restauranttable CHANGE tableId tableid VARCHAR(255) NOT NULL, CHANGE isOccupied isoccupied VARCHAR(255) NOT NULL, CHANGE restaurantId restaurantid VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX restaurantid ON restauranttable');
        $this->addSql('CREATE INDEX IDX_691A6F39145ED7B1 ON restauranttable (restaurantid)');
        $this->addSql('ALTER TABLE restauranttable ADD CONSTRAINT fk_restaurantIdtable FOREIGN KEY (restaurantId) REFERENCES restaurant (restaurantId)');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\', DROP Role, CHANGE FirstName firstname VARCHAR(35) NOT NULL, CHANGE LastName lastname VARCHAR(35) NOT NULL, CHANGE Address address VARCHAR(20) NOT NULL, CHANGE Rating rating INT NOT NULL, CHANGE Password password VARCHAR(255) NOT NULL, CHANGE picture picture VARCHAR(300) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE cabinet DROP FOREIGN KEY FK_4CED05B0C547FAB6');
        $this->addSql('ALTER TABLE cabinet DROP FOREIGN KEY FK_4CED05B0C547FAB6');
        $this->addSql('ALTER TABLE cabinet CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE id_medecin id_medecin INT NOT NULL');
        $this->addSql('DROP INDEX idx_4ced05b0c547fab6 ON cabinet');
        $this->addSql('CREATE INDEX id_medecinFK ON cabinet (id_medecin)');
        $this->addSql('ALTER TABLE cabinet ADD CONSTRAINT FK_4CED05B0C547FAB6 FOREIGN KEY (id_medecin) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE campaign CHANGE idcamp idCamp INT AUTO_INCREMENT NOT NULL, CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE description description TEXT NOT NULL, CHANGE current current DOUBLE PRECISION DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D145ED7B1');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D5E5C27E9');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D145ED7B1');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D5E5C27E9');
        $this->addSql('ALTER TABLE commande CHANGE idcommande idCommande INT AUTO_INCREMENT NOT NULL, CHANGE restaurantid restaurantId INT DEFAULT 9 NOT NULL, CHANGE iduser idUser INT NOT NULL, CHANGE datecommande dateCommande DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT frK_idUser FOREIGN KEY (idUser) REFERENCES user (idUser) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_1 FOREIGN KEY (restaurantId) REFERENCES restaurant (restaurantId) ON DELETE CASCADE');
        $this->addSql('DROP INDEX idx_6eeaa67d5e5c27e9 ON commande');
        $this->addSql('CREATE INDEX frK_idUser ON commande (idUser)');
        $this->addSql('DROP INDEX idx_6eeaa67d145ed7b1 ON commande');
        $this->addSql('CREATE INDEX restaurantId ON commande (restaurantId)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D145ED7B1 FOREIGN KEY (restaurantid) REFERENCES restaurant (restaurantid)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D5E5C27E9 FOREIGN KEY (iduser) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A0125BB390');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A06E3DA6D7');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A0125BB390');
        $this->addSql('ALTER TABLE donation CHANGE iddonator idDonator INT NOT NULL, CHANGE idcamp idCamp INT NOT NULL');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT donation_ibfk_1 FOREIGN KEY (idCamp) REFERENCES campaign (idCamp) ON DELETE CASCADE');
        $this->addSql('DROP INDEX idx_31e581a0125bb390 ON donation');
        $this->addSql('CREATE INDEX idCamp ON donation (idCamp)');
        $this->addSql('DROP INDEX idx_31e581a06e3da6d7 ON donation');
        $this->addSql('CREATE INDEX idDonator_FK ON donation (idDonator)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A06E3DA6D7 FOREIGN KEY (iddonator) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A0125BB390 FOREIGN KEY (idcamp) REFERENCES campaign (idcamp)');
        $this->addSql('ALTER TABLE ingredients DROP FOREIGN KEY FK_4B60114F7D00914B');
        $this->addSql('ALTER TABLE ingredients CHANGE iding idIng INT AUTO_INCREMENT NOT NULL, CHANGE idrec idRec INT NOT NULL');
        $this->addSql('DROP INDEX idx_4b60114f7d00914b ON ingredients');
        $this->addSql('CREATE INDEX idRec ON ingredients (idRec)');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT FK_4B60114F7D00914B FOREIGN KEY (idrec) REFERENCES recette (idrec)');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F347E1C03');
        $this->addSql('ALTER TABLE livraison CHANGE idlivraison idLivraison INT AUTO_INCREMENT NOT NULL, CHANGE idlivreur idLivreur INT NOT NULL');
        $this->addSql('CREATE INDEX fk_keyIdCommande ON livraison (idCommande)');
        $this->addSql('DROP INDEX idx_a60c9f1f347e1c03 ON livraison');
        $this->addSql('CREATE INDEX frk_idLivreur ON livraison (idLivreur)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F347E1C03 FOREIGN KEY (idlivreur) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93145ED7B1');
        $this->addSql('ALTER TABLE menu CHANGE idp idP INT AUTO_INCREMENT NOT NULL, CHANGE restaurantid restaurantId INT NOT NULL');
        $this->addSql('DROP INDEX idx_7d053a93145ed7b1 ON menu');
        $this->addSql('CREATE INDEX restaurantId ON menu (restaurantId)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93145ED7B1 FOREIGN KEY (restaurantid) REFERENCES restaurant (restaurantid)');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86BF396750');
        $this->addSql('ALTER TABLE rdv ADD id_cabinet INT NOT NULL, CHANGE id id INT NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE daterdv dateRdv DATE NOT NULL');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT id_cabinetFK FOREIGN KEY (id_cabinet) REFERENCES cabinet (id)');
        $this->addSql('CREATE INDEX id_cabinetFK ON rdv (id_cabinet)');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB63905E5C27E9');
        $this->addSql('ALTER TABLE recette CHANGE iduser idUser INT NOT NULL, CHANGE nomrec nomRec VARCHAR(30) NOT NULL, CHANGE categoryr categoryR VARCHAR(50) NOT NULL, CHANGE prep prep VARCHAR(15) NOT NULL, CHANGE description description TEXT NOT NULL, CHANGE date date VARCHAR(30) NOT NULL, CHANGE imagerec imageRec VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX idx_49bb63905e5c27e9 ON recette');
        $this->addSql('CREATE INDEX idUser ON recette (idUser)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB63905E5C27E9 FOREIGN KEY (iduser) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955641DE74B');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955F132696E');
        $this->addSql('ALTER TABLE reservation CHANGE reservationid reservationId INT AUTO_INCREMENT NOT NULL, CHANGE tableid tableId INT DEFAULT NULL, CHANGE datetime dateTime DATETIME DEFAULT NULL, CHANGE numberofpersons numberOfPersons INT DEFAULT NULL');
        $this->addSql('DROP INDEX idx_42c84955641de74b ON reservation');
        $this->addSql('CREATE INDEX tableId ON reservation (tableId)');
        $this->addSql('DROP INDEX idx_42c84955f132696e ON reservation');
        $this->addSql('CREATE INDEX idUser ON reservation (userId)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955641DE74B FOREIGN KEY (tableid) REFERENCES restauranttable (tableid)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955F132696E FOREIGN KEY (userid) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FF132696E');
        $this->addSql('ALTER TABLE restaurant CHANGE restaurantid restaurantId INT AUTO_INCREMENT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE address address VARCHAR(255) NOT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE imagepath imagePath VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX idx_eb95123ff132696e ON restaurant');
        $this->addSql('CREATE INDEX idUser ON restaurant (userId)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FF132696E FOREIGN KEY (userid) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE restauranttable DROP FOREIGN KEY FK_691A6F39145ED7B1');
        $this->addSql('ALTER TABLE restauranttable CHANGE tableid tableId INT AUTO_INCREMENT NOT NULL, CHANGE restaurantid restaurantId INT DEFAULT NULL, CHANGE isoccupied isOccupied TINYINT(1) DEFAULT NULL');
        $this->addSql('DROP INDEX idx_691a6f39145ed7b1 ON restauranttable');
        $this->addSql('CREATE INDEX restaurantId ON restauranttable (restaurantId)');
        $this->addSql('ALTER TABLE restauranttable ADD CONSTRAINT FK_691A6F39145ED7B1 FOREIGN KEY (restaurantid) REFERENCES restaurant (restaurantid)');
        $this->addSql('ALTER TABLE user ADD Role VARCHAR(20) NOT NULL COLLATE `utf8mb4_bin`, DROP roles, CHANGE firstname FirstName VARCHAR(20) NOT NULL, CHANGE lastname LastName VARCHAR(20) NOT NULL, CHANGE address Address VARCHAR(50) NOT NULL, CHANGE rating Rating DOUBLE PRECISION DEFAULT NULL, CHANGE password Password VARCHAR(40) NOT NULL, CHANGE picture picture VARCHAR(300) DEFAULT NULL');
    }
}
