<?php
namespace SleepingOwl\Api\Transformers;

use SleepingOwl\Api\Transformer;
use SleepingOwl\Framework\Entities\User as UserEntity;

class User extends Transformer
{
    /**
     * @param UserEntity $user
     *
     * @return array
     */
    public function transform(UserEntity $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return 'user';
    }
}