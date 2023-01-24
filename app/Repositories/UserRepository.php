<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method User|null create(array $properties, bool $reselect = false)
 * @method User|null find(int $id, array $columns = ['*'], array $with = [])
 * @method User|null first(array $wheres, array $columns = ['*'], array $order = ['id', 'ASC'], array $with = [])
 */
class UserRepository extends AbstractRepository
{
    protected static string $model = User::class;

    /**
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): User|null
    {
        return $this->query()
            ->where('email', $email)
            ->get()
            ->first();
    }

    /**
     * @param string $googleId
     * @return bool
     */
    public function existsGoogleId(string $googleId): bool
    {
        return $this->query()
            ->where('google_id', $googleId)
            ->exists();
    }

    /**
     * @param array $columns
     * @return Collection
     */
    public function getAllUsers(array $columns = ['*']): Collection
    {
        return $this->query()
            ->get($columns);
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool|int
     */
    public function update(array $data, int $id): bool|int
    {
       return $this->query()
            ->find($id)
            ->update($data);
    }

    /**
     * @param int $id
     * @return void
     */
    public function makeOTPVerified(int $id): void
    {
        $this->query()
            ->where('id','=', $id)
            ->update(['otp_verify' => true]);
    }

    /**
     * @param int $id
     * @return void
     */
    public function makeOTPUnVerified(int $id): void
    {
        $this->query()
            ->where('id','=', $id)
            ->update(['otp_verify' => false]);
    }
}
