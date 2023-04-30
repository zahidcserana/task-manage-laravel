<?php

namespace App\JsonApi\V1;

use App\Models\Batch;
use App\Models\Grade;
use App\Models\Guardian;
use App\Models\Post;
use App\Models\Session;
use App\Models\Student;
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

        Session::creating(static function (Session $session): void {
            $session->institute_id = Auth::user()->institute_id;
        });

        Grade::creating(static function (Grade $grade): void {
            $grade->institute_id = Auth::user()->institute_id;
        });

        Guardian::creating(static function (Guardian $guardian): void {
            $guardian->institute_id = Auth::user()->institute_id;
        });

        Student::creating(static function (Student $student): void {
            $student->institute_id = Auth::user()->institute_id;
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
            Sessions\SessionSchema::class,
            Batches\BatchSchema::class,
            Admissions\AdmissionSchema::class,
        ];
    }
}
