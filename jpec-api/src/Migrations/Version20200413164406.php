<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200413164406 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_card_info (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, card_id INT NOT NULL, nb_errors INT NOT NULL, nb_success INT NOT NULL, next_available DATETIME NOT NULL, user_note VARCHAR(255) DEFAULT NULL, INDEX IDX_275ABE11A76ED395 (user_id), INDEX IDX_275ABE114ACC9A20 (card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_card_info ADD CONSTRAINT FK_275ABE11A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_card_info ADD CONSTRAINT FK_275ABE114ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id)');
        $this->addSql('ALTER TABLE answer ADD user_card_info_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A258A5D378C FOREIGN KEY (user_card_info_id) REFERENCES user_card_info (id)');
        $this->addSql('CREATE INDEX IDX_DADD4A258A5D378C ON answer (user_card_info_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A258A5D378C');
        $this->addSql('DROP TABLE user_card_info');
        $this->addSql('DROP INDEX IDX_DADD4A258A5D378C ON answer');
        $this->addSql('ALTER TABLE answer DROP user_card_info_id');
    }
}
