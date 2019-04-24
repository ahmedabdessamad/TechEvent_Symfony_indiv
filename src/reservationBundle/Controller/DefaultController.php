<?php

namespace reservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use techeventBundle\Entity\Event;
use techeventBundle\Entity\Panier;
use techeventBundle\Entity\Reservation;
use techeventBundle\Entity\User;
use techeventBundle\Repository;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@reservation/Default/reservation.html.twig');
    }
    public function AjoutReservationAction(Request $request,$id,$iduser){
        $reservation = new Reservation();
        $event = new Event();
        $User =  new User();
        $event->setId($id);
        $User->setId($iduser);
        echo $iduser;
        if($request->isMethod('POST')){
            $type=$request->get('type');
            $seat=$request->get('seat');
            $quantity = $request->get('quantity');
            $reservation->setType($type);
            $reservation->setSeat($seat);
            $reservation->setQuantite($quantity);
            $reservation->setEvent($event);
            $reservation->setUser($User);


            $idusr = $this->getUser()->getId();
            $panier = $this->getDoctrine()
                ->getManager()
                ->getRepository('techeventBundle:Panier')
                ->findAllOrderedByName($iduser);
            $p = new Panier();
            $p->setId($panier->getId());
            $reservation->setIdpanier($p);
            $em = $this->getDoctrine()->getManager();
            $em->merge($reservation);
            $em->flush();
            echo "reservation ajoutée";
        }
        return $this->render('@reservation/Default/reservation.html.twig');
    }
    public function afficherPanierAction($iduser){
        $idpanier = $this->getDoctrine()
            ->getManager()
            ->getRepository('techeventBundle:Panier')
            ->findAllOrderedByName($iduser);
            //get idpanier
        $ListeDesReservations = $this->getDoctrine()
            ->getManager()
            ->getRepository('techeventBundle:Reservation')
            ->findAllReservationByPanier($idpanier);


            return $this->render('@reservation/Default/afficherPanier.html.twig',['ListeDesReservations' => $ListeDesReservations]);
    }
    public function SupprimerReservationAction($idReservation){
        echo $idReservation;
        $em = $this->getDoctrine()->getEntityManager();
        $entite = $em->getRepository('techeventBundle:Reservation')->find($idReservation);
        $em->remove($entite);
        $em->flush();
        //Affichage
        $iduser = $this->getUser()->getId();
        $idpanier = $this->getDoctrine()
            ->getManager()
            ->getRepository('techeventBundle:Panier')
            ->findAllOrderedByName($iduser);
        //get idpanier
        $ListeDesReservations = $this->getDoctrine()
            ->getManager()
            ->getRepository('techeventBundle:Reservation')
            ->findAllReservationByPanier($idpanier);
        return $this->render('@reservation/Default/afficherPanier.html.twig',['ListeDesReservations' => $ListeDesReservations]);

        //Affichage
    }
    public function ModifierReservationAction($idReservation,$quantite){
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('techeventBundle:reservation')->find($idReservation);
        $reservation->setQuantite($quantite);
        $em->flush();
        //Affichage
        $iduser = $this->getUser()->getId();
        $idpanier = $this->getDoctrine()
            ->getManager()
            ->getRepository('techeventBundle:Panier')
            ->findAllOrderedByName($iduser);
        //get idpanier
        $ListeDesReservations = $this->getDoctrine()
            ->getManager()
            ->getRepository('techeventBundle:Reservation')
            ->findAllReservationByPanier($idpanier);
        return $this->render('@reservation/Default/afficherPanier.html.twig',['ListeDesReservations' => $ListeDesReservations]);

        //Affichage
    }
}
