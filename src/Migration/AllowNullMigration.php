<?php

/**
 * This file is part of MetaModels/attribute_text.
 *
 * (c) 2012-2023 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels/attribute_text
 * @author     Ingolf Steinhardt <info@e-spin.de>
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2012-2023 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_text/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

declare(strict_types=1);

namespace MetaModels\AttributeTextBundle\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ColumnDiff;
use Doctrine\DBAL\Schema\TableDiff;

use function array_intersect;
use function array_map;
use function array_values;
use function count;
use function implode;

/**
 * This migration changes all database columns to allow null values.
 *
 * This became necessary with the changes for https://github.com/MetaModels/core/issues/1330.
 */
class AllowNullMigration extends AbstractMigration
{
    /**
     * The database connection.
     *
     * @var Connection
     */
    private Connection $connection;

    /**
     * Create a new instance.
     *
     * @param Connection $connection The database connection.
     */

    /** @var list<string> */
    private array $existsCache = [];
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return the name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Allow null values in MetaModels "text" attributes.';
    }

    /**
     * Must only run if:
     * - the MM tables are present AND
     * - there are some columns defined AND
     * - these columns do not allow null values yet.
     *
     * @return bool
     */
    public function shouldRun(): bool
    {
        if (!$this->tablesExist(['tl_metamodel', 'tl_metamodel_attribute'])) {
            return false;
        }

        $langColumns = $this->fetchNonNullableColumns();
        if (empty($langColumns)) {
            return false;
        }

        return true;
    }

    /**
     * Collect the columns to be updated and update them.
     *
     * @return MigrationResult
     */
    public function run(): MigrationResult
    {
        $langColumns = $this->fetchNonNullableColumns();
        $message     = [];
        foreach ($langColumns as $tableName => $tableColumns) {
            foreach ($tableColumns as $tableColumn) {
                $this->fixColumn($tableName, $tableColumn);
                $message[] = $tableName . '.' . $tableColumn->getName();
            }
        }

        return new MigrationResult(true, 'Adjusted column(s): ' . implode(', ', $message));
    }

    /**
     * Fetch all columns that are not nullable yet.
     *
     * @return array<string, list<Column>>
     */
    private function fetchNonNullableColumns(): array
    {
        $langColumns = $this->fetchColumnNames();
        if (empty($langColumns)) {
            return [];
        }
        $schemaManager = $this->connection->createSchemaManager();

        $result = [];
        foreach ($langColumns as $tableName => $tableColumnNames) {
            if (!$this->tablesExist([$tableName])) {
                continue;
            }

            /** @var array<string, Column> $columns */
            $columns = [];
            // The schema manager return the column list with lowercase keys, wo got to use the real names.
            $table = $schemaManager->introspectTable($tableName);
            foreach ($table->getColumns() as $column) {
                $columns[$column->getName()] = $column;
            }
            foreach ($tableColumnNames as $tableColumnName) {
                $column = ($columns[$tableColumnName] ?? null);
                if (null === $column) {
                    continue;
                }
                if (null !== $column->getDefault()) {
                    if (!isset($result[$tableName])) {
                        $result[$tableName] = [];
                    }
                    $result[$tableName][] = $column;
                }
            }
        }

        return $result;
    }

    /**
     * Obtain the names of table columns.
     *
     * @return array<string, list<string>>
     */
    private function fetchColumnNames(): array
    {
        $langColumns = $this
            ->connection
            ->createQueryBuilder()
            ->select('metamodel.tableName AS metamodel', 'attribute.colName AS attribute')
            ->from('tl_metamodel_attribute', 'attribute')
            ->leftJoin('attribute', 'tl_metamodel', 'metamodel', 'attribute.pid = metamodel.id')
            ->where('attribute.type=:type')
            ->setParameter('type', 'text')
            ->executeQuery()
            ->fetchAllAssociative();

        $result = [];
        foreach ($langColumns as $langColumn) {
            if (!isset($result[$langColumn['metamodel']])) {
                $result[$langColumn['metamodel']] = [];
            }
            $result[$langColumn['metamodel']][] = $langColumn['attribute'];
        }

        return $result;
    }

    /**
     * Fix a table column.
     *
     * @param string $tableName The name of the table.
     * @param Column $column    The column.
     *
     * @return void
     */
    private function fixColumn(string $tableName, Column $column): void
    {
        $manager = $this->connection->createSchemaManager();
        $table   = $manager->introspectTable($tableName);
        $updated = $manager->introspectTable($tableName);

        $updated->getColumn($column->getName())
            ->setNotnull(false)
            ->setDefault(null);

        $tableDiff = $manager->createComparator()->compareTables($table, $updated);

        $manager->alterTable($tableDiff);

        $this->connection->createQueryBuilder()
            ->update($tableName, 't')
            ->set('t.' . $column->getName(), 'null')
            ->where('t.' . $column->getName() . ' = ""')
            ->executeQuery();
    }

    private function tablesExist(array $tableNames): bool
    {
        if ([] === $this->existsCache) {
            $this->existsCache = array_values($this->connection->createSchemaManager()->listTableNames());
        }

        return count($tableNames) === count(array_intersect($tableNames, array_map('strtolower', $this->existsCache)));
    }
}
