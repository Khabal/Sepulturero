<?php

App::uses('AppModel', 'Model');

/**
 * Tasa Model
 *
 * @property PagoTasa $PagoTasa
 */
class Tasa extends AppModel {
    
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
    public $useTable = 'tasas';
    
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
    public $displayField = 'concepto';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'Tasa';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Tasa';
    
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
        'concepto' => 'Tasa.concepto',
        'cantidad' => 'Tasa.cantidad',
        'moneda' => 'Tasa.moneda',
        'inicio_validez' => 'Tasa.inicio_validez',
        'fin_validez' => 'Tasa.fin_validez',
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
                'message' => 'Error inesperado al generar ID de tasa.',
            ),
        ),
        'concepto' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El concepto no se puede dejar en blanco.',
            ),
            'longitud' => array(
                'rule' => array('between', 2, 50),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El concepto debe tener entre 2 y 50 caracteres.',
            ),
        ),
        'cantidad' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La cantidad no se puede dejar en blanco.',
            ),
            'numero_real' => array(
                'rule' => '/^([0-9]\.[0-9]{3}|[0-9]{1,4})(\,[0-9]{0,2}){0,1}$/',
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La cantidad sólo puede contener caracteres numéricos.',
            ),
        ),
        'moneda' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La moneda no se puede dejar en blanco.',
            ),
            'lista_moneda' => array(
                'rule' => array('inList', array('Pesetas', 'Euros')),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La moneda no se encuentra dentro de las opciones posibles.',
            ),
        ),
        'inicio_validez' => array(
            'formato_fecha' => array(
                'rule' => array('date', 'ymd'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Formato de fecha inválido (AAAA/MM/DD).',
            ),
        ),
        'fin_validez' => array(
            'formato_fecha' => array(
                'rule' => array('date', 'ymd'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'Formato de fecha inválido (AAAA/MM/DD).',
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
        //Campos imaginarios
        'inicio_bonito' => array(
            'formato_fecha' => array(
                'rule' => array('date', 'dmy'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Formato de fecha inválido (DD/MM/AAAA).',
            ),
        ),
        'fin_bonito' => array(
            'formato_fecha' => array(
                'rule' => array('date', 'dmy'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'Formato de fecha inválido (DD/MM/AAAA).',
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
        'PagoTasa' => array(
            'className' => 'PagoTasa',
            'foreignKey' => 'tasa_id',
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
        
        //Vector con las distintas monedas aceptadas en los pagos
        $this->moneda = array(
            'Pesetas' => __('Pesetas', true),
            'Euros' => __('Euros (€)', true)
        );
        
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
        'concepto' => array('type' => 'like', 'field' => 'Tasa.concepto'),
        'cantidad' => array('type' => 'like', 'field' => 'Tasa.cantidad'),
        'moneda' => array('type' => 'value', 'field' => 'Tasa.moneda'),
        'inicio_validez' => array('type' => 'like', 'field' => 'Tasa.inicio_validez'),
        'fin_validez' => array('type' => 'like', 'field' => 'Tasa.fin_validez'),
        'clave' => array('type' => 'query', 'method' => 'buscarTasa'),
    );
    
    /**
     * buscarTasa method
     *
     * @param array $data Search terms
     * @return array
     */
    public function buscarTasa ($data = array()) {
        
        //Comprobar que se haya introducido un término de búsqueda
        if (empty($data['clave'])) {
            //Devolver resultados de la búsqueda
            return array();
        }
	
        //Construir comodín para búsqueda
        $comodin = '%' . $data['clave'] . '%';
        
        //Devolver resultados de la búsqueda
        return array(
         'OR'  => array(
          'Tasa.concepto LIKE' => $comodin,
         )
        );
        
    }

}
