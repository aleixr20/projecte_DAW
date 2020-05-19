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

        $query1 = 'SET GLOBAL event_scheduler=ON;';
        $query2 = 'CREATE EVENT '.'autodestroy_token'.$shortToken.' 
                        ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 HOUR
                        DO UPDATE user
                        SET token = NULL
                        WHERE id = :id;';
        
        $statement1 = $entityManager->getConnection()->prepare($query1);
        $statement2 = $entityManager->getConnection()->prepare($query2);

        $statement2->bindValue('id', $user->getId());

        $statement1->execute();
        $statement2->execute();
    }
}