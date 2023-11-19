<?php

namespace App\DTO;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class StudentData extends Data
{
    public const SYSTEM_PATH = 'app/public/files/students';

    public const PUBLIC_PATH = 'storage/files/students';

    public function __construct(
        public Optional|string      $id,
        public string               $title,
        public string               $first_name,
        public string               $surname,
        public string               $email,
        public string               $dob,
        public string               $gender,
        public string               $mobile,
        public Optional|string|null $pdf,
        public Optional|string|null $home_phone,
        public Optional|string|null $work_phone,
        public Optional|string|null $flat_unit,
        public Optional|string|null $street,
        public Optional|string|null $locality,
        public Optional|string|null $post_code,
        public Optional|string|null $state,
        public Optional|string|null $relation,
        public Optional|string|null $emergency_home_phone,
        public Optional|string|null $emergency_work_phone,
        public Optional|string|null $emergency_mobile,
    )
    {
    }

    public const DEFAULT_PASSWORD = 'student123';

    public function getName(): string
    {
        return sprintf('%s %s', $this->first_name, $this->surname);
    }

    public function getSlug(): string
    {
        $withRandomString = sprintf("%s%s", $this->getName(), Str::random(6));
        return Str::slug($withRandomString);
    }

    private function getPassword(): string
    {
        return Hash::make(self::DEFAULT_PASSWORD);
    }

    /**
     * it return an array suitable for inserting to Student Model
     */
    public function getStudentRow(): array
    {
        return [
            'title' => $this->title,
            'first_name' => $this->first_name,
            'surname' => $this->surname,
            'email' => $this->email,
            'key' => $this->getSlug(),
            'username' => $this->getSlug(),
            'password' => $this->getPassword(),
        ];
    }
}
