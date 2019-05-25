<?php
declare(strict_types=1);

namespace Hotel\Application\Test\Model\User;


use Hotel\Application\Model\User;
use Hotel\Application\Test\TestCase;
use Ramsey\Uuid\Uuid;

class UserTest extends TestCase
{
    public function testItCreatesFromArray(): void
    {
        $data = [
            'email'     => Uuid::uuid4()->toString() . '@test.pl',
            'telephone' => '123456789',

            'first_name' => 'Foo',
            'last_name'  => 'Bar'
        ];

        $created = User::fromArray($data);
        /** @var User $found */
        $found = User::{'find'}($created->getAttribute('id'));

        self::assertEquals($created->toArray(), $found->toArray());
    }
}