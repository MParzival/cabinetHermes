<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin_property_index")
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin_property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/annonce/create", name="admin_property_new")
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Félicitation votre bien a été créé !');
            return $this->redirectToRoute('admin_property_index');
        }
        return $this->render('admin_property/new.html.twig', [
            'property' => $property,
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="admin_property_edit", methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    public function edit(Property $property, Request $request) : Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success', 'Félicitation votre bien a été mise à jour !');
            return $this->redirectToRoute('admin_property_index');
        }
        return $this->render('admin_property/edit.html.twig', [
            'property' => $property,
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}/delete", name="admin_property_delete", methods="DELETE")
     */
    public function delete(Property $property, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token')))
        {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Félicitation votre bien a été supprimé !');
        }

        return $this->redirectToRoute('admin_property_index');
    }

}
