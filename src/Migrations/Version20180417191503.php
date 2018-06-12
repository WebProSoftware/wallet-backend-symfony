<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180417191503 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE money_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE money_details ADD money_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE money_details ADD CONSTRAINT FK_164D3DC1BF29332C FOREIGN KEY (money_id) REFERENCES money (id)');
        $this->addSql('CREATE INDEX IDX_164D3DC1BF29332C ON money_details (money_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE money_category');
        $this->addSql('ALTER TABLE money_details DROP FOREIGN KEY FK_164D3DC1BF29332C');
        $this->addSql('DROP INDEX IDX_164D3DC1BF29332C ON money_details');
        $this->addSql('ALTER TABLE money_details DROP money_id');
    }
}
