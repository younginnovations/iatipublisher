<?php

declare(strict_types=1);

namespace App\IATI\Models\User;

use App\IATI\Models\Organization\Organization;
use Database\Factories\IATI\Models\User\UserFactory;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User.
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

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
     * Checks if email is verified.
     *
     * @param $email_verified_at
     *
     * @return bool
     */
    public function isEmailVerified($email_verified_at): bool
    {
        return $email_verified_at ? true : false;
    }

    public static function newFactory()
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
     *
     * @param $user
     */
    public static function sendEmail($user): void
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
     * Sends verification email to new user.
     *
     * @param $user
     */
    public static function resendEmail($user): void
    {
        $user->sendEmailVerificationNotification();
    }
}
