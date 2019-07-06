<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Produit;
use App\Form\ProduitType;
/**
 * Produit controller.
 * @Route("/produit", name="produit")
 */
class ProduitController extends FOSRestController
{
/**
   * Lists all Produit.
   * @Rest\Get("/")
   *
   * @return Response
   */
public function getProduitAction()
  {
    $repository = $this->getDoctrine()->getRepository(Produit::class);
    $produits = $repository->findall();
    return $this->handleView($this->view($produits));
  }
/**
   * get a Produit.
   * @Rest\Get("/{id}")
   *
   * @return Response
   */
  public function getProduitAction($id)
  {
    $repository = $this->getDoctrine()->getRepository(Produit::class);
    $produit = $repository->find($id);
    if(!$produit){
      throw $this->createNotFoundException(
        'Ce produit n\'existe pas.'
      );
    }
    return $this->handleView($this->view($produit));
  }
  /**
   * Create Produit.
   * @Rest\Post("/")
   *
   * @return Response
   */
public function postProduitAction(Request $request)
    {
    $produit= new Produit();
    //créé la fonction qui alimente l'objet avec les données de la requête.
    $form = $this -> createForm(ProduitType::class, $produit);
    $data =json_decode($request->getContent(), true);
    $form->submit($data);

    if ($form->isSubmitted() && $form->isValid()) {
    $em = $this->getDoctrine()->getManager();
    $em->persist($produit);
    $em->flush();
    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors()));
    }
    /**
   * Update Produit.
   * @Rest\Put("/{id}")
   *
   * @return Response
   */
  public function updateProduitAction($id,Request $request){
    $repository = $this->getDoctrine()->getRepository(Produit::class);
    $produit = $repository->find($id);
    if(!$produit){
      throw $this->createNotFoundException(
        'Ce produit n\'existe pas.'
      );
    }
    $data = json_decode($request->getContent(),true);
    $form = $this->createForm(ProduitType::class,$produit);
    $form->submit($data);

    if(!$form->isSubmitted() && !$form->isValid()){
      return $this->handleView($this->view($form->getErrors()));
    }
    
    $em = $this->getDoctrine()->getManager();
    $em->persist($produit);
    $em->flush();

    return $this->handleView($this->view($produit));
  }
  /**
   * Delete Produit.
   * @Rest\Delete("/{id}")
   *
   * @return Response
   */
  public function deleteProduitAction($id){
    $repository = $this->getDoctrine()->getRepository(Produit::class);
    $produit = $repository->find($id);
    if(!$produit){
      throw $this->createNotFoundException(
        'Ce produit n\'existe pas.'
      );
    } 
    $em = $this->getDoctrine()->getManager();
    $em->remove($produit);
    $em->flush();
    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
  }
}
