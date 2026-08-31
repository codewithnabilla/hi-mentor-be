<?php

namespace App\Traits;

trait SchemaPrefixHelper
{
    /**
     * Return schema-qualified table name for databases that support schemas.
     * SQLite keeps tables in the main database namespace, so omit the schema here.
     */
    protected function table(string $schema, string $table): string
    {
        if (config('database.default') === 'sqlite') {
            return $table;
        }

        return "{$schema}.{$table}";
    }
}