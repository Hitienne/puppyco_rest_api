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
   * @Rest\Get("/clients")
   *
   * @return Response
   */
  public function getClientAction()
  {
    $repository = $this->getDoctrine()->getRepository(Client::class);
    $clients = $repository->findall();
    return $this->handleView($this->view($clients));
  }
}