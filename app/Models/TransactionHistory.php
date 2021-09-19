<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class TransactionHistory
 *
 * @package App\Models
 */
class TransactionHistory extends Model
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id', 'method', 'amount', 'user_id', 'transaction_type', 'withdrawal_request_status'
    ];

    /**
     * has one relation with user table
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
