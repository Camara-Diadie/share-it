<?php

namespace App\Controller;

use App\File\UploadService;
use DateTime;
use Doctrine\DBAL\Connection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class HomeController extends AbstractController
{
    
    public function homepage(ResponseInterface $response, ServerRequestInterface $request, UploadService $uploadService, Connection $connection)
    {
        
        $listeFichiers= $request->getUploadedFiles();

        if(isset($listeFichiers['fichier'])){
            // @var UploadedFileInterface $fichier
            $fichier = $listeFichiers['fichier'];

            $nouveauNom = $uploadService->saveFile($fichier);
            
            // Enregistrer les infos du fichier en base de données

            // afficher un message a utilisateur 
            // méthode insert()
            $connection->insert('fichier', [
                'nom' => $nouveauNom,
                'nom_original' => $fichier->getClientFilename(),
            ]);
        }
        return $this->template($response, 'home.html.twig');
    }

    public function download(ResponseInterface $response, int $id)
    {
        $response->getBody()->write(sprintf('Identifiant: %d',$id));
        return $response;
    }
    
}
