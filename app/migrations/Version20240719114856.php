<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240719114856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add new table books';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(64) NOT NULL, publisher VARCHAR(32) NOT NULL, author VARCHAR(32) NOT NULL, genre VARCHAR(32) NOT NULL, publication_date DATE NOT NULL, word_count INT NOT NULL, price_usd NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE book');
    }
}
