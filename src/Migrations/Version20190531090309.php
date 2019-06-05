<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190531090309 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, task_id INT DEFAULT NULL, note VARCHAR(255) NOT NULL, INDEX IDX_CFBDFA148DB60186 (task_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, list_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, is_complete TINYINT(1) NOT NULL, INDEX IDX_527EDB253DAE168B (list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_list (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, background VARCHAR(255) NOT NULL, background_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA148DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB253DAE168B FOREIGN KEY (list_id) REFERENCES task_list (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA148DB60186');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB253DAE168B');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_list');
    }
}
