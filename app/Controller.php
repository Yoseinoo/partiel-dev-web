<?php

abstract class Controller {
	/**
	 * Permet de charger un modèle
	 *
	 * @param string $model
	 * @return void
	 */
	public function loadModel(string $model){
	    // On va chercher le fichier correspondant au modèle souhaité
	    require_once(ROOT.'models/'.$model.'.php');
	    
	    // On crée une instance de ce modèle.
	    $this->$model = new $model();
	}
}

