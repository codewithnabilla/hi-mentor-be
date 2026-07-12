<?php

namespace App\Traits;

trait SchemaPrefixHelper
{
    /**
     * Return schema-qualified table name.
     */
    protected function table(string $schema, string $table): string
    {
        return "{$schema}.{$table}";
    }
}