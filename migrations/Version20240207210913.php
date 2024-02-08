<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240207210913 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Create author table';
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function up(Schema $schema): void
    {
        if ($schema->hasTable('author')) {
            $this->skipIf(true, 'Table already exists!');
            return;
        }

        $authors = $schema->createTable('author');

        $authors->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $authors->addColumn('name', Types::STRING, ['length' => 50])->setNotnull(true);
        $authors->addColumn('surname', Types::STRING, ['length' => 50])->setNotnull(true);
        $authors->addColumn('patronymic', Types::STRING, ['length' => 50])->setNotnull(false);
        $authors->setPrimaryKey(['id']);
    }


    /**
     * @param Schema $schema
     * @return void
     */
    public function down(Schema $schema): void
    {
        if (!$schema->hasTable('author')) {
            $this->skipIf(true, 'Table does not exists!');
            return;
        }

        $schema->dropTable('author');
    }
}
