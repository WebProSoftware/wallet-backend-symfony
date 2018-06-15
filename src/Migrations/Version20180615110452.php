<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180615110452 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE money_details DROP FOREIGN KEY FK_164D3DC1BF29332C');
        $this->addSql('DROP INDEX UNIQ_164D3DC1BF29332C ON money_details');
        $this->addSql('ALTER TABLE money_details DROP money_id');
        $this->addSql('ALTER TABLE money ADD money_details_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE money ADD CONSTRAINT FK_B7DF13E494A94CC2 FOREIGN KEY (money_details_id) REFERENCES money_details (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B7DF13E494A94CC2 ON money (money_details_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE money DROP FOREIGN KEY FK_B7DF13E494A94CC2');
        $this->addSql('DROP INDEX UNIQ_B7DF13E494A94CC2 ON money');
        $this->addSql('ALTER TABLE money DROP money_details_id');
        $this->addSql('ALTER TABLE money_details ADD money_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE money_details ADD CONSTRAINT FK_164D3DC1BF29332C FOREIGN KEY (money_id) REFERENCES money (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_164D3DC1BF29332C ON money_details (money_id)');
    }
}
