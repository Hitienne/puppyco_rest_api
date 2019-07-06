<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Commande;
use App\Form\CommandeType;
/**
 * Commande controller.
 * @Route("/commande", name="commande")
 */
class CommandeController extends FOSRestController
{
/**
   * Lists all Commande.
   * @Rest\Get("/")
   *
   * @return Response
   */
public function getCommandeAction()
  {
    $repository = $this->getDoctrine()->getRepository(Commande::class);
    $commandes = $repository->findall();
    return $this->handleView($this->view($commandes));
  }

  /**
   * Create Commande.
   * @Rest\Post("/")
   *
   * @return Response
   */
public function postCommandeAction(Request $request)
    {
    $commande= new Commande();
    //créé la fonction qui alimente l'objet avec les données de la requête.
    $form = $this -> createForm(CommandeType::class, $commande);
    $data =json_decode($request->getContent(), true);
    $form->submit($data);

    if ($form->isSubmitted() && $form->isValid()) {
    $em = $this->getDoctrine()->getManager();
    $em->persist($commande);
    $em->flush();
    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors()));
    }

}
