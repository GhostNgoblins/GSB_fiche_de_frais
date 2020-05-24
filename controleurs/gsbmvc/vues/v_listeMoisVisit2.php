<div id="contenu">
      <h2>Suivi des fiches de frais</h2>
      <h3>Fiches de visiteur et Mois à sélectionner : </h3>
      <form action="index.php?uc=suiviValid&action=voirEtatFrais" method="post">
      <div class="corpsForm">
         
      <p>
        <label for="lstVisit" accesskey="n">Visiteur : </label>
	<select id="lstVisit" name="lstVisit"> <?php 
			foreach ($LesGens as $unGens)
			{
                                $nom = $unGens['nom'];
                                $mois=$unGens['mois']; 
                                $mois=substr($mois,0,4).'\\'.substr($mois,4,6);
                                $prenom = $unGens['prenom'];
                                $visiteur2 = $nom." ".$prenom;
                            if($visit == 'oui'){
				?>
				<option selected value="<?php echo $mois." ".$leVisiteur ?>"><?php echo $mois." ".$leVisiteur ;?> </option>
				<?php 
				$visit='none';}
				else{ 
                                    if($visiteur2 != $leVisiteur){?>
                                    <option value="<?php echo $nom; ?>"><?php echo $mois." - ".$nom." ".$prenom; ?> </option><?php } ?>
				
                                    <?php	}  }
                        ?>
			   </select>
        
        <br></br>
