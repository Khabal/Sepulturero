<?php
App::uses('AppModel', 'Model');
/**
 * Tumba Model
 *
 * @property Columbario $Columbario
 * @property Exteriore $Exteriore
 * @property Nicho $Nicho
 * @property Panteone $Panteone
 * @property Difunto $Difunto
 * @property Enterramiento $Enterramiento
 * @property Arrendatario $Arrendatario
 * @property Traslado $Traslado
 */
class Tumba extends AppModel {

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
public $displayField = 'tipo';

public $virtualFields = array();


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

	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'Columbario' => array(
			'className' => 'Columbario',
			'foreignKey' => 'tumba_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Exterior' => array(
			'className' => 'Exterior',
			'foreignKey' => 'tumba_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Nicho' => array(
			'className' => 'Nicho',
			'foreignKey' => 'tumba_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Panteon' => array(
			'className' => 'Panteon',
			'foreignKey' => 'tumba_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Difunto' => array(
			'className' => 'Difunto',
			'foreignKey' => 'tumba_id',
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
		'Enterramiento' => array(
			'className' => 'Enterramiento',
			'foreignKey' => 'tumba_id',
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
		'ArrendatarioTumba' => array(
			'className' => 'ArrendatarioTumba',
			//'joinTable' => 'arrendatarios_tumbas',
			'foreignKey' => 'tumba_id',
			//'associationForeignKey' => 'arrendatario_id',
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
			'foreignKey' => 'tumba_id',
			//'associationForeignKey' => 'traslado_id',
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
 * Constructor
 *
 * @param mixed $id Model ID
 * @param string $table Table name
 * @param string $ds Datasource
 * @access public
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->virtualFields += $this->Columbario->virtualFields;
$this->virtualFields += $this->Exterior->virtualFields;
$this->virtualFields += $this->Nicho->virtualFields;
$this->virtualFields += $this->Panteon->virtualFields;

// . $this->Nicho->virtualFields['identificador'] . $this->Panteon->virtualFields['identificador'];*/
		$this->tipo = array(
			'Columbario' => __('Columbario', true),
			'Exterior' => __('Exterior', true),
			'Nicho' => __('Nicho', true),
			'Panteón' => __('Panteón', true));
	}

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
				/*$this->Arrendatario . */'Tumba.tipo LIKE' => $nombre,
//BUSCAR POR ELEMENTOS SEPARADOS DE CADA TIPO DE TUMBA
				/*$this->alias . */'CONCAT("Número: ", Columbario.numero_columbario, " - Fila: ", Columbario.fila, " - Patio: ", Columbario.patio) LIKE' => $nombre,
				/*$this->alias . */'CONCAT("Número: ", Nicho.numero_nicho, " - Fila: ", Nicho.fila, " - Patio: ", Nicho.patio) LIKE' => $nombre,
				/*$this->alias . */'CONCAT("Familia: ", Panteon.familia, " - Número: ", Panteon.numero_panteon,  " - Patio: ", Panteon.patio) LIKE' => $nombre,

			));
	}

}
