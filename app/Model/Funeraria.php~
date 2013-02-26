<?php

App::uses('AppModel', 'Model');

/**
 * Funeraria Model
 *
 * @property ArrendatarioFuneraria $ArrendatarioFuneraria
 */
class Funeraria extends AppModel {
    
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
    public $useTable = 'funerarias';
    
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
    public $displayField = 'nombre';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'Funeraria';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Funeraria';
    
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
        'id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al generar ID de funeraria.',
            ),
        ),
        'cif' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El C.I.F. no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 8, 9),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El C.I.F. debe tener entre 8 y 9 caracteres.',
            ),
            'validar' => array(
                'rule' => array('valida_cif'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El C.I.F. introducido no es válido (Ejemplo: 12345678X)',
            ),
        ),
        'nombre' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El nombre no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 2, 100),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El nombre debe tener entre 2 y 100 caracteres.',
            ),
            'sololetras' => array(
                'rule' => '/^[a-zñÑçÇáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙâÂêÊîÎôÔûÛüÜ \']{2,100}$/i',
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El nombre sólo puede contener caracteres alfabéticos.',
            ),
        ),
        'direccion' => array(
            'novacio' => array(
                'rule' => array('notempty'),
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
        'telefono' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El número de teléfono no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 9, 12),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El número de teléfono debe tener entre 9 y 12 caracteres.',
            ),
            'solonumeros' => array(
                'rule' => '/^[0-9]/',
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El número de teléfono sólo puede contener caracteres numéricos.',
            ),
        ),
        'fax' => array(
            'longitud' => array(
                'rule' => array('between', 9, 12),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El número de fax debe tener entre 9 y 12 caracteres.',
            ),
            'solonumeros' => array(
                'rule' => '/^[0-9]/',
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El número de fax sólo puede contener caracteres numéricos.',
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
        'pagina_web' => array(
            'longitud' => array(
                'rule' => array('between', 5, 100),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La página web debe tener entre 5 y 100 caracteres.',
            ),
            'web' => array(
                'rule' => array('url', true),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La página web introducida no es válida',
            ),
        ),
        'observaciones' => array(
            'maximalongitud' => array(
                'rule' => array('maxLength', 255),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'Las observaciones debe tener como máximo 255 caracteres.',
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
        'ArrendatarioFuneraria' => array(
            'className' => 'ArrendatarioFuneraria',
            'foreignKey' => 'funeraria_id',
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
     * valida_cif method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_cif($check) {
        
        //Extraer el CIF del vector
        $cif = (string) $check['cif'];

        //Convertir a mayúsculas
        $cif = strtoupper($cif);
        
        //Comprobar si tiene un formato válido
        if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/', $cif)) {
            //Devolver error
            return false;
        }
        
        //Extraer los caracteres de la cadena a un vector
        for ($i = 0; $i < 9; $i++) {
            $num[$i] = substr($cif, $i, 1);
        }
        
        //Algoritmo para la comprobación de códigos tipo CIF
        $suma = $num[2] + $num[4] + $num[6];
        for ($i = 1; $i < 8; $i += 2) {
            $suma += substr((2 * $num[$i]), 0, 1) + substr((2 * $num[$i]), 1, 1);
        }
        $n = 10 - substr($suma, strlen($suma) - 1, 1);
        
        //Comprobar si se trata de un CIF
        if (preg_match('/^[ABCDEFGHJNPQRSUVW]{1}/', $cif)) {
            if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1)) {
                //Devolver válido
                return true;
            }
            else {
                //Devolver error
                return false;
            }
        }
        
        //Si todavía no se ha verificado devolver error
        return false;
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
        'clave' => array('type' => 'query', 'method' => 'buscarFuneraria'),
    );
    
    /**
     * buscarFuneraria method
     *
     * @param array $data Search terms
     * @return array
     */
    public function buscarFuneraria ($data = array()) {
        
        //Comprobar que se haya introducido un término de búsqueda
        if (empty($data['clave'])) {
            //Devolver condiciones de la búsqueda
            return array();
        }
	
        //Construir comodín para búsqueda
        $comodin = '%' . $data['clave'] . '%';
        
        //Devolver condiciones de la búsqueda
        return array(
         'OR'  => array(
          'Funeraria.cif LIKE' => $comodin,
          'Funeraria.nombre LIKE' => $comodin,
         )
        );
        
    }
    
}
