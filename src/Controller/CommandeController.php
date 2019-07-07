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
public function getCommandesAction()
  {
    $repository = $this->getDoctrine()->getRepository(Commande::class);
    $commandes = $repository->findall();
    return $this->handleView($this->view($commandes));
  }
 /**
   * get a Commande.
   * @Rest\Get("/{id}")
   *
   * @return Response
   */
  public function getCommandeAction($id)
  {
    $repository = $this->getDoctrine()->getRepository(Commande::class);
    $commande = $repository->find($id);
    if(!$commande){
      throw $this->createNotFoundException(
        'Ce commande n\'existe pas.'
      );
    }
    return $this->handleView($this->view($commande));
  }

  /**
   * Create Commande.
   * @Rest\Post("/")
   *
   * @return Response
   */
public function postCommandeAction(Request $request, \Swift_Mailer $mailer)
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

      $prix = 0;

      foreach($commande->getIdProduit() as $produit){
        $prix += $produit->getPrix();
      }
      
      $message = (new \Swift_Message('Test'))
        ->setSubject('Recapitulatif de commande : ' . $commande->getId())
        ->setFrom('noreply@puppyco.com')
        ->setTo($commande->get)
        ->setBody(
          $this->renderView(
            'emails/commande.html.twig',
            [
              'commande' => $commande,
              'prix' => $prix
            ]
          ),
          'text/html'
        );
      $mailer->send($message);

      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors()));
    }

    /**
   * Update Commande.
   * @Rest\Put("/{id}")
   *
   * @return Response
   */
  public function updateCommandeAction($id,Request $request){
    $repository = $this->getDoctrine()->getRepository(Commande::class);
    $commande = $repository->find($id);
    if(!$commande){
      throw $this->createNotFoundException(
        'Cette commande n\'existe pas.'
      );
    }
    $data = json_decode($request->getContent(),true);
    $form = $this->createForm(CommandeType::class,$commande);
    $form->submit($data);

    if(!$form->isSubmitted() && !$form->isValid()){
      return $this->handleView($this->view($form->getErrors()));
    }
    
    $em = $this->getDoctrine()->getManager();
    $em->persist($commande);
    $em->flush();

    return $this->handleView($this->view($client));
  }
  /**
   * Delete Commande.
   * @Rest\Delete("/{id}")
   *
   * @return Response
   */
  public function deleteCommandeAction($id){
    $repository = $this->getDoctrine()->getRepository(Commande::class);
    $commande = $repository->find($id);
    if(!$commande){
      throw $this->createNotFoundException(
        'Cette commande n\'existe pas.'
      );
    } 
    $em = $this->getDoctrine()->getManager();
    $em->remove($commande);
    $em->flush();
    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
  }
}
