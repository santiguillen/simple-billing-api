<?php


namespace App\Services;


use App\Entity\App\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function encodePassword(User $user) {

        $encoded = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);

        return $user;
    }
}