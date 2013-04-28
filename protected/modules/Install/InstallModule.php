<?php
/**
-------------------------
GNU GPL COPYRIGHT NOTICES
-------------------------
This file is part of Open-School.

/**
 * $Id$
 *
 * @author Open-School team <contact@Open-School.org>
 * @link http://www.Open-School.org/
 * @copyright Copyright &copy; 2009-2012 wiwo inc.
 * @Matthew George,@Rajith Ramachandran,@Arun Kumar,
 * @Anupama,@Laijesh V Kumar.
 * @license http://www.Open-School.org/
 */
 

class InstallModule extends CWebModule
{
    public $structuresPath='webroot.database.schema';
    public $dataPath='webroot.database.data';
    
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'Install.models.*',
			'Install.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

    public function getResourceDefinition(){
        return array();
    }
}