<?php
App::uses('AppModel', 'Model');
/**
 * Documento Model
 *
 * @property Licencia $Licencia
 * @property Pago $Pago
 * @property Traslado $Traslado
 */
class Documento extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'cementerio';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nombre';

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
		'licencia_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'pago_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'traslado_id' => array(
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
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Licencia' => array(
			'className' => 'Licencia',
			'foreignKey' => 'licencia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Pago' => array(
			'className' => 'Pago',
			'foreignKey' => 'pago_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Traslado' => array(
			'className' => 'Traslado',
			'foreignKey' => 'traslado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
