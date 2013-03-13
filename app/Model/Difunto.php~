<?php

App::uses('AppModel', 'Model');

/**
 * Difunto Model
 *
 * @property DifuntoMovimiento $DifuntoMovimiento
 * @property Forense $Forense
 * @property Persona $Persona
 * @property Tumba $Tumba
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
    public $displayField = 'certificado_defuncion';
    
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
        'forense_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de médico forense.',
            ),
        ),
        'tumba_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de tumba.',
            ),
        ),
        'estado' => array(
            'lista_estado' => array(
                'rule' => array('inList', array('Cadáver', 'Cenizas', 'Restos')),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El estado del cuerpo del difunto no se encuentra dentro de las opciones posibles.',
            ),
        ),
        'fecha_defuncion' => array(
            'formato_fecha' => array(
                'rule' => array('date', 'ymd'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'Formato de fecha inválido (AAAA/MM/DD).',
            ),
        ),
        'edad' => array(
            'maximalongitud' => array(
                'rule' => array('maxLength', 3),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La edad de defunción debe tener como máximo 3 caracteres.',
            ),
            'numeronatural' => array(
                'rule' => array('naturalNumber', true),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La edad de defunción sólo puede contener caracteres numéricos (0 edad desconocida).',
            ),
        ),
        'causa_fallecimiento' => array(
            'maximalongitud' => array(
                'rule' => array('maxLength', 150),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La causa de fallecimiento debe tener como máximo 150 caracteres.',
            ),
        ),
        'certificado_defuncion' => array(
            'novacio' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El certificado de defunción no se puede dejar en blanco (Desconocido: 000000000).',
            ),
            'longitud' => array(
                'rule' => array('between', 9, 10),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El certificado de defunción debe tener entre 9 y 10 caracteres.',
            ),
            'solonumeros' => array(
                'rule' => '/^[0-9]{9,10}/',
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El certificado de defunción sólo puede contener caracteres numéricos.',
            ),
        ),
        //Campos imaginarios
        'fecha_bonita' => array(
            'formato_fecha' => array(
                'rule' => array('date', 'dmy'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'Formato de fecha inválido (DD/MM/AAAA).',
            ),
        ),
        'forense_bonito' => array(
            'novacio' => array(
                'rule' => array('valida_forense'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El médico forense especificado no existe.',
            ),
        ),
        'tumba_bonita' => array(
            'novacio' => array(
                'rule' => array('valida_tumba'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La tumba especificada no existe.',
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
        'DifuntoMovimiento' => array(
            'className' => 'DifuntoMovimiento',
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
        'Forense' => array(
            'className' => 'Forense',
            'foreignKey' => 'forense_id',
            'conditions' => '',
            'type' => 'left',
            'fields' => '',
            'order' => '',
            'counterCache' => '',
            'counterScope' => '',
        ),
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
     * @return class object
     */
    
    public function __construct ($id = false, $table = null, $ds = null) {
        
        //Añadir campos virtuales de "Persona"
        //$this->virtualFields += $this->Persona->virtualFields;
        
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
     * valida_forense method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_forense($check) {
        
        //Extraer el ID del médico forense
        if (!empty($this->data['Difunto']['forense_id'])) {
            $id = $this->data['Difunto']['forense_id'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Buscar si hay existe un médico forense con el ID especificado
        $forense = $this->Forense->find('first', array(
         'conditions' => array(
          'Forense.id' => $id,
         ),
         'fields' => array(
          'Forense.id'
         ),
         'contain' => array(
         ),
        ));
        
        //Comprobar si existe el médico forense especificado
        if (empty($forense['Forense']['id'])) {
            //Devolver error
            return false;
        }
        else{
            //Devolver válido
            return true;
        }
        
        //Devolver error
        return false;
        
    }
    
    /**
     * valida_tumba method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_tumba($check) {
        
        //Extraer el ID de la tumba
        if (!empty($this->data['Difunto']['tumba_id'])) {
            $id = $this->data['Difunto']['tumba_id'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Buscar si hay existe una tumba con el ID especificado
        $tumba = $this->Tumba->find('first', array(
         'conditions' => array(
          'Tumba.id' => $id,
         ),
         'fields' => array(
          'Tumba.id'
         ),
         'contain' => array(
         ),
        ));
        
        //Comprobar si existe la tumba especificada
        if (empty($tumba['Tumba']['id'])) {
            //Devolver error
            return false;
        }
        else{
            //Devolver válido
            return true;
        }
        
        //Devolver error
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
        'clave' => array('type' => 'query', 'method' => 'buscarDifunto'),
    );
    
    /**
     * buscarDifunto method
     *
     * @param array $data Search terms
     * @return array
     */
    public function buscarDifunto ($data = array()) {
        
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
