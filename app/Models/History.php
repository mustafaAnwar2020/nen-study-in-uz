<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public static function makeHistory($user, $performed_on_model, $action, $object_id = null, $created_by_model = 'User', $extra_data = null): bool
    {
        $history = new History();
        $history->user_id = $user->id;
        $history->performed_on_model = $performed_on_model;
        $history->action = $action;
        $history->object_id = $object_id;
        $history->extra_data = $extra_data;
        $history->created_by_model = $created_by_model;
        return $history->save();
    }

    public function getModelRowName($neededModel = null): string
    {
        $objectId = $neededModel ? $this->user_id : $this->pobject_id;

        $model = match ($neededModel ?? $this->performed_on_model) {
            'User' => User::find($objectId),
            'Company' => Company::find($objectId),
            'Car' => Car::find($objectId),
            'Provider' => Provider::find($objectId),
            default => null,
        };

        $attribute = $this->getAttributeBasedOnModel($neededModel ?? $this->performed_on_model);

        return optional($model)->$attribute ?? '';
    }

    private function getAttributeBasedOnModel(string $model): string
    {
        $attributeMapping = [
            'User' => 'name',
            'Company' => 'name',
            'Provider' => 'name',
            'Car' => 'license_plate',
        ];

        return $attributeMapping[$model] ?? '';
    }

    public function getCreatedUserModelRowName()
    {
        return $this->getModelRowName($this->created_by_model);
    }


}
