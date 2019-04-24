<?php
namespace techeventBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ReservationRepository extends EntityRepository
{
public function findAllReservationByPanier($idpanier)
{

return $this->getEntityManager()
->createQuery(
'SELECT r FROM techeventBundle:reservation r WHERE r.idpanier = :idpanier'
)->setParameter('idpanier',$idpanier)
->getResult();
}
}
