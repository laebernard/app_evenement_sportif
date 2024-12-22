<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211202737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD location_y VARCHAR(255) NOT NULL, ADD ville VARCHAR(255) NOT NULL, CHANGE location location_x VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE particpant ADD location_y VARCHAR(255) NOT NULL, ADD ville VARCHAR(255) NOT NULL, CHANGE location location_x VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD location VARCHAR(255) NOT NULL, DROP location_x, DROP location_y, DROP ville');
        $this->addSql('ALTER TABLE particpant ADD location VARCHAR(255) NOT NULL, DROP location_x, DROP location_y, DROP ville');
    }
}
