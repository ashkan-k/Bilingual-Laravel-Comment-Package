<?php


namespace Ashkan\Comment\Factories;

use App\Models\User;
use Ashkan\Comment\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'content' => $this->faker->text(),

            "user_id" => User::factory(),
            "commentable_id" => 1,
            "commentable_type" => "App\Models\Article",
            "parent_id" => null
        ];
    }
}
