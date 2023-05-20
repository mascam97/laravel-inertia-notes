<?php

namespace Database\Factories;

use App\Domain\Notes\Models\Note;
use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Note>
 * @method Note create($attributes = [])
 */
class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Note::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 10),
            'title' => $this->faker->text(40),
            'content' => $this->faker->text(1200)
        ];
    }

    public function user(User $user): self
    {
        return $this->state([
            'user_id' => $user->getKey(),
        ]);
    }
}
