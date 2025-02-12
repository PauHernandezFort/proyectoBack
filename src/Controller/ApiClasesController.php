<?php

namespace App\Controller;

use App\Entity\Clases;
use App\Repository\ClasesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ApiClasesController extends AbstractController
{
    #[Route('/api/clases', name: 'get_all_clases', methods: ['GET'])]
    public function getAllClases(ClasesRepository $clasesRepository): JsonResponse
    {
        $clases = $clasesRepository->findAll();
        
        $clasesArray = array_map(function($clase) {
            return [
                'id' => $clase->getId(),
                'nombre' => $clase->getNombre(),
                'descripcion' => $clase->getDescripcion(),
                'fecha' => $clase->getFecha()->format('Y-m-d'),
                'capacidad' => $clase->getCapacidad(),
                'estado' => $clase->getEstado(),
                'ubicacion' => $clase->getUbicacion(),
            ];
        }, $clases);

        return new JsonResponse($clasesArray);
    }

    #[Route('/api/clases/by-name/{nombre}', name: 'get_clase_by_name', methods: ['GET'])]
    public function getClaseByName(string $nombre, ClasesRepository $clasesRepository): JsonResponse
    {
        $clases = $clasesRepository->findByNombre($nombre);
        
        if (!$clases) {
            return new JsonResponse(['message' => 'No se encontraron clases con ese nombre'], 404);
        }

        $clasesArray = array_map(function($clase) {
            return [
                'id' => $clase->getId(),
                'nombre' => $clase->getNombre(),
                'descripcion' => $clase->getDescripcion(),
                'fecha' => $clase->getFecha()->format('Y-m-d'),
                'capacidad' => $clase->getCapacidad(),
                'estado' => $clase->getEstado(),
                'ubicacion' => $clase->getUbicacion(),
            ];
        }, $clases);

        return new JsonResponse($clasesArray);
    }
}
