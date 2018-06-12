<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180417180055 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_details DROP FOREIGN KEY FK_2A2B15809D86650F');
        $this->addSql('DROP INDEX IDX_2A2B15809D86650F ON user_details');
        $this->addSql('ALTER TABLE user_details DROP user_id_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_details ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_details ADD CONSTRAINT FK_2A2B15809D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2A2B15809D86650F ON user_details (user_id_id)');
    }
}
