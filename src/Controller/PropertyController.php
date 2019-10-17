<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
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
     * @Route("/annonces", name="property_index")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);

        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),12

        );
        return $this->render('property/index.html.twig', [
            'current_menu'=> 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/annonces/{slug}-{id}", name="property_show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @param string $slug
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function show(Property $property, string $slug) : Response
    {
        if($property->getSlug() !== $slug){
            return $this->redirectToRoute('property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
    ]);
    }
}
