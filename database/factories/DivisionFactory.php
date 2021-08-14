<?php

namespace Database\Factories;

use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DivisionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Division::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $parent = Division::all();
        if($parent->count() == 0)
            $parentId = NULL;
        else
            $parentId = $parent->random()->id;
        
        return [
            'name' => rtrim($this->faker->sentence(rand(1,2)),"."),
            'description' => $this->faker->paragraphs(rand(3,7),true),
            'task' => $this->faker->paragraphs(rand(2,4),true),
            'parent_id' => $parentId,
        ];
    }
}
