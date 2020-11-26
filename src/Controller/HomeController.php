<?php

namespace App\Controller;

use App\Database\FichierManager;
use App\File\UploadService;
use DateTime;
use Doctrine\DBAL\Connection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class HomeController extends AbstractController
{
    
    public function homepage(
        ResponseInterface $response, 
        ServerRequestInterface $request,
        UploadService $uploadService,
        Connection $connection,
        FichierManager $fichierManager)
        
    {
        
        $listeFichiers= $request->getUploadedFiles();

        if(isset($listeFichiers['fichier'])){
            // @var UploadedFileInterface $fichier
            $fichier = $listeFichiers['fichier'];

            $nouveauNom = $uploadService->saveFile($fichier);
            
            // Enregistrer les infos du fichier en base de données

            // afficher un message a utilisateur 
            // méthode insert()
            $fichier = $fichierManager->creatFichier($nouveauNom, $fichier->getClientFilename());

            return $this->redirect('success',['id' => $fichier->getId()]);
        }
        return $this->template($response, 'home.html.twig');
    }

    public function success(ResponseInterface $response, int $id, FichierManager $fichierManager)
    {
        $fichier = $fichierManager->getById($id);

        if($fichier === null){
            return $this->redirect('file-error');
        }
        return $this->template($response,'success.html.twig',[
            'fichier'=> $fichier
        ]);
        var_dump($fichier);
        die;
    }
    
    public function fileError(ResponseInterface $response)
    {
        return $this->template($response, 'file_error.html.twig');
    }

    public function download(ResponseInterface $response, int $id)
    {
        $response->getBody()->write(sprintf('Identifiant: %d',$id));
        return $response;
    }
    
}
