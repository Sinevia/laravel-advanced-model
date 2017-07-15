<?php

class BaseModel extends \Illuminate\Database\Eloquent\Model {

    public $incrementing = false;
    public $timestamps = true;
    public $useUuid = false;
    public $useUniqueId = false;

    /**
     * The name of the "created at" column.
     * @var string
     */
    const CREATED_AT = 'CreatedAt';

    /**
     * The name of the "updated at" column.
     * @var string
     */
    const UPDATED_AT = 'UpdatedAt';

    /**
     * The name of the "deleted at" column.
     * @var string
     */
    const DELETED_AT = 'DeletedAt';

    public static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if ($model->incrementing == false) {
                return;
            }
            if ($model->useUuid) {
                $model->{$model->getKeyName()} = $model->generateUuid();
            }
            if ($model->useUniqueId) {
                $model->{$model->getKeyName()} = $model->generateUniqueId();
            }
        });
    }

    private function generateUniqueId() {
        return date('YmdHis') . substr(explode(" ", microtime())[0], 2, 6);
    }

    function generateUuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

}