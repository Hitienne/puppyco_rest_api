<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Client;
use App\Form\ClientType;
/**
 * Client controller.
 * @Route("/client", name="client_")
 */
class ClientController extends FOSRestController
{
  /**
   * Lists all Client.
<<<<<<< HEAD
   * @Rest\Get("/")
=======
   * @Rest\Get("/clients")
>>>>>>> 60aca691e2d2431ab563129481216aaf458da631
   *
   * @return Response
   */
  public function getClientAction()
  {
    $repository = $this->getDoctrine()->getRepository(Client::class);
    $clients = $repository->findall();
    return $this->handleView($this->view($clients));
  }

  /**
   * Create Client.
   * @Rest\Post("/")
   *
   * @return Response
   */
  public function postClientAction(Request $request)
  {
    $client= new Client();
    //créé la fonction qui alimente l'objet avec les données de la requête.
    $form = $this -> createForm(ClientType::class, $client);
    $data =json_decode($request->getContent(), true);
    $form->submit($data);
  
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($client);
      $em->flush();
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors()));
  }
}