<?php

namespace App\JsonApi\V1;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/v1';

    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        Auth::shouldUse('sanctum');

        Post::creating(static function (Post $post): void {
            $post->author()->associate(Auth::user());
        });

        User::creating(static function (User $user): void {
            $user->password = Hash::make($user->password);
        });
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            Comments\CommentSchema::class,
            Posts\PostSchema::class,
            Tags\TagSchema::class,
            Users\UserSchema::class,
            Institutes\InstituteSchema::class,
            Grades\GradeSchema::class,
            Guardians\GuardianSchema::class,
            Students\StudentSchema::class,
        ];
    }
}
