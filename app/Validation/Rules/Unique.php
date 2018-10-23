<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use App\Validation\Exceptions\UniqueException;
use Illuminate\Database\Capsule\Manager as DB;

class Unique extends AbstractRule
{

    /**
     * @var string $table
     */
    protected $table;

    /**
     * @var string $column
     */
    protected $column;

    /**
     * Unique constructor.
     *
     * @param string $type
     */
    public function __construct(string $type = null)
    {
        if (strpos($type, '.') === false) {
            throw new UniqueException('Please, provide table and column name (table.column)');
        }

        [$this->table, $this->column] = explode('.', trim($type));
    }

    /**
     * @param string $input
     * @return bool
     */
    public function validate($input)
    {
        return DB::table($this->table)->where($this->column, $input)->exists() === false;
    }
}