<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231017174122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tbl_fichiers (id INT AUTO_INCREMENT NOT NULL, path_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', type VARCHAR(6) DEFAULT NULL, size INT DEFAULT NULL, creator VARCHAR(255) DEFAULT NULL, modifier VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', removed TINYINT(1) DEFAULT NULL, removed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', removed_by VARCHAR(255) DEFAULT NULL, INDEX IDX_C1AE5286D96C566B (path_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_paths (id INT AUTO_INCREMENT NOT NULL, directory_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, rang INT DEFAULT NULL, creator VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', uploaded_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', modifier VARCHAR(255) DEFAULT NULL, removed TINYINT(1) DEFAULT NULL, INDEX IDX_25DECC0E2C94069F (directory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trash (id INT AUTO_INCREMENT NOT NULL, initpath_id INT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, removed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_528BB4D13EA0C12 (initpath_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tbl_fichiers ADD CONSTRAINT FK_C1AE5286D96C566B FOREIGN KEY (path_id) REFERENCES tbl_paths (id)');
        $this->addSql('ALTER TABLE tbl_paths ADD CONSTRAINT FK_25DECC0E2C94069F FOREIGN KEY (directory_id) REFERENCES tbl_paths (id)');
        $this->addSql('ALTER TABLE trash ADD CONSTRAINT FK_528BB4D13EA0C12 FOREIGN KEY (initpath_id) REFERENCES tbl_paths (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_fichiers DROP FOREIGN KEY FK_C1AE5286D96C566B');
        $this->addSql('ALTER TABLE tbl_paths DROP FOREIGN KEY FK_25DECC0E2C94069F');
        $this->addSql('ALTER TABLE trash DROP FOREIGN KEY FK_528BB4D13EA0C12');
        $this->addSql('DROP TABLE tbl_fichiers');
        $this->addSql('DROP TABLE tbl_paths');
        $this->addSql('DROP TABLE trash');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
