<?php

App::uses('AppModel', 'Model');

/**
 * Difunto Model
 *
 * @property Enterramiento $Enterramiento
 * @property Persona $Persona
 * @property Traslado $Traslado
 * @property DifuntoTraslado $DifuntoTraslado
 */
class Difunto extends AppModel {
    
    /**
     * ----------------------
     * Model Attributes
     * ----------------------
     */
    
    /**
     * Enable or disable cache queries
     *
     * @var boolean
     */
    public $cacheQueries = false;
    
    /**
     * Number of associations to recurse
     *
     * @var integer
     */
    public $recursive = 1;
    
    /**
     * Name of the database connection
     *
     * @var string
     */
    public $useDbConfig = 'cementerio';
    
    /**
     * Database table name
     *
     * @var string
     */
    public $useTable = 'difuntos';
    
    /**
     * Name of the table prefix
     *
     * @var string
     */
    public $tablePrefix = '';
    
    /**
     * Table primary key
     *
     * @var string
     */
    public $primaryKey = 'id';
    
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'nombre_completo';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'Difunto';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Difunto';
    
    /**
     * List of defaults ordering of data for any find operation
     *
     * @var array
     */
    public $order = array();
    
    /**
     * Virtual fields
     *
     * @var array
     */
    public $virtualFields = array();
    
    /**
     * List of behaviors
     *
     * @var array
     */
    public $actsAs = array('Containable', 'Search.Searchable');
    
    /**
     * ----------------------
     * Model schema
     * ----------------------
     */
    
    /**
     * Metadata describing the model's database table fields
     *
     * @var array
     */
    public $_schema = array(
    );
    
    /**
     * ----------------------
     * Model data validation
     * ----------------------
     */
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
'persona_id' => array(
				'uuid' => array(
'rule' => array('uuid'),
 'required' => true,
 'allowEmpty' => false,
 'message' => 'Please enter a Persona'
)
),
			'tumba_id' => array(
				'uuid' => array('rule' => array('uuid'), 'required' => false, 'allowEmpty' => true, 'message' => 'Please enter a Tumba',)),
			'estado' => array(
				'notempty' => array('rule' => array('notempty'), 'required' => true, 'allowEmpty' => false, 'message' => 'Please enter a Estado', )),
			'edad_defuncion' => array(
				'numeric' => array('rule' => array('numeric'), 'required' => false, 'allowEmpty' => true, 'message' => 'Please enter a numbre', )),
			'fecha_defuncion' => array(
				'date' => array('rule' => array('date'), 'required' => false, 'allowEmpty' => true, 'message' => 'Please enter a Fecha Defuncion', )),
			'causa_defuncion' => array(
				'text' => array('required' => false, 'allowEmpty' => true, 'message' => 'Please enter a causa Defuncion', )),
    );
    
    /**
     * ----------------------
     * Model associations
     * ----------------------
     */
    
    /**
     * hasOne associations
     *
     * @var array
     */
    public $hasOne = array(
        'Enterramiento' => array(
            'className' => 'Enterramiento',
            'foreignKey' => 'difunto_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'dependent' => true,
        ),
    );
    
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'DifuntoTraslado' => array(
            'className' => 'DifuntoTraslado',
            'foreignKey' => 'difunto_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'offset' => 0,
            'dependent' => false,
            'exclusive' => false,
            'finderQuery' => '',
        ),
    );
    
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
        'Tumba' => array(
            'className' => 'Tumba',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'type' => 'left',
            'fields' => '',
            'order' => '',
            'counterCache' => '',
            'counterScope' => '',
        ),
    );
    
    /**
     * ----------------------
     * Model methods
     * ----------------------
     */
    
    /**
     * Constructor
     *
     * @param mixed $id Model ID
     * @param string $table Table name
     * @param string $ds Datasource
     */
    public function __construct($id = false, $table = null, $ds = null) {
        
        //Añadir campos virtuales de "Persona"
        $this->virtualFields += $this->Persona->virtualFields;
        
        //Vector de estados del cuerpo de un difunto
        $this->estado = array(
            'Cadáver' => __('Cadáver', true),
            'Cenizas' => __('Cenizas', true),
            'Restos' => __('Restos', true),
        );
        
        //Llamar al constructor de la clase padre
        parent::__construct($id, $table, $ds);
    }

/**
 * Additional Find types to be used with find($type);
 *
 * @var array
 **/
/*	public $_findMethods = array(
		'search' => true
	);*/

