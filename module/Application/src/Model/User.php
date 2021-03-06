<?php
declare(strict_types=1);


namespace Hotel\Application\Model;


use Hotel\Application\Model\Exception\UserNotExists;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;


class User extends Model
{
    protected $table = 'users';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    public static function fromArray(array $data): self
    {
        $user = new self();

        $user->attributes['id'] = Uuid::uuid4()->toString();

        $user->attributes['email']     = $data['email'];
        $user->attributes['telephone'] = $data['telephone'];

        $user->attributes['first_name'] = $data['first_name'];
        $user->attributes['last_name']  = $data['last_name'];

        $user->save();

        return $user;
    }

    public static function findByEmail(string $email): User
    {
        $user = User::{'where'}('email', '=', $email)->get();

        if ($user->{'isEmpty'}()) {
            throw new UserNotExists();
        }

        return $user->{'first'}();
    }

    public static function findByLoginAndPassword(string $login, string $password): User
    {
        $user = static::{'where'}('login', '=', $login)->first();

        if (!$user) {
            throw new UserNotExists();
        }

        if (!password_verify($password, $user->password)) {
            throw new UserNotExists();
        }

        return $user;
    }

    public function toArray()
    {
        $user = parent::toArray();

        unset($user['password']);
        unset($user['login']);
        unset($user['is_admin']);

        return $user;
    }
}