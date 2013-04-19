<?php

App::uses('AppModel', 'Model');

/**
 * Arrendatario Model
 *
 * @property Arrendamiento $Arrendamiento
 * @property ArrendatarioFuneraria $ArrendatarioFuneraria
 * @property Pago $Pago
 * @property Persona $Persona
 */
class Arrendatario extends AppModel {
    
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
    public $recursive = 0;
    
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
    public $useTable = 'arrendatarios';
    
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
    public $displayField = 'persona_id';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'Arrendatario';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Arrendatario';
    
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
    public $virtualFields = array(
        'direccion' => 'Arrendatario.direccion',
        'localidad' => 'Arrendatario.localidad',
        'provincia' => 'Arrendatario.provincia',
        'pais' => 'Arrendatario.pais',
        'codigo_postal' => 'Arrendatario.codigo_postal',
        'telefono_fijo' => 'Arrendatario.telefono_fijo',
        'telefono_movil' => 'Arrendatario.telefono_movil',
        'correo_electronico' => 'Arrendatario.correo_electronico',
    );
    
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
                'message' => 'Error inesperado al generar ID de arrendatario.',
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
        'direccion' => array(
            'novacio' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La dirección no se puede dejar en blanco.',
            ),
            'maximalongitud' => array(
                'rule' => array('maxLength', 150),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La dirección debe tener como máximo 150 caracteres.',
            ),
        ),
        'localidad' => array(
            'novacio' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La localidad no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 2, 50),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La localidad debe tener entre 2 y 50 caracteres.',
            ),
            'sololetras' => array(
                'rule' => '/^[a-zñÑçÇáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙâÂêÊîÎôÔûÛüÜ \'\-]{2,50}$/i',
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La localidad sólo puede contener caracteres alfabéticos.',
            ),
        ),
        'provincia' => array(
            'longitud' => array(
                'rule' => array('between', 2, 50),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La provincia debe tener entre 2 y 50 caracteres.',
            ),
            'sololetras' => array(
                'rule' => '/^[a-zñÑçÇáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙâÂêÊîÎôÔûÛüÜ \'\-]{2,50}$/i',
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La provincia sólo puede contener caracteres alfabéticos.',
            ),
        ),
        'pais' => array(
            'novacio' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El país no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 2, 50),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El país debe tener entre 2 y 50 caracteres.',
            ),
            'sololetras' => array(
                'rule' => '/^[a-zñÑçÇáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙâÂêÊîÎôÔûÛüÜ \'\-]{2,50}$/i',
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El país sólo puede contener caracteres alfabéticos.',
            ),
        ),
        'codigo_postal' => array(
            'longitud' => array(
                'rule' => array('between', 2, 6),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El código postal debe tener entre 2 y 6 caracteres.',
            ),
            'numeronatural' => array(
                'rule' => array('naturalNumber', true),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El código postal sólo puede contener caracteres numéricos.',
            ),
        ),
        'telefono_fijo' => array(
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
        'telefono_movil' => array(
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
        'Arrendamiento' => array(
            'className' => 'Arrendamiento',
            'foreignKey' => 'arrendatario_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'offset' => 0,
            'dependent' => false,
            'exclusive' => false,
            'finderQuery' => '',
        ),
        'ArrendatarioFuneraria' => array(
            'className' => 'ArrendatarioFuneraria',
            'foreignKey' => 'arrendatario_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'offset' => 0,
            'dependent' => true,
            'exclusive' => false,
            'finderQuery' => '',
        ),
        'Pago' => array(
            'className' => 'Pago',
            'foreignKey' => 'arrendatario_id',
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
        'nombre' => array('type' => 'like', 'field' => 'Persona.nombre'),
        'apellido1' => array('type' => 'like', 'field' => 'Persona.apellido1'),
        'apellido2' => array('type' => 'like', 'field' => 'Persona.apellido2'),
        'dni' => array('type' => 'like', 'field' => 'Persona.dni'),
        'direccion' => array('type' => 'like'),
        'localidad' => array('type' => 'like'),
        'provincia' => array('type' => 'like'),
        'pais' => array('type' => 'like'),
        'codigo_postal' => array('type' => 'like'),
        'telefono_fijo' => array('type' => 'like'),
        'telefono_movil' => array('type' => 'like'),
        'correo_electronico' => array('type' => 'like'),
        'clave' => array('type' => 'query', 'method' => 'buscarArrendatario'),
    );
    
    /**
     * buscarArrendatario method
     *
     * @param array $data Search terms
     * @return array
     */
    public function buscarArrendatario ($data = array()) {
        
        //Comprobar que se haya introducido un término de búsqueda
        if (empty($data['clave'])) {
            //Devolver resultados de la búsqueda
            return array();
        }
	
        //Construir comodín para búsqueda
        $comodin = '%' . $data['clave'] . '%';
        
        //Devolver resultados de la búsqueda
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
