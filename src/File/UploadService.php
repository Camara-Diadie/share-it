<?php

namespace App\File;

use Psr\Http\Message\UploadedFileInterface;
//Upload service//

class  UploadService
{
    public const FILE_DIR = __DIR__ . '/../../files' ;

        /**
     * Enregistre un fichier
     */
    public function saveFile(UploadedFileInterface $file): string
    {

        $filename = $this->generateFilename($file);


            //construire le chemin de destination du fichier
            //chemin vers le dossier /files/ + nouveau nom de fichier
            $path = self::FILE_DIR.'/' . $filename;

            // déplacer le fichier
            $file->moveTo($path);
            return $filename;
    }

    /**
     * Générer un nom de fichier aléatoir et unique 
     * 
     * @param UploadeFileInterface $file le fichier à enregistrer 
     * @return string le nom  unique généré
     */

     private function generateFilename(UploadedFileInterface $file): string
     {
        /**
        *Ecrire le code de la méthode génarateFilename()
        *utiliser la méthode génarateFilename() dans la méthode saveFile()
        * ajouter un argument UploadService dans le Homcontroller et utiliser saveFile()
        *
        */
        $filename = date('YmdHis');
        $filename .= bin2hex(random_bytes(8));
        $filename.='.' .pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
        return $filename;

     }
}