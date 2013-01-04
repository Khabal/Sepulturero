<?php
App::uses('AppModel', 'Model');
/**
 * Traslado Model
 *
 * @property Documento $Documento
 * @property Difunto $Difunto
 * @property Tumba $Tumba
 */
class Traslado extends AppModel {

/**
 * Behaviors
 *
 * @var array
 * @access public
 */
	public $actsAs = array('Containable', 'Search.Searchable');

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
	public $displayField = 'fecha';

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
		'fecha' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'cementerio_origen' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'cementerio_destino' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'motivo' => array(
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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Documento' => array(
			'className' => 'Documento',
			'foreignKey' => 'traslado_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'DifuntoTraslado' => array(
			'className' => 'DifuntoTraslado',
			//'joinTable' => 'difuntos_traslados',
			'foreignKey' => 'traslado_id',
			//'associationForeignKey' => 'difunto_id',
			//'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			//'insertQuery' => ''
		),
		'TrasladoTumba' => array(
			'className' => 'TrasladoTumba',
			//'joinTable' => 'traslados_tumbas',
			'foreignKey' => 'traslado_id',
			//'associationForeignKey' => 'tumba_id',
			//'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			//'insertQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
/*	public $hasAndBelongsToMany = array(
		'Difunto' => array(
			'className' => 'Difunto',
			'joinTable' => 'difuntos_traslados',
			'foreignKey' => 'traslado_id',
			'associationForeignKey' => 'difunto_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Tumba' => array(
			'className' => 'Tumba',
			'joinTable' => 'traslados_tumbas',
			'foreignKey' => 'traslado_id',
			'associationForeignKey' => 'tumba_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
*/

/**
 * Field names accepted
 *
 * @var array
 * @see SearchableBehavior
 */
	public $filterArgs = array(
          'clave' => array('type' => 'query', /*'field' => 'generico',*/ 'method' => 'filterNombre'),
		//array('name' => 'nombre', 'type' => 'like', 'field' => 'Persona.nombre'),
		/*array('name' => 'apellido1', 'type' => 'like', 'field' => 'Persona.apellido1'),
		array('name' => 'apellido2', 'type' => 'like', 'field' => 'Persona.apellido2'),*/
	);

	public function filterNombre($data = array()/*, $field = null*/) {
		if (empty($data['clave'])) {//$this->params->query
			return array();
		}
		$nombre = '%' . $data['clave'] . '%';
//print($nombre);
		return array(
			'OR'  => array(
			//	/*$this->alias . */'Persona.nombre_completo LIKE' => $nombre,
				/*$this->Arrendatario . */'DATE_FORMAT(Traslado.fecha,"%d/%m/%Y") LIKE' => $nombre,
				/*$this->alias . */'Traslado.cementerio_origen LIKE' => $nombre,
				/*$this->alias . */'Traslado.cementerio_destino LIKE' => $nombre,
				/*$this->alias . */'Traslado.motivo LIKE' => $nombre,
			));
	}
}
