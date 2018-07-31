<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180731182700 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE locale_currency (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(5) NOT NULL, currency VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_locale_price ADD locale_id INT NOT NULL, DROP locale');
        $this->addSql('ALTER TABLE product_locale_price ADD CONSTRAINT FK_C63534B7E559DFD1 FOREIGN KEY (locale_id) REFERENCES locale_currency (id)');
        $this->addSql('CREATE INDEX IDX_C63534B7E559DFD1 ON product_locale_price (locale_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_locale_price DROP FOREIGN KEY FK_C63534B7E559DFD1');
        $this->addSql('DROP TABLE locale_currency');
        $this->addSql('DROP INDEX IDX_C63534B7E559DFD1 ON product_locale_price');
        $this->addSql('ALTER TABLE product_locale_price ADD locale VARCHAR(5) NOT NULL COLLATE utf8mb4_unicode_ci, DROP locale_id');
    }
}
