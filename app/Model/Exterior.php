<?php
App::uses('AppModel', 'Model');
/**
 * Exteriore Model
 *
 * @property Tumba $Tumba
 */
class Exterior extends AppModel {

/*	public $virtualFields = array(
		'identificador' => 'CONCAT("x","x")'
	);

	public $displayField = 'identificador';*/

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Exterior';

/**
 * Database table name
 *
 * @var string
 */
	public $table = 'exteriores';

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'cementerio';

/**
 * Use database table
 *
 * @var string
 */
	public $useTable = 'exteriores';




	public $virtualFields = array(
		'identificador' => 'SELECT IF (Exterior.id IS NOT NULL, CONCAT("Exterior"), "")'
	);

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
	//public $displayField = 'identificador';
/**
 * List of behaviors
 *
 * @var array
 */

	public $actsAs = array('Containable');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tumba_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Tumba' => array(
			'className' => 'Tumba',
			'foreignKey' => 'tumba_id',
			'conditions' => '',
            'type' => 'left',
			'fields' => '',
			'order' => '',
		),
	);

}
