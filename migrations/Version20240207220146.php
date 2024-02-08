<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240207220146 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'author_book';
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function up(Schema $schema): void
    {
        if ($schema->hasTable('author_book')) {
            $this->skipIf(true, 'Table "author_book" already exists.');
            return;
        }

        $authorBook = $schema->createTable('author_book');
        $authorBook->addColumn('author_id', Types::INTEGER)->setNotnull(true);
        $authorBook->addColumn('book_id', Types::INTEGER)->setNotnull(true);
        $authorBook->setPrimaryKey(['author_id', 'book_id']);
        $authorBook->addForeignKeyConstraint('author', ['author_id'], ['id'], ['onDelete' => 'CASCADE']);
        $authorBook->addForeignKeyConstraint('book', ['book_id'], ['id'], ['onDelete' => 'CASCADE']);
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function down(Schema $schema): void
    {
        if ($schema->hasTable('author_book')) {
            $this->skipIf(true, 'Table does not exists!');
            return;
        }

        $schema->dropTable('author_book');
    }
}
