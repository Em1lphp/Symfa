<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240207215228 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Create book table';
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function up(Schema $schema): void
    {
        if ($schema->hasTable('book')) {
            $this->skipIf(true, 'Table already exists!');
            return;
        }

        $books = $schema->createTable('book');
        $books->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $books->addColumn('title', Types::STRING, ['length' => 100])->setNotnull(true);
        $books->addColumn('description', Types::STRING, ['length' => 50])->setNotnull(false);
        $books->addColumn('image', Types::TEXT)->setNotnull(true);
        $books->addColumn('published_at', Types::DATETIMETZ_IMMUTABLE);
        $books->setPrimaryKey(['id']);
        $books->addUniqueIndex(['image']);
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function down(Schema $schema): void
    {
        if (!$schema->hasTable('book')) {
            $this->skipIf(true, 'Table does not exists!');
            return;
        }

        $schema->dropTable('book');
    }
}
