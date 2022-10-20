<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20221020112431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create contact table.';
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable('contact') === false) {
            $table = $schema->createTable('contact');
            $table->addColumn('id', Types::INTEGER)
                ->setNotnull(true);
            $table->addColumn('first_name', Types::STRING)
                ->setLength(255)
                ->setNotnull(true);
            $table->addColumn('last_name', Types::STRING)
                ->setLength(255)
                ->setNotnull(true);
            $table->addColumn('phone', Types::STRING)
                ->setLength(16)
                ->setNotnull(true);

            $table->setPrimaryKey(['id']);
        }

        if ($schema->hasSequence('contact_id_seq') === false) {
            $schema->createSequence('contact_id_seq');
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('contact') === true) {
            $schema->dropTable('contact');
        }

        if ($schema->hasSequence('contact_id_seq') === true) {
            $schema->dropSequence('contact_id_seq');
        }
    }
}
