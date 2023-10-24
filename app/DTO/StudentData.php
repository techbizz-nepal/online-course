<?php

namespace App\DTO;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentData
{
    const SYSTEM_PATH = 'app/public/files/students';
    const PUBLIC_PATH = 'storage/files/students';
    public function __construct(
        public string $first_name,
        public string $surname,
        public string $email,
        public string $dob,
        public string $gender,
        public string $mobile,
        public string $flat_details,
        public string $street_name,
        public string $suburb,
        public string $post,
    )
    {
    }

    public const DEFAULT_PASSWORD = 'student123';

    public function getName(): string
    {
        return sprintf("%s %s", $this->first_name, $this->surname);
    }

    public function getSlug(): string
    {
        return Str::slug($this->getName());
    }

    private function getPassword(): string
    {
        return Hash::make(self::DEFAULT_PASSWORD);
    }

    /**
     * it return an array suitable for inserting to Student Model
     *
     * @return array
     */
    public function getStudentRow(): array
    {
        return [
            'name' => $this->getName(),
            'email' => $this->email,
            'key' => $this->getSlug(),
            'username' => $this->getSlug(),
            'password' => $this->getPassword(),
        ];
    }
}
