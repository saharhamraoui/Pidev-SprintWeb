<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416021112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_1');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY frK_idUser');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY donation_ibfk_1');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY idDonator_FK');
        $this->addSql('ALTER TABLE ingredients DROP FOREIGN KEY ingredients_ibfk_1');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY fk_livreur_user');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY menu_ibfk_1');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY id_cabinetFK');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY recette_ibfk_1');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY fk_tableIdreservation');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY fk_userIdreservation');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY fk_userIdrestaurant');
        $this->addSql('ALTER TABLE restauranttable DROP FOREIGN KEY fk_restaurantIdtable');
        $this->addSql('DROP TABLE cabinet');
        $this->addSql('DROP TABLE campaign');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE donation');
        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE restauranttable');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\', DROP Role, CHANGE FirstName firstname VARCHAR(35) NOT NULL, CHANGE LastName lastname VARCHAR(35) NOT NULL, CHANGE Address address VARCHAR(20) NOT NULL, CHANGE Rating rating INT NOT NULL, CHANGE Password password VARCHAR(255) NOT NULL, CHANGE picture picture VARCHAR(300) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cabinet (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, codePostal INT NOT NULL, adresseMail VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, id_medecin INT NOT NULL, INDEX id_medecinFK (id_medecin), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE campaign (idCamp INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, goal INT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, associationName VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, campaignType VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image BLOB DEFAULT NULL, current DOUBLE PRECISION DEFAULT \'0\' NOT NULL, PRIMARY KEY(idCamp)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commande (idCommande INT AUTO_INCREMENT NOT NULL, dateCommande DATETIME NOT NULL, adresseLivraison VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, montantTotalCommande DOUBLE PRECISION NOT NULL, idUser INT NOT NULL, plats VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, restaurantId INT DEFAULT 9 NOT NULL, INDEX frK_idUser (idUser), INDEX restaurantId (restaurantId), PRIMARY KEY(idCommande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE donation (idDon INT AUTO_INCREMENT NOT NULL, idCamp INT NOT NULL, valeurDon INT NOT NULL, idDonator INT NOT NULL, history DATE DEFAULT NULL, INDEX idCamp (idCamp), INDEX idDonator_FK (idDonator), PRIMARY KEY(idDon)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ingredients (idIng INT AUTO_INCREMENT NOT NULL, nameIng VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, amount VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idRec INT NOT NULL, INDEX idRec (idRec), PRIMARY KEY(idIng)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE livraison (idLivraison INT AUTO_INCREMENT NOT NULL, idLivreur INT NOT NULL, idCommande INT NOT NULL, statut VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX frk_idLivreur (idLivreur), INDEX fk_keyIdCommande (idCommande), PRIMARY KEY(idLivraison)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE menu (idP INT AUTO_INCREMENT NOT NULL, nameP VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, priceP DOUBLE PRECISION NOT NULL, categoryP VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, ingredientsP VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, restaurantId INT NOT NULL, imageP VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX restaurantId (restaurantId), PRIMARY KEY(idP)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rdv (id INT NOT NULL, id_cabinet INT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, numTel INT NOT NULL, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateRdv DATE NOT NULL, INDEX id_cabinetFK (id_cabinet), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE recette (idRec INT AUTO_INCREMENT NOT NULL, nomRec VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, categoryR VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, difficulty VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, serves INT NOT NULL, prep VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, rating INT NOT NULL, idUser INT NOT NULL, imageRec VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX idUser (idUser), PRIMARY KEY(idRec)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (reservationId INT AUTO_INCREMENT NOT NULL, userId INT DEFAULT NULL, dateTime DATETIME DEFAULT NULL, tableId INT DEFAULT NULL, numberOfPersons INT DEFAULT NULL, INDEX idUser (userId), INDEX tableId (tableId), PRIMARY KEY(reservationId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE restaurant (restaurantId INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, address VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, userId INT DEFAULT NULL, imagePath VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, INDEX idUser (userId), PRIMARY KEY(restaurantId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE restauranttable (tableId INT AUTO_INCREMENT NOT NULL, isOccupied TINYINT(1) DEFAULT NULL, restaurantId INT DEFAULT NULL, INDEX restaurantId (restaurantId), PRIMARY KEY(tableId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_1 FOREIGN KEY (restaurantId) REFERENCES restaurant (restaurantId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT frK_idUser FOREIGN KEY (idUser) REFERENCES user (idUser) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT donation_ibfk_1 FOREIGN KEY (idCamp) REFERENCES campaign (idCamp) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT idDonator_FK FOREIGN KEY (idDonator) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT ingredients_ibfk_1 FOREIGN KEY (idRec) REFERENCES recette (idRec)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT fk_livreur_user FOREIGN KEY (idLivreur) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT menu_ibfk_1 FOREIGN KEY (restaurantId) REFERENCES restaurant (restaurantId)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT id_cabinetFK FOREIGN KEY (id_cabinet) REFERENCES cabinet (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT recette_ibfk_1 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk_tableIdreservation FOREIGN KEY (tableId) REFERENCES restauranttable (tableId)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk_userIdreservation FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT fk_userIdrestaurant FOREIGN KEY (userId) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE restauranttable ADD CONSTRAINT fk_restaurantIdtable FOREIGN KEY (restaurantId) REFERENCES restaurant (restaurantId)');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE user ADD Role VARCHAR(20) NOT NULL COLLATE `utf8mb4_bin`, DROP roles, CHANGE firstname FirstName VARCHAR(20) NOT NULL, CHANGE lastname LastName VARCHAR(20) NOT NULL, CHANGE address Address VARCHAR(50) NOT NULL, CHANGE rating Rating DOUBLE PRECISION DEFAULT NULL, CHANGE password Password VARCHAR(40) NOT NULL, CHANGE picture picture VARCHAR(300) DEFAULT NULL');
    }
}
