<?php

namespace Database\Factories;

use App\Models\Version;
use Illuminate\Database\Eloquent\Factories\Factory;

class VersionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Version::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'version_id' => 1,
            'title' => $this->faker->text(50),
            'content' => $this->faker->text(150),
            'is_active' => 1,
            'note_id' => 1,
        ];
    }
}
