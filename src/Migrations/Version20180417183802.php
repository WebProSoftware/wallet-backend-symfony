<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180417183802 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE money ADD money_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE money ADD CONSTRAINT FK_B7DF13E4A127BAD8 FOREIGN KEY (money_type_id) REFERENCES money_type (id)');
        $this->addSql('CREATE INDEX IDX_B7DF13E4A127BAD8 ON money (money_type_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE money DROP FOREIGN KEY FK_B7DF13E4A127BAD8');
        $this->addSql('DROP INDEX IDX_B7DF13E4A127BAD8 ON money');
        $this->addSql('ALTER TABLE money DROP money_type_id');
    }
}
