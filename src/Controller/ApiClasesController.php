<?php

namespace App\Controller;

use App\Entity\Clases;
use App\Repository\ClasesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ApiClasesController extends AbstractController
{
    #[Route('/api/clases', name: 'get_all_clases', methods: ['GET'])]
    public function getAllClases(ClasesRepository $clasesRepository): JsonResponse
    {
        $clases = $clasesRepository->findAll();
        
        $resultado = [];
        foreach ($clases as $clase) {
            $resultado[] = [
                'id' => $clase->getId(),
                'nombre' => $clase->getNombre(),
                'descripcion' => $clase->getDescripcion(),
                'fecha' => $clase->getFecha()->format('Y-m-d'),
                'capacidad' => $clase->getCapacidad(),
                'estado' => $clase->getEstado(),
                'ubicacion' => $clase->getUbicacion(),
            ];
        }

        return new JsonResponse($resultado);
    }

    #[Route('/api/clases/by-date/{fecha}', name: 'get_clase_by_date', methods: ['GET'])]
    public function getClaseByDate(string $fecha, ClasesRepository $clasesRepository): JsonResponse
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            return new JsonResponse([
                'mensaje' => 'Formato de fecha inválido. Use YYYY-MM-DD'
            ], 400);
        }

        try {
            $fechaBusqueda = new \DateTime($fecha);
            
            $clases = $clasesRepository->findByFecha($fechaBusqueda);
            
            if (empty($clases)) {
                return new JsonResponse([
                    'mensaje' => 'No se encontraron clases para esta fecha'
                ], 404);
            }

            $resultado = [];
            foreach ($clases as $clase) {
                $resultado[] = [
                    'id' => $clase->getId(),
                    'nombre' => $clase->getNombre(),
                    'descripcion' => $clase->getDescripcion(),
                    'fecha' => $clase->getFecha()->format('Y-m-d'),
                    'capacidad' => $clase->getCapacidad(),
                    'estado' => $clase->getEstado(),
                    'ubicacion' => $clase->getUbicacion(),
                ];
            }

            return new JsonResponse($resultado);

        } catch (\Exception $e) {
            return new JsonResponse([
                'mensaje' => 'Error al procesar la fecha'
            ], 400);
        }
    }
}
