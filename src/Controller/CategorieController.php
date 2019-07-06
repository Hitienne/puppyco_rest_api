<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Categorie;
use App\Form\CategorieType;
/**
 * Categorie controller.
 * @Route("/categorie", name="categorie")
 */
class CategorieController extends FOSRestController
{
/**
   * Lists all Categorie.
   * @Rest\Get("/")
   *
   * @return Response
   */
public function getCategoriesAction()
  {
    $repository = $this->getDoctrine()->getRepository(Categorie::class);
    $categories = $repository->findall();
    return $this->handleView($this->view($categories));
  }

   /**
   * get a Categorie.
   * @Rest\Get("/{id}")
   *
   * @return Response
   */
  public function getCategorieAction($id)
  {
    $repository = $this->getDoctrine()->getRepository(Categorie::class);
    $categorie = $repository->find($id);
    if(!$categorie){
      throw $this->createNotFoundException(
        'Cette catégorie n\'existe pas.'
      );
    }
    return $this->handleView($this->view($categorie));
  }

  /**
   * Create Categorie.
   * @Rest\Post("/")
   *
   * @return Response
   */
public function postCategorieAction(Request $request)
    {
    $categorie= new Categorie();
    //créé la fonction qui alimente l'objet avec les données de la requête.
    $form = $this -> createForm(CategorieType::class, $categorie);
    $data =json_decode($request->getContent(), true);
    $form->submit($data);

    if ($form->isSubmitted() && $form->isValid()) {
    $em = $this->getDoctrine()->getManager();
    $em->persist($categorie);
    $em->flush();
    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors()));
    }

     /**
   * Update Categorie.
   * @Rest\Put("/{id}")
   *
   * @return Response
   */
public function updateCategorieAction($id,Request $request)
    {
    $repository = $this->getDoctrine()->getRepository(Categorie::class);
    $categorie = $repository->find($id);
    if(!$categorie){
      throw $this->createNotFoundException(
        'Cette catégorie n\'existe pas.'
      );
    }
    $data = json_decode($request->getContent(),true);
    $form = $this->createForm(CategorieType::class,$categorie);
    $form->submit($data);

    if(!$form->isSubmitted() && !$form->isValid()){
      return $this->handleView($this->view($form->getErrors()));
    }
    
    $em = $this->getDoctrine()->getManager();
    $em->persist($categorie);
    $em->flush();

    return $this->handleView($this->view($categorie));
  }

  /**
   * Delete Categorie.
   * @Rest\Delete("/{id}")
   *
   * @return Response
   */
  public function deleteCategorieAction($id){
    $repository = $this->getDoctrine()->getRepository(Categorie::class);
    $categorie = $repository->find($id);
    if(!$categorie){
      throw $this->createNotFoundException(
        'Cette catégorie n\'existe pas.'
      );
    } 
    $em = $this->getDoctrine()->getManager();
    $em->remove($categorie);
    $em->flush();
    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));
  }
}
