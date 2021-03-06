<?php

namespace Dime\Api\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160902204545 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $customers = $schema->getTable('customers');
        $customers->addColumn('address', 'string', [ 'length' => 1000, 'notnull' => false ]);
    }

    public function down(Schema $schema)
    {
        $customer = $schema->getTable('customers');
        $customer->dropColumn('address');
    }
}
