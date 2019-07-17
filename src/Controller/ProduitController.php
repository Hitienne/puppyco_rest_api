<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Entity\Categorie;

/**
 * Produit controller.
 * @Route("/produit", name="produit")
 */
class ProduitController extends AbstractFOSRestController
{
/**
   * Lists all Produit.
   * @Rest\Get("/")
   *
   * @return Response
   */
public function getProduitsAction()
  {
    $repository = $this->getDoctrine()->getRepository(Produit::class);
    $produits = $repository->findall();
    return $this->handleView($this->view($produits));
  }
/**
   * get a Produit.
   * @Rest\Get("/produit/{id}")
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
   * get a ProduitRecherche.
   * @Rest\Get("/recherche/{produitRecherche}")
   *
   * @return Response
   */
  public function getProduitRechercheAction($produitRecherche)
  {
    $repository = $this->getDoctrine()->getRepository(Produit::class);
    $query = $repository
    ->createQueryBuilder('y')
    ->select('y')
    ->where('y.titre LIKE :titre OR y.description like :titre')
    ->setParameter('titre', '%'.$produitRecherche.'%')
    ->orderBy('y.titre', 'DESC')
    ->getQuery()
    ->getResult();
    return $this->handleView($this->view($query));
  }

  /**
   * Get Random Produits.
   * @Rest\Get("/random")
   *
   * @return Response
   */
public function getRandomProduitAction(Request $request){
  $repository = $this->getDoctrine()->getRepository(Produit::class);
  $query = $repository
    ->createQueryBuilder('y')
    ->select('y')
    ->orderBy('RAND()')
    ->setMaxResults(6)
    ->getQuery()
    ->getResult();
  return $this->handleView($this->view($query));
}
  /**
   * Create Produit.
   * @Rest\Post("/")
   *
   * @return Response
   */
public function postProduitAction(Request $request){
    $produit= new Produit();
    //créé la fonction qui alimente l'objet avec les données de la requête.
    $form = $this -> createForm(ProduitType::class, $produit);
    $data =json_decode($request->getContent(), true);
    $form->submit($data);
    $produit->setImages($data['images']);
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
  
  /**
   * Delete Produit.
   * @Rest\Get("/categorie/{id}")
   *
   * @return Response
  */
  public function getProduitByCategorieAction($id){
    $repository = $this->getDoctrine()->getRepository(Produit::class);
    $catRepo = $this->getDoctrine()->getRepository(Categorie::class);
    $cat = $catRepo->find($id);
    if(!$cat){
      throw $this->createNotFoundException(
        'Cette categorie n\'existe pas.'
      );
    }
    $produits = $repository->findBy(['idCategorie' => $id]);
    return $this->handleView($this->view($produits));

  }
}
