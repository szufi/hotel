<?php
declare(strict_types=1);


namespace Hotel\Application\Model;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class Reservation extends Model
{
    protected $table = 'reservations';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    public static function fromArray(array $data): self
    {
        $reservation = new self();

        $reservation->attributes['id'] = Uuid::uuid4()->toString();

        $reservation->attributes['user_id']      = $data['user_id'];
        $reservation->attributes['apartment_id'] = $data['apartment_id'];

        $reservation->attributes['date_start'] = $data['date_start'];
        $reservation->attributes['date_end']   = $data['date_end'];

        $reservation->attributes['price']  = 1;
        $reservation->attributes['status'] = 'NEW';

        $reservation->attributes['created_at'] = new \DateTime('now');

        $reservation->save();

        return $reservation;
    }

    public static function isAvailable(string $apartmentId, string $start, string $end): bool
    {
        return !static::{'where'}(
            function (Builder $query) use ($start, $end, $apartmentId) {
                return $query
                    ->where('date_end', '>=', $start)
                    ->where('date_start', '<=', $end)
                    ->where('apartment_id', '=', $apartmentId);
            }
        )->exists();
    }

    public static function findAllByPeriod(string $start, string $end)
    {
        return static::{'where'}(
            function (Builder $query) use ($start, $end) {
                return $query
                    ->where('date_end', '>', $start)
                    ->where('date_start', '<', $end)
                    ->where('status', '!=', "CANCELLED");
            }
        )->get();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }

    public function hasExpired(): bool
    {
        $now       = new \DateTime('now');
        $createdAt = new \DateTime($this->getAttribute('created_at'));

        $interval = $now->diff($createdAt);

        return $interval->days >= 7;
    }
}