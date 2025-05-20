<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory, HasUuid;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    protected $table = 'otps';

    protected $casts = [
        'otp_code' => 'encrypted',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
