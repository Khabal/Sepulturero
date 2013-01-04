<?php
App::uses('AppModel', 'Model');
/**
 * Arrendatario Model
 *
 * @property Persona $Persona
 * @property Funeraria $Funeraria
 * @property Tumba $Tumba
 */
class Arrendatario extends AppModel {

/**
 * List of behaviors
 *
 * @var array
 */

	public $actsAs = array('Containable', 'Search.Searchable');

/**
 * Alias
 *
 * @var string
 */
	public $alias = 'Arrendatario';

/**
 * Enable or disable cache queries
 *
 * @var boolean
 */
	public $cacheQueries = false;

/**
 * Enable or disable cache sources
 *
 * @var boolean
 */
	public $cacheSources = true;

/**
 * Display field
 *
 * @var string
 */
	//public $displayField = 'nombre_completo';

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Arrendatario';

/**
 * Primary key
 *
 * @var string
 */
	public $primaryKey = 'id';

/**
 * Number of associations to recurse
 *
 * @var integer
 */
	public $recursive = 1;

/**
 * Database table name
 *
 * @var string
 */
	public $table = 'arrendatarios';

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
	public $useTable = 'arrendatarios';

/**
 * Virtual fields
 *
 * @var array
 */
/*	public $virtualFields = array(
		'nombre_completo' => 'CONCAT(
			Persona.nombre, " ", Persona.apellido1, " ", Persona.apellido2)'
	);*/

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
		'persona_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		/*'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
		'direccion' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'localidad' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'pais' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'codigo_postal' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'Persona' => array(
			'className' => 'Persona',
			'foreignKey' => 'persona_id',
			'conditions' => '',
			'type' => 'left',
			'fields' => '',
			'order' => '',
			'counterCache' => '',
			'counterScope' => '',
		),
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
/*	public $hasAndBelongsToMany = array(
		'Funeraria' => array(
			'className' => 'Funeraria',
			'joinTable' => 'arrendatarios_funerarias',
			//'with' => 'funerarias',
			'foreignKey' => 'arrendatario_id',
			'associationForeignKey' => 'funeraria_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => '',
		),
		'Tumba' => array(
			'className' => 'Tumba',
			'joinTable' => 'arrendatarios_tumbas',
			//'with' => 'tumbas',
			'foreignKey' => 'arrendatario_id',
			'associationForeignKey' => 'tumba_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => '',
		),
	);*/

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ArrendatarioFuneraria' => array(
			'className' => 'ArrendatarioFuneraria',
			'foreignKey' => 'arrendatario_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => '',
		),
		'ArrendatarioTumba' => array(
			'className' => 'ArrendatarioTumba',
			'foreignKey' => 'arrendatario_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => '',
		)
	);

/*public $filterArgs = array(
			'title' => array('type' => 'like'),
			'status' => array('type' => 'value'),
			'blog_id' => array('type' => 'value'),
			'search' => array('type' => 'like', 'field' => 'Article.description'),
			'range' => array('type' => 'expression', 'method' => 'makeRangeCondition', 'field' => 'Article.views BETWEEN ? AND ?'),
			'nombre_completo' => array('type' => 'like', 'field' => array('Persona.nombre', 'Persona.apellido1', 'Persona.apellido2')),
			'tags' => array('type' => 'subquery', 'method' => 'findByTags', 'field' => 'Article.id'),
			'filter' => array('type' => 'query', 'method' => 'orConditions'),
			'enhanced_search' => array('type' => 'like', 'encode' => true, 'before' => false, 'after' => false, 'field' => array('ThisModel.name','OtherModel.name')),
		);

		public function findByNombreCompleto($data = array()) {
			$this->Tagged->Behaviors->attach('Containable', array('autoFields' => false));
			$this->Tagged->Behaviors->attach('Search.Searchable');
			$query = $this->Tagged->getQuery('all', array(
				'conditions' => array('Persona.nombre_completo'  => $data['personas']),
				'fields' => array('foreign_key'),
				'contain' => array('Persona')
			));
			return $query;
		}

		public function orConditions($data = array()) {
			$filter = $data['filter'];
			$cond = array(
				'OR' => array(
					$this->alias . '.nombre_completo LIKE' => '%' . $filter . '%',
					$this->alias . '.nombre_completo LIKE' => '%' . $filter . '%',
				));
			return $cond;
		}*/

/*public function afterSave(boolean $created) {

//$id = this->Arrendatario->id;
$datos = array();
$datos['ArrendatarioFuneraria']['arrendatario_id'] = $this->Arrendatario->id;
$datos['ArrendatarioFuneraria']['funeraria_id'] = $this->request->data['Arrendatario']['Funeraria'];
var_dump($this->request->data);

$this->Arrendatario->ArrendatarioFuneraria->save($datos);

$datos = array();
if($this->Arrendatario->ArrendatarioTumba->list('all', array(
			'conditions' => array('ArrendatarioTumba.arrendatario_id' => 'Arrendatario.id')))){

$this->Arrendatario->ArrendatarioTumba->updateAll(
    array('ArrendatarioTumba.estado' => 'Antiguo'),
    array('ArrendatarioTumba.tumba_id' => $this->request->data['Arrendatario']['Tumba'])
);

}

$datos['ArrendatarioTumba']['arrendatario_id'] = $this->Arrendatario->id;
$datos['ArrendatarioTumba']['tumba_id'] = $this->request->data['Arrendatario']['Tumba'];
$datos['ArrendatarioTumba']['estado'] = 'Actual';
$datos['ArrendatarioTumba']['fecha'] = date("d-m-Y");

$this->Arrendatario->ArrendatarioTumba->save($datos);

}*/



/**
 * Constructor
 *
 * @param mixed $id Model ID
 * @param string $table Table name
 * @param string $ds Datasource
 * @access public
 */
	public function __construct($id = false, $table = null, $ds = null) {
		//$this->virtualFields += $this->Persona->virtualFields;
		$this->estado = array(
			'Antiguo' => __('Antiguo', true),
			'Actual' => __('Actual', true));
		parent::__construct($id, $table, $ds);
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
				/*$this->Arrendatario . */'Persona.nombre LIKE' => $nombre,
				/*$this->alias . */'Persona.apellido1 LIKE' => $nombre,
				/*$this->alias . */'Persona.apellido2 LIKE' => $nombre,
				/*$this->alias . */'Persona.dni LIKE' => $nombre,
				/*$this->alias . */'concat(Persona.nombre," ",Persona.apellido1) LIKE' => $nombre,
				/*$this->alias . */'concat(Persona.nombre," ",Persona.apellido1," ",Persona.apellido2) LIKE' => $nombre,
			));
	}

}
