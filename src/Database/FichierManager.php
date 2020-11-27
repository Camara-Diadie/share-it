<?php

namespace App\Database;

use Doctrine\DBAL\Connection;

/**
 * ce service est en charge de la gestion des données de la table "fichier"
 * elle doit utiliser des objets de la class fichier
 */

 class FichierManager
 {
     private Connection $connection;

     public function __construct(Connection $connection)

     {
        $this->connection = $connection;    
     }

     public function getById(int $id): ?Fichier
     {
        $query = $this->connection->prepare('SELECT * FROM fichier WHERE id =:id');
        $query->bindValue('id',$id);
        $result=$query->execute();

        //tableau associatif contenant les données du fichier, ou false si aucun resulta
        $fichierData = $result->fetchAssociative();
        if ($fichierData === false){
            return null;
        }
        // création d'une instatnce de fichier

        
        return $this->creatObject($fichierData['id'], $fichierData['nom'], $fichierData['nom_original']);

     }

     public function creatFichier(string $nom, string $nomOriginal): Fichier
     {

        //enregistrere base de données(voir HomeController::homepage() )
        $this->connection->insert('fichier',[
            'nom'=>$nom,
            'nom_original'=>$nomOriginal,
        ]);
        //récupérer l'identifaint généré du fichier enregistré
        $id = $this->connection->lastInsertId();
        //créer un objet fichier et le retourner
        return $this->creatObject($id,  $nom,  $nomOriginal);

     }
     private function creatObject(int $id, string $nom, string $nomOriginal): Fichier
     {
         $fichier = new Fichier();
         $fichier
         ->setId($id)
         ->setNom($nom)
         ->setNomOriginal($nomOriginal)
         ;
         return $fichier;

     }
 }