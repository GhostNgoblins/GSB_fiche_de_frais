<?php

include("vues/v_sommaire3.php");
$idVisiteur = $_SESSION['idVisiteur'];
$mois = getMois(date("d/m/Y"));
$numAnnee =substr( $mois,0,4);
$numMois =substr( $mois,4,2);
$action = $_REQUEST['action'];
switch($action){
    case 'selectionnerMois':{
                $LesGens= $pdo->getLesGens();
                $current=date("Y/m");
                $current=substr($current,0,4).substr($current,5,2);
		$lesMois=$pdo->getLesMoisDisponibles2($current);
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
                $visit = 'none';
		include("vues/v_listeMoisVisit.php");
		break;
	}
        case 'voirEtatFrais':{
                $visit='oui';
                $current=date("Y/m");
                $current=substr($current,0,4).substr($current,5,2);
		$leMois = $_REQUEST['lstMois']; 
                $leV = $_REQUEST['lstVisit'];
                $leV1= $pdo->getPrenom($leV);
                $leV2=$leV1['prenom'];
                $leVisiteur=$leV." ".$leV2 ;
		$lesMois=$pdo->getLesMoisDisponibles2($current);
                $LesGens= $pdo->getLesGens();
		$moisASelectionner = $leMois;
		include("vues/v_listeMoisVisit.php");
                $idV=$pdo->getIdVisiteur($leV);
                $idVisiteur=$idV['id'];
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);
                //change aussi l'etat de ceux qui ne sont pas de la date courrante
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
                $idEtat = $lesInfosFicheFrais['idetat'];
		$libEtat = $lesInfosFicheFrais['libetat'];
		$montantValide = $lesInfosFicheFrais['montantvalide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbjustificatifs'];
		$dateModif =  $lesInfosFicheFrais['datemodif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vues/v_etatFrais2.php");
                break;
	}
        
        case 'validerMajFraisForfait':{
		$frais0 = $_REQUEST['0'];
                $frais1 = $_REQUEST['1'];
                $frais2 = $_REQUEST['2'];
                $frais3 = $_REQUEST['3'];
                $lesFrais=array();
                $lesFrais[0]=$frais0 ;
                $lesFrais[1]=$frais1 ;
                $lesFrais[2]=$frais2 ;
                $lesFrais[3]=$frais3 ;
                $m=array();
                $m[0]=110;
                $m[1]=0.62;
                $m[2]=80;
                $m[3]=25;
		if(lesQteFraisValides($lesFrais)){
	  	 	$pdo->majFraisForfait($idVisiteur,$mois,$lesFrais,$m);
		}
		else{
			ajouterErreur("Les valeurs des frais doivent être numériques");
			include("vues/v_erreurs.php");
		}
	  break;
	}
         case 'reporterFrais':{
		$idFrais = $_REQUEST['idFrais'];
                $num=$pdo->getMois($idFrais); 
                $mois=$num['mois'];
                $numMois =substr( $mois,4,2);
                $numMois=intval($numMois);
                $numMois=$numMois+1;
                $mois=substr($mois,0,4).$numMois;
                $pdo->reporterFraisHorsForfait($idFrais,$mois);
                //include("vues/v_listeMoisVisit.php");
		break;
	}
        
        case 'supprimerFrais':{
		$idFrais = $_REQUEST['idFrais'];
                $pdo->supprimerFraisHorsForfait3($idFrais);
                //include("vues/v_listeMoisVisit.php");
                //include("vues/v_etatFrais2.php");
                break;
	}
        
        
        case 'validerFiche':{
            $idFrais = $_REQUEST['idFrais'];
            $idVisiteur=$pdo->getId($idFrais);
            $idVisiteur=$idVisiteur[0]['id'];
            $mois=$pdo->getMois($idFrais); 
            $mois=$mois['mois'];
            $etat='VA';
            $pdo->majEtatFicheFrais($idVisiteur,$mois,$etat);
            break;
        }
        
    case 'validerJustificatifs':{
        $nb = $_REQUEST['ok'];
        $idVisiteur = $_REQUEST['idVisiteur'];
        $mois = $_REQUEST['mois'];
        //$pdo->majEtatFicheFrais($idVisiteur,$mois,$etat);
    }
        
} 
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
//include("vues/v_listeMoisVisit.php");
//include("vues/v_etatFrais2.php");
?>

