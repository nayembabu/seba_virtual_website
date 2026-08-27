<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = [
        'user_id', 'subject', 'msg', 'priority', 'photo', 'status',
    ];

    // Define status constants
    const STATUS_PENDING = 'pending';
    const STATUS_WAITING_CUSTOMER_REPLY = 'waiting_for_customer_reply';
    const STATUS_CLOSED = 'closed';
    const STATUS_HOLD = 'hold';
    const STATUS_PROCESSING = 'processing';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(SupportReply::class);
    }

    // Get a human-readable label for the status
    public function getStatusLabel()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'Pending';
            case self::STATUS_WAITING_CUSTOMER_REPLY:
                return 'Waiting for Customer Reply';
            case self::STATUS_CLOSED:
                return 'Closed';
            case self::STATUS_HOLD:
                return 'On Hold';
            case self::STATUS_PROCESSING:
                return 'Processing';
            default:
                return 'Unknown';
        }
    }
}
