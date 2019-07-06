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
   * @Rest\Get("/")
   *
   * @return Response
   */
  public function getClientsAction()
  {
    $repository = $this->getDoctrine()->getRepository(Client::class);
    $clients = $repository->findall();
    return $this->handleView($this->view($clients));
  }

  /**
   * get a Client.
   * @Rest\Get("/{id}")
   *
   * @return Response
   */
  public function getClientAction($id)
  {
    $repository = $this->getDoctrine()->getRepository(Client::class);
    $client = $repository->find($id);
    if(!$client){
      throw $this->createNotFoundException(
        'Ce client n\'existe pas.'
      );
    }
    return $this->handleView($this->view($client));
  }

  /**
   * Create Client.
   * @Rest\Post("/")
   *
   * @return Response
   */
  public function postClientAction(Request $request)
  {
    $algo = "sha256";
    $client= new Client();
    //créé la fonction qui alimente l'objet avec les données de la requête.
    $form = $this -> createForm(ClientType::class, $client);
    $data =json_decode($request->getContent(), true);
    $data['password'] = hash ($algo, $data['password']);
    $form->submit($data);
  
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($client);
      $em->flush();
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors()));
  }
  /**
   * Update Client.
   * @Rest\Put("/{id}")
   *
   * @return Response
   */
  public function updateClientAction($id,Request $request){
    $repository = $this->getDoctrine()->getRepository(Client::class);
    $client = $repository->find($id);
    if(!$client){
      throw $this->createNotFoundException(
        'Ce client n\'existe pas.'
      );
    }
    $data = json_decode($request->getContent(),true);
    $form = $this->createForm(ClientType::class,$client);
    $form->submit($data);

    if(!$form->isSubmitted() && !$form->isValid()){
      return $this->handleView($this->view($form->getErrors()));
    }
    
    $em = $this->getDoctrine()->getManager();
    $em->persist($client);
    $em->flush();

    return $this->handleView($this->view($client));
  }
  /**
   * Delete Client.
   * @Rest\Delete("/{id}")
   *
   * @return Response
   */
  public function deleteClientAction($id){
    $repository = $this->getDoctrine()->getRepository(Client::class);
    $client = $repository->find($id);
    if(!$client){
      throw $this->createNotFoundException(
        'Ce client n\'existe pas.'
      );
    } 
    $em = $this->getDoctrine()->getManager();
    $em->remove($client);
    $em->flush();
    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
  }
}