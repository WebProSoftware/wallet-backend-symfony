<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180417191559 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE money_category ADD money_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE money_category ADD CONSTRAINT FK_E726EAEFA127BAD8 FOREIGN KEY (money_type_id) REFERENCES money_type (id)');
        $this->addSql('CREATE INDEX IDX_E726EAEFA127BAD8 ON money_category (money_type_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE money_category DROP FOREIGN KEY FK_E726EAEFA127BAD8');
        $this->addSql('DROP INDEX IDX_E726EAEFA127BAD8 ON money_category');
        $this->addSql('ALTER TABLE money_category DROP money_type_id');
    }
}
