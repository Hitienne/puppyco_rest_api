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
 * Categorie controller.
 * @Route("/produit", name="produit")
 */
class ProduitController extends FOSRestController
{
/**
   * Lists all Produit
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
   * Create Produits.
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

}
