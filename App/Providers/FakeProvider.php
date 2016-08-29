<?php
namespace App\Providers;

use Faker\Factory as Faker;

class FakeProvider
{
    public $definitions = [];
    public static $instance = null;

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function define($class, callable $attributes)
    {
        $this->definitions[$class] = $attributes;
    }

    /**
     * Options extra values to be inserted into the db not specified in Helpers\fake()->define()
     * 
     * @param string $class
     * @param int $amount
     * @param array $options
     */
    public function create($class, $amount = 1, $options = [])
    {
        $name = $class;
        $class = "\\App\\Models\\{$class}";
        $object = new $class();
        $create = $this->definitions[$name];

        for ($i = 0; $i < $amount; $i++)
        {
            $object->create($create(Faker::create()) + $options);
        }
    }

    public function truncate()
    {
        foreach($this->definitions as $table => $callback)
        {
            $class = "\\App\\Models\\{$table}";
            $object = new $class();
            $object->truncate();
        }
    }
}