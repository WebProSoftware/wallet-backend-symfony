<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180613172613 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD user_adress_id INT DEFAULT NULL, ADD user_details_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64984667448 FOREIGN KEY (user_adress_id) REFERENCES user_address (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491C7DC1CE FOREIGN KEY (user_details_id) REFERENCES user_details (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64984667448 ON user (user_adress_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6491C7DC1CE ON user (user_details_id)');
        $this->addSql('ALTER TABLE user_details DROP FOREIGN KEY FK_2A2B1580A76ED395');
        $this->addSql('DROP INDEX IDX_2A2B1580A76ED395 ON user_details');
        $this->addSql('ALTER TABLE user_details DROP user_id');
        $this->addSql('ALTER TABLE user_address DROP FOREIGN KEY FK_5543718BA76ED395');
        $this->addSql('DROP INDEX IDX_5543718BA76ED395 ON user_address');
        $this->addSql('ALTER TABLE user_address DROP user_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64984667448');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491C7DC1CE');
        $this->addSql('DROP INDEX UNIQ_8D93D64984667448 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D6491C7DC1CE ON user');
        $this->addSql('ALTER TABLE user DROP user_adress_id, DROP user_details_id');
        $this->addSql('ALTER TABLE user_address ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_address ADD CONSTRAINT FK_5543718BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5543718BA76ED395 ON user_address (user_id)');
        $this->addSql('ALTER TABLE user_details ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_details ADD CONSTRAINT FK_2A2B1580A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2A2B1580A76ED395 ON user_details (user_id)');
    }
}
