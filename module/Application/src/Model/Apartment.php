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

        $apartment->attributes       = $data;
        $apartment->attributes['id'] = Uuid::uuid4()->toString();

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

        if(!isset($ids)) {
            return Apartment::all();
        }

        return static::{'whereNotIn'}('id', array_keys($ids ?? []))->get();
    }
}