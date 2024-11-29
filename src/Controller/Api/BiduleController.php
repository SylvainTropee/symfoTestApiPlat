<?php

namespace App\Controller\Api;

use App\Entity\Bidule;
use App\Repository\BiduleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/bidule', name: 'api_bidule')]
class BiduleController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(BiduleRepository $bd): Response
    {
        $bds = $bd->findAll();

        return $this->json([$bds]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, BiduleRepository $bd): Response
    {
        $bidule = $bd->find($id);

        return $this->json([$bidule]);
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function add(
        Request                $request,
        SerializerInterface    $serializer,
        EntityManagerInterface $entityManager
    ): Response
    {
        $data = $request->getContent();

        $bidule = $serializer->deserialize($data, Bidule::class, 'json');
        $entityManager->persist($bidule);
        $entityManager->flush();

        return $this->json([$bidule, Response::HTTP_CREATED]);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(Request                $request,
                           SerializerInterface    $serializer,
                           EntityManagerInterface $entityManager,
                           BiduleRepository       $bd,
                           int                    $id
    ): Response
    {

        $bidule = $bd->find($id);

        $data = $request->getContent();

        $serializer->deserialize(
            $data,
            Bidule::class,
            'json',
            [
                AbstractNormalizer::OBJECT_TO_POPULATE => $bidule
            ]
        );
        $entityManager->persist($bidule);
        $entityManager->flush();

        return $this->json([$bidule, Response::HTTP_OK]);
    }
}
