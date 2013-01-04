<?php
App::uses('AppModel', 'Model');
/**
 * Persona Model
 *
 * @property Arrendatario $Arrendatario
 * @property Difunto $Difunto
 */
class Persona extends AppModel {

/**
 * List of behaviors
 *
 * @var array
 */

	public $actsAs = array('Containable');

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'cementerio';

	public $virtualFields = array('nombre_completo' => 'CONCAT(
			Persona.nombre, " ", Persona.apellido1, " ", Persona.apellido2)'
	);

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nombre_completo';

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
		'dni' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'apellido1' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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
	public $hasOne = array(
		'Arrendatario' => array(
			'className' => 'Arrendatario',
			'foreignKey' => 'persona_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Difunto' => array(
			'className' => 'Difunto',
			'foreignKey' => 'persona_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
