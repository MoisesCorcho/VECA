<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

final class AddressService
{
    final public function saveAddress(Model $entity, array $data): Address
    {
        $validatedData = $this->validateAddressData($data);

        if (!method_exists($entity, 'addresses')) {
            throw new \InvalidArgumentException('The entity does not support addresses.');
        }

        if ($entity->addresses()->exists()) {
            $entity->addresses()->update($validatedData);
            return $entity->addresses()->first();
        }

        return $entity->addresses()->create($validatedData);
    }

    final function validateAddressData(array $data): array
    {
        $validator = Validator::make($data, [
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException('Invalid address data: ' . implode(', ', $validator->errors()->all()));
        }

        return $validator->validated();
    }
}