/**
 * Field names accepted for search queries.
 *
 * @var array
 * @see SearchableBehavior
 */
	public $filterArgs = array(
'clave' => array('type' => 'query', /*'field' => 'generico',*/ 'method' => 'filterNombre'),
		//array('name' => 'title', 'type' => 'string'),
	);
	

	public function filterNombre($data, $field = null) {
		if (empty($data['clave'])) {
			return array();
		}
		$nombre = '%' . $data['clave'] . '%';

		return array(
			'OR'  => array(
				/*$this->Arrendatario . */'Persona.nombre LIKE' => $nombre,
				/*$this->alias . */'Persona.apellido1 LIKE' => $nombre,
				/*$this->alias . */'Persona.apellido2 LIKE' => $nombre,
				/*$this->alias . */'Persona.dni LIKE' => $nombre,
				/*$this->alias . */'CONCAT(Persona.nombre," ",Persona.apellido1) LIKE' => $nombre,
				/*$this->alias . */'CONCAT(Persona.nombre," ",Persona.apellido1," ",Persona.apellido2) LIKE' => $nombre,
			));
	}

/**
 * Adds a new record to the database
 *
 * @param array post data, should be Contoller->data
 * @return array
 * @access public
 */
/*	public function add($data = null) {
		if (!empty($data)) {
			$this->create();
			$result = $this->save($data);
			if ($result !== false) {
				$this->data = array_merge($data, $result);
				return true;
			} else {
				throw new OutOfBoundsException(__('Could not save the difunto, please check your inputs.', true));
			}
			return $return;
		}
	}
*/
/**
 * Edits an existing Difunto.
 *
 * @param string $id, difunto id 
 * @param array $data, controller post data usually $this->data
 * @return mixed True on successfully save else post data as array
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
/*	public function edit($id = null, $data = null) {
		$difunto = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id,
				)));

		if (empty($difunto)) {
			throw new OutOfBoundsException(__('Invalid Difunto', true));
		}
		$this->set($difunto);

		if (!empty($data)) {
			$this->set($data);
			$result = $this->save(null, true);
			if ($result) {
				$this->data = $result;
				return true;
			} else {
				return $data;
			}
		} else {
			return $difunto;
		}
	}
*/
/**
 * Returns the record of a Difunto.
 *
 * @param string $id, difunto id.
 * @return array
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
/*	public function view($id = null) {
		$difunto = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id)));

		if (empty($difunto)) {
			throw new OutOfBoundsException(__('Invalid Difunto', true));
		}

		return $difunto;
	}
*/
/**
 * Validates the deletion
 *
 * @param string $id, difunto id 
 * @param array $data, controller post data usually $this->data
 * @return boolean True on success
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
/*	public function validateAndDelete($id = null, $data = array()) {
		$difunto = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id,
				)));

		if (empty($difunto)) {
			throw new OutOfBoundsException(__('Invalid Difunto', true));
		}

		$this->data['difunto'] = $difunto;
		if (!empty($data)) {
			$data['Difunto']['id'] = $id;
			$tmp = $this->validate;
			$this->validate = array(
				'id' => array('rule' => 'notEmpty'),
				'confirm' => array('rule' => '[1]'));

			$this->set($data);
			if ($this->validates()) {
				if ($this->delete($data['Difunto']['id'])) {
					return true;
				}
			}
			$this->validate = $tmp;
			throw new Exception(__('You need to confirm to delete this Difunto', true));
		}
	}

 */
/**
 * Returns the search data
 *
 * @param string
 * @param array
 * @param array
 * @return
 * @access protected
 */
/*	protected function _findSearch($state, $query, $results = array()) {
		if ($state == 'before') {
			$this->Behaviors->attach('Containable', array('autoFields' => false));
			$results = $query;

			if (isset($query['operation']) && $query['operation'] == 'count') {
				$results['fields'] = array('COUNT(*)');
			}

			return $results;
		} elseif ($state == 'after') {
			if (isset($query['operation']) && $query['operation'] == 'count') {
				if (isset($query['group']) && is_array($query['group']) && !empty($query['group'])) {
					return count($results);
				}
				return $results[0][0]['COUNT(*)'];
			}
			return $results;
		}
	}*/

/**
 * Customized paginateCount method
 *
 * @param array
 * @param integer
 * @param array
 * @return
 * @access public
 */
/*	function paginateCount($conditions = array(), $recursive = 0, $extra = array()) {
		$parameters = compact('conditions');
		if ($recursive != $this->recursive) {
			$parameters['recursive'] = $recursive;
		}
		if (isset($extra['type']) && isset($this->_findMethods[$extra['type']])) {
			$extra['operation'] = 'count';
			return $this->find($extra['type'], array_merge($parameters, $extra));
		} else {
			return $this->find('count', array_merge($parameters, $extra));
		}
	}

*/
}
