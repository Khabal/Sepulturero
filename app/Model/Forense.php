<?php

App::uses('AppModel', 'Model');

/**
 * Forense Model
 *
 * @property Persona $Persona
 * @property Difunto $Difunto
 */
class Forense extends AppModel {
    
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
    public $useTable = 'forenses';
    
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
    public $displayField = 'numero_colegiado';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'Forense';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Forense';
    
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
    public $_schema = array();
    
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
        'id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al generar ID de médico forense.',
            ),
        ),
        'persona_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de persona.',
            ),
        ),
        'numero_colegiado' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El número de colegiado no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 4, 10),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El número de colegiado debe tener entre 4 y 10 caracteres.',
            ),
            'numeronatural' => array(
                'rule' => array('naturalNumber', true),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El número de colegiado sólo puede contener caracteres numéricos.',
            ),
            'unico' => array(
                'rule' => array('isUnique'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El número de colegiado introducido ya está en uso.',
            ),
        ),
        'colegio' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La localidad del colegio no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 2, 50),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La localidad del colegio debe tener entre 2 y 50 caracteres.',
            ),
            'sololetras' => array(
                'rule' => '/^[a-zñÑçÇáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙâÂêÊîÎôÔûÛüÜ \'\-]{2,50}$/i',
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La localidad del colegio sólo puede contener caracteres alfabéticos.',
            ),
        ),
        'telefono' => array(
            'longitud' => array(
                'rule' => array('between', 9, 12),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El número de teléfono debe tener entre 9 y 12 caracteres.',
            ),
            'solonumeros' => array(
                'rule' => '/^[0-9]/',
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El número de teléfono sólo puede contener caracteres numéricos.',
            ),
        ),
        'correo_electronico' => array(
            'longitud' => array(
                'rule' => array('between', 5, 100),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El correo electrónico debe tener entre 5 y 100 caracteres.',
            ),
            'correoe' => array(
                'rule' => array('email'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El correo electrónico introducido no es válido',
            ),
        ),
    );
    
    /**
    * ----------------------
     * Model associations
     * ----------------------
     */
    
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Difunto' => array(
            'className' => 'Difunto',
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
     * @return class object
     */
    public function __construct ($id = false, $table = null, $ds = null) {
        
        //Llamar al constructor de la clase padre
        parent::__construct($id, $table, $ds);
    }
    
    /**
     * ---------------------------
     * Search Plugin
     * ---------------------------
     */
    
    /**
     * Field names accepted
     *
     * @var array
     * @see SearchableBehavior
     */
    public $filterArgs = array(
        'clave' => array('type' => 'query', 'method' => 'buscarForense'),
    );
    
    /**
     * buscarForense method
     *
     * @param array $data Search terms
     * @return array
     */
    public function buscarForense ($data = array()) {
        
        //Comprobar que se haya introducido un término de búsqueda
        if (empty($data['clave'])) {
            //Devolver condiciones de la búsqueda
            return array();
        }
	
        //Construir comodín para búsqueda
        $comodin = '%' . $data['clave'] . '%';
        
        //Devolver condiciones de la búsqueda
        return array(
         'OR' => array(
          'Persona.nombre LIKE' => $comodin,
          'Persona.apellido1 LIKE' => $comodin,
          'Persona.apellido2 LIKE' => $comodin,
          'Persona.dni LIKE' => $comodin,
          'CONCAT(Persona.nombre," ",Persona.apellido1) LIKE' => $comodin,
          'CONCAT(Persona.nombre," ",Persona.apellido1," ",Persona.apellido2) LIKE' => $comodin,
         )
        );
        
    }

}
