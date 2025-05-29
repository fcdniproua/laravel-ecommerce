<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $status
 * @property float $total_amount
 * @property string $customer_name
 * @property string $customer_email
 * @property string $customer_phone
 * @property string $shipping_method
 * @property string $payment_method
 * @property string|null $shipping_address
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User|null $user
 * @property-read Collection<OrderItem> $items
 */
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'total_amount',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_method',
        'payment_method',
        'shipping_address',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public const STATUS_NEW = 'new';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';

    public const SHIPPING_PICKUP = 'pickup';
    public const SHIPPING_POSTAL = 'postal';

    public const PAYMENT_COD = 'cod';
    public const PAYMENT_ONLINE = 'online';

    public static array $statuses = [
        self::STATUS_NEW => 'Новый',
        self::STATUS_PROCESSING => 'В обработке',
        self::STATUS_COMPLETED => 'Завершен',
    ];

    public static array $shippingMethods = [
        self::SHIPPING_PICKUP => 'Самовывоз',
        self::SHIPPING_POSTAL => 'Почтовая доставка',
    ];

    public static array $paymentMethods = [
        self::PAYMENT_COD => 'Наложенный платеж',
        self::PAYMENT_ONLINE => 'Онлайн оплата',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
