<?php

namespace Database\Factories\Project;

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            "description" => $this->faker->text(150),
            "image" => $this->faker->imageUrl()
        ];
    }
}
