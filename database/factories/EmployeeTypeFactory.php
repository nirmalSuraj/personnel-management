<?php

namespace Database\Factories;

use App\Models\EmployeeType;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeTypeFactory extends Factory
{

    protected $model = EmployeeType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    private $type = ["case", "kelner", "kok"];

    public function definition()
    {
        return [
            "type" => $this->type[rand(0, count($this->type))]
        ];
    }
}
