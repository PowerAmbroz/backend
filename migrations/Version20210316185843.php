<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316185843 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD17627940639');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD27940639');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE person_like_product');
        $this->addSql('DROP INDEX IDX_34DCD17627940639 ON person');
        $this->addSql('ALTER TABLE person DROP person_like_product_id');
        $this->addSql('DROP INDEX IDX_D34A04AD27940639 ON product');
        $this->addSql('ALTER TABLE product DROP person_like_product_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE person_like_product (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('ALTER TABLE person ADD person_like_product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17627940639 FOREIGN KEY (person_like_product_id) REFERENCES person_like_product (id)');
        $this->addSql('CREATE INDEX IDX_34DCD17627940639 ON person (person_like_product_id)');
        $this->addSql('ALTER TABLE product ADD person_like_product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD27940639 FOREIGN KEY (person_like_product_id) REFERENCES person_like_product (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD27940639 ON product (person_like_product_id)');
    }
}
