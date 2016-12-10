<?php
namespace SleepingOwl\Api\Transformers;

use SleepingOwl\Api\Transformer;
use SleepingOwl\Framework\Entities\UserMeta as UserMetaEntity;

class UserMeta extends Transformer
{
    /**
     * @param UserMetaEntity $meta
     *
     * @return array
     */
    public function transform(UserMetaEntity $meta)
    {
        return [
            'id' => $meta->user_id,
            'key' => $meta->key,
            'data' => $meta->data
        ];
    }
}