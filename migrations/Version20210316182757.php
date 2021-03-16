<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316182757 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, person_like_product_id INT DEFAULT NULL, login VARCHAR(10) NOT NULL, f_name VARCHAR(100) NOT NULL, l_name VARCHAR(100) NOT NULL, INDEX IDX_34DCD17627940639 (person_like_product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person_like_product (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, person_like_product_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, info LONGTEXT NOT NULL, public_date DATE NOT NULL, INDEX IDX_D34A04AD27940639 (person_like_product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17627940639 FOREIGN KEY (person_like_product_id) REFERENCES person_like_product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD27940639 FOREIGN KEY (person_like_product_id) REFERENCES person_like_product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD17627940639');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD27940639');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE person_like_product');
        $this->addSql('DROP TABLE product');
    }
}
