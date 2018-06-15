<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180615153550 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE money DROP FOREIGN KEY FK_B7DF13E47C44A40E');
        $this->addSql('DROP INDEX IDX_B7DF13E47C44A40E ON money');
        $this->addSql('ALTER TABLE money CHANGE model_category_id money_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE money ADD CONSTRAINT FK_B7DF13E4B263CCD1 FOREIGN KEY (money_category_id) REFERENCES money_category (id)');
        $this->addSql('CREATE INDEX IDX_B7DF13E4B263CCD1 ON money (money_category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE money DROP FOREIGN KEY FK_B7DF13E4B263CCD1');
        $this->addSql('DROP INDEX IDX_B7DF13E4B263CCD1 ON money');
        $this->addSql('ALTER TABLE money CHANGE money_category_id model_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE money ADD CONSTRAINT FK_B7DF13E47C44A40E FOREIGN KEY (model_category_id) REFERENCES money_category (id)');
        $this->addSql('CREATE INDEX IDX_B7DF13E47C44A40E ON money (model_category_id)');
    }
}
