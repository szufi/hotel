<?php
declare(strict_types=1);

namespace Hotel\Application\Model;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Apartment extends Model
{
    protected $table = 'apartments';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    public static function fromArray(array $data): self
    {
        $apartment = new self();

        $apartment->attributes['id'] = Uuid::uuid4()->toString();

        $apartment->attributes['type']        = $data['type'];
        $apartment->attributes['description'] = $data['description'];

        $apartment->attributes['number']      = $data['number'];
        $apartment->attributes['rooms_count'] = $data['rooms_count'];
        $apartment->attributes['beds_count']  = $data['beds_count'];

        $apartment->attributes['price'] = $data['price'];

        return $apartment;
    }

    public function exists(): bool
    {
        return static::{'where'}(
            function (Builder $query) {
                return $query
                    ->where('id', '=', $this->attributes['id'])
                    ->orWhere('number', '=', $this->attributes['number']);
            }
        )->exists();
    }

    public static function findAllAvailable(string $start, string $end)
    {
        $reservations = Reservation::findAllByPeriod($start, $end);

        foreach ($reservations as $reservation) {
            $ids[$reservation->apartment_id] = true;
        }

        if (!isset($ids)) {
            return Apartment::all();
        }

        $collection = static::{'whereNotIn'}('id', array_keys($ids ?? []))->get();

        $start = new \DateTime($start);
        $end   = new \DateTime($end);

        $days = (int)$end->diff($start)->format('%d');

        foreach ($collection as $apartment) {
            $apartment->price *= $days;
        }

        return $collection;
    }
}