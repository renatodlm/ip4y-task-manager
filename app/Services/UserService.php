<?php

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use App\Interfaces\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all users.
     *
     * @return mixed
     */
    public function get_all_users()
    {
        return $this->userRepository->all();
    }
}
