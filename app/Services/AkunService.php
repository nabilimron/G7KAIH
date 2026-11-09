<?php

namespace App\Services;

use App\Models\User;

class AkunService{
    public function __construct(private string $statusAwal = 'aktif'){
    }

    public function buat(array $data): User{
        $data['status'] = $data['status'] ?? $this->statusAwal;

        $user = new User($data);
        $user->save();

        return $user;
    }
}