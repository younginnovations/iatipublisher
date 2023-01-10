<?php

declare(strict_types=1);

namespace App\IATI\Models\User;

use App\IATI\Models\Organization\Organization;
use App\Mail\NewUserEmail;
use Database\Factories\IATI\Models\User\UserFactory;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User.
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'full_name',
        'email',
        'address',
        'organization_id',
        'is_active',
        'is_email_verified',
        'password',
        'role_id',
        'status',
        'language_preference',
        'registration',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Before inbuilt function.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(
            function ($model) {
                if (Auth::check()) {
                    $model->created_by = auth()->user()->id;
                    $model->updated_by = auth()->user()->id;
                }
            }
        );

        static::updating(
            function ($model) {
                if (Auth::check()) {
                    $model->updated_by = auth()->user()->id;
                }
            }
        );
    }

    /**
     * Checks if email is verified.
     *
     * @param $email_verified_at
     *
     * @return bool
     */
    public function isEmailVerified($email_verified_at): bool
    {
        return (bool) $email_verified_at;
    }

    /**
     * @return UserFactory
     */
    public static function newFactory(): UserFactory
    {
        return new UserFactory();
    }

    /**
     * @return BelongsTo
     */
    protected function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    /**
     * Sends verification email to new user.
     */
    public static function sendEmail(): void
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->greeting('Hello ' . $notifiable->full_name)
                ->line('Welcome to IATI Publisher. Your email has been used to create a new account here.
                Please click the button below to verify that you have created the account in it.')
                ->action('Verify Email Address', $url);
        });
    }

    /**
     * Sends password reset email to new user.
     *
     * @param $user
     */
    public static function sendNewUserEmail($user): void
    {
        $mailDetails = [
            'greeting' => 'Hello ' . $user->username,
            'message' => 'Welcome to IATI Publisher. Your email has been used to create a new account here.
            Please click the button below to update the password of your account.',
            'password_update' => true,
            'token' => app('auth.password.broker')->createToken($user),
        ];

        Mail::to($user->email)->send(new NewUserEmail($user, $mailDetails));
    }

    /**
     * Sends verification email to new user.
     *
     * @param $user
     */
    public static function resendEmail($user): void
    {
        $user->sendEmailVerificationNotification();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\IATI\Models\User\Role', 'role_id');
    }
}
