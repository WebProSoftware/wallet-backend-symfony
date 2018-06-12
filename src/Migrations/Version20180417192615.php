<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180417192615 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE money ADD money_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE money ADD CONSTRAINT FK_B7DF13E4B263CCD1 FOREIGN KEY (money_category_id) REFERENCES money_category (id)');
        $this->addSql('CREATE INDEX IDX_B7DF13E4B263CCD1 ON money (money_category_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE money DROP FOREIGN KEY FK_B7DF13E4B263CCD1');
        $this->addSql('DROP INDEX IDX_B7DF13E4B263CCD1 ON money');
        $this->addSql('ALTER TABLE money DROP money_category_id');
    }
}
