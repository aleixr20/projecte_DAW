<?php

namespace App\Service;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Error;


class QueryBuilder
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function autoDestroyToken($user)
    {

        $shortToken = substr($user->getToken(), 0, 10);
        $entityManager = $this->entityManager;

        $query = 'CREATE EVENT '.'autodestroy_token'.$shortToken.' 
                        ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 HOUR
                        DO UPDATE user
                        SET token = NULL
                        WHERE id = :id;';

        $statement = $entityManager->getConnection()->prepare($query);

        $statement->bindValue('id', $user->getId());

        $statement->execute();
    }
}