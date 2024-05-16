<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Http;
use DOMDocument;

class SCD
{
    public static function loadData(){
        // $url = "https://fr.wikipedia.org/w/api.php";

        // // Paramètres de la requête
        // $params = [
        //     "action" => "query",
        //     "format" => "json",
        //     "prop" => "extracts",
        //     "titles" => "Liste_des_communes_de_Côte_d'Ivoire",
        //     "exintro" => "", // Pour obtenir seulement l'introduction
        //     "explaintext" => "", // Pour obtenir le texte brut sans balises HTML
        // ];
        
        // // Construire l'URL avec les paramètres de la requête
        // $url .= "?" . http_build_query($params);
        
        // // Effectuer la requête à l'API Wikipedia
        // $response = file_get_contents($url);
        
        // // Convertir la réponse JSON en tableau associatif
        // $data = json_decode($response, true);
        
        // // Récupérer l'extrait de l'article
        // $pages = $data["query"]["pages"];
        // foreach ($pages as $page) {
        //     $extract = $page["extract"];
        // }
        // $articleData = [
        //     "title" => "Liste_des_communes_de_Côte_d'Ivoire",
        //     "extract" => $extract
        // ];
        // $dom = new DOMDocument();
        // $dom->loadHTML($extract);
        //     dump($articleData);

        $response = Http::get('https://fr.wikipedia.org/w/api.php', [
            'action' => 'parse',
            'format' => 'json',
            'page' => 'Liste_des_communes_de_Côte_d\'Ivoire',
        ]);
        
        // Vérifier si la requête a réussi
        if ($response->successful()) {
            // Extraire les données JSON
            $data = $response->json();
            // dd($data);
            // Vérifier si les données contiennent le contenu parsé
            if (isset($data['parse']['text']['*'])) {
                // Extraire le contenu parsé
                $content = $data['parse']['text']['*'];
                // Utiliser DOMDocument pour analyser le contenu HTML
                $doc = new DOMDocument();
                $doc->loadHTML($content);
                dd($doc);
        
                // Récupérer les éléments de liste (ul)
                $ulElements = $doc->getElementsByTagName('ul');
        
                // Tableau pour stocker les communes
                $communes = [];
        
                // Parcourir les éléments ul
                foreach ($ulElements as $ul) {
                    // Récupérer les éléments li (communes)
                    $liElements = $ul->getElementsByTagName('li');
        
                    // Parcourir les éléments li
                    foreach ($liElements as $li) {
                        // Ajouter la commune au tableau
                        $communes[] = $li->nodeValue;
                    }
                }
        
                // Afficher les communes
                print_r($communes);
            } else {
                echo "Les données ne contiennent pas de contenu parsé.";
            }
        } else {
            echo "La requête à l'API Wikipedia a échoué.";
        }

    }

}
