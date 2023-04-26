<?php

declare(strict_types=1);

namespace App\IATI\Models\User;

use App\IATI\Models\Organization\Organization;
use App\IATI\Services\Download\DownloadXlsService;
use App\Mail\NewUserEmail;
use Carbon\Carbon;
use App\Mail\XlsDownloadMail;
use Database\Factories\IATI\Models\User\UserFactory;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class User.
 */
class User extends Authenticatable implements MustVerifyEmail, Auditable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, \OwenIt\Auditing\Auditable;

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
        'email_verified_at',
        'password',
        'role_id',
        'status',
        'language_preference',
        'registration',
        'migrated_from_aidstream',
        'created_at',
        'updated_at',
        'last_logged_in',
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
        'is_active' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * Before inbuilt function.
     *
     * @return void
     */
    protected static function boot(): void
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
     * Informs xls download completion user through mail and updates download status table.
     *
     * @param $email
     * @param $username
     * @param $statusId
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    public static function sendXlsDownloadLink($email, $username, $statusId): void
    {
        $downloadXlsService = app()->make(DownloadXlsService::class);
        $mailDetails = [
            'greeting' => 'Hello ' . $username,
            'message' => 'Your Xls Files are ready for download.',
        ];
        Mail::to($email)->send(new XlsDownloadMail($mailDetails));
        $downloadStatusData = [
            'status' => 'completed',
        ];
        $downloadXlsService->updateDownloadStatus($statusId, $downloadStatusData);
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
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo('App\IATI\Models\User\Role', 'role_id');
    }

    /**
     * Encrypt when user model is audited.
     *
     * {@inheritdoc}
     */
    public function transformAudit(array $data): array
    {
        if ($data['old_values']) {
            foreach ($data['old_values'] as $key => $val) {
                $data['old_values'][$key] = Crypt::encryptString($val);
            }
        }

        if ($data['new_values']) {
            foreach ($data['new_values'] as $key => $val) {
                $data['new_values'][$key] = Crypt::encryptString($val);
            }
        }

        return $data;
    }

//    public function scopeRegisteredToday($query)
//    {
//        return $query->whereDate('created_at', Carbon::today());
//    }
//
//
//
//    public function scopeRegisteredThisWeek($query)
//    {
//        $date        = Carbon::now();
//        $startOfWeek = $date->startOfWeek(0)->format('Y-m-d');
//        $endOfWeek   = $date->endOfWeek(6)->format('Y-m-d');
//
//        $query->selectRaw("TO_CHAR(created_at, 'YYYY-MM-DD') AS date_string, COUNT(*) AS count_value")
//            ->whereDate('created_at', '>=' ,$startOfWeek)
//            ->whereDate('created_at', '<=' ,$endOfWeek)
//            ->groupBy('date_string');
//
//        return $query;
//    }
//
//    public function scopeRegisteredThisMonth($query)
//    {
//        $date = Carbon::now();
//        $startOfMonth = $date->startOfMonth()->format('Y-m-d');
//        $endOfMonth = $date->endOfMonth()->format('Y-m-d');
//
//        $query->selectRaw("TO_CHAR(created_at, 'YYYY-MM-DD') AS date_string, COUNT(*) AS count_value")
//            ->whereDate('created_at', '>=', $startOfMonth)
//            ->whereDate('created_at', '<=', $endOfMonth)
//            ->groupBy('date_string');
//
//        return $query;
//    }
//
//    public function scopeRegisteredThisYear($query)
//    {
//        $query->selectRaw("TO_CHAR(created_at, 'YYYY-MM') AS date_string, COUNT(*) AS count_value")
//            ->whereYear('created_at', Carbon::now()->year)
//            ->groupBy('date_string');
//
//        return $query;
//    }
//    public function scopeRegisteredLast7Days($query)
//    {
//        return $query->whereDate('created_at', '>=', Carbon::now()->subDays(7))
//            ->groupBy('created_at');
//    }
//
//    public function scopeRegisteredLast6Months($query)
//    {
//        $currentDate = Carbon::now();
//        $weekStartDate = $currentDate->startOfWeek();
//        $weekEndDate = $currentDate->today();
//        return $query->whereBetween('created_at', [$weekStartDate, $weekEndDate]);
//    }
//
//    public function scopeRegisteredLast12Months($query)
//    {
//        return $query->whereDate('created_at', '>=', Carbon::now()->subMonths(12))
//            ->groupBy('MONTH(created_at)');
//    }
//
//    public function scopeRegisteredInDateRange($query, $startDate, $endDate, $interval = 'Y')
//    {
//    }
}
