<?php

namespace Src\Database\Eloquent;

use Faker\Factory as FakerFactory;
use Faker\Generator;
use Illuminate\Database\Connection;
use Src\Providers\DatabaseServiceProvider as DB;

abstract class Factory
{
    protected Generator $faker;
    protected int $count = 1;

    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }

    abstract protected function definition(): array;

    public function count(int $count = 1): object
    {
        $this->count = $count;
        return $this;
    }

    public function create(): object
    {
        $model = new ($this->model())($this->definition());
        for ($i = 0; $i < $this->count; $i++) {
            $model->save(DB::get()->getConnection());
        }
        return $model;
    }

    public function make()
    {
        $model = $this->model();
        return new $model($this->definition());
    }

    abstract protected function model(): string;
}