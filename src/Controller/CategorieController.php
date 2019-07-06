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
   * Lists all Client.
   * @Rest\Get("/")
   *
   * @return Response
   */
public function getCategorieAction()
  {
    $repository = $this->getDoctrine()->getRepository(Categorie::class);
    $categories = $repository->findall();
    return $this->handleView($this->view($categories));
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

}
