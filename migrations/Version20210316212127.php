<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316212127 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `like` ADD person_id_id INT DEFAULT NULL, ADD product_id_id INT DEFAULT NULL, DROP person_id, DROP product_id');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3D3728193 FOREIGN KEY (person_id_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_AC6340B3D3728193 ON `like` (person_id_id)');
        $this->addSql('CREATE INDEX IDX_AC6340B3DE18E50B ON `like` (product_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3D3728193');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3DE18E50B');
        $this->addSql('DROP INDEX IDX_AC6340B3D3728193 ON `like`');
        $this->addSql('DROP INDEX IDX_AC6340B3DE18E50B ON `like`');
        $this->addSql('ALTER TABLE `like` ADD person_id INT NOT NULL, ADD product_id INT NOT NULL, DROP person_id_id, DROP product_id_id');
    }
}
