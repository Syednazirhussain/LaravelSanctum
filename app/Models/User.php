<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;

use App\Notifications\VerifyEmail;
use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Illuminate\Notifications\Notification as BaseNotification;

use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'password' => 'hashed',
    ];

    protected $appends = ['img_url'];

    public function getImgUrlAttribute()
    {
        return $this->profile->profile_img ? asset('storage/' . $this->profile->profile_img) : null;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Route notifications for the Vonage channel.
     */
    public function routeNotificationForVonage(BaseNotification $notification): string
    {
        return $this->phone ? $this->phone->code . $this->phone->number : '';
    }

    /**
     * Get all of the user's notifications.
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(\App\Models\Notification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get all of the user's read notifications.
     */
    public function readNotifications()
    {
        return $this->notifications()->whereNotNull('read_at');
    }

    /**
     * Get all of the user's unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }

    /**
     * Get the device tokens for the user.
     */
    public function deviceTokens(): HasMany
    {
        return $this->hasMany(DeviceToken::class, 'user_id', 'id');
    }

    /**
     * Get the device tokens for the user filtered by type.
     *
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDeviceTokensByType($type)
    {
        return $this->deviceTokens()->ofType($type)->get();
    }

    /**
     * Delete all device tokens for the user.
     *
     * @return void
     */
    public function deleteDeviceTokens()
    {
        $this->deviceTokens()->delete();
    }

    /**
     * Add a new device token for the user.
     *
     * @param string $type
     * @param string $token
     * @return \App\Models\DeviceToken
     */
    public function addDeviceToken($type, $token)
    {
        return $this->deviceTokens()->create([
            'type' => $type,
            'token' => $token,
        ]);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }

    public function phone(): HasOne
    {
        return $this->hasOne(Phone::class)->where('active', true);
    }

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class)->where('active', true);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

}
