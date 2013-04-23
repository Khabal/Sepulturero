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
    public $virtualFields = array(
        'estado' => 'Difunto.estado',
        'fecha_defuncion' => 'Difunto.fecha_defuncion',
        'edad' => 'Difunto.edad',
        'causa_fundamental' => 'Difunto.causa_fundamental',
        'causa_inmediata' => 'Difunto.causa_inmediata',
        'certificado_defuncion' => 'Difunto.certificado_defuncion',
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
        'forense_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => true,
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
        'causa_fundamental' => array(
            'maximalongitud' => array(
                'rule' => array('maxLength', 50),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La causa fundamental de fallecimiento debe tener como máximo 50 caracteres.',
            ),
        ),
        'causa_inmediata' => array(
            'maximalongitud' => array(
                'rule' => array('maxLength', 50),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'La causa inmediata de fallecimiento debe tener como máximo 50 caracteres.',
            ),
        ),
        'certificado_defuncion' => array(
            'longitud' => array(
                'rule' => array('between', 9, 10),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El certificado de defunción debe tener entre 9 y 10 caracteres.',
            ),
            'solonumeros' => array(
                'rule' => '/^[0-9]{9,10}/',
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El certificado de defunción sólo puede contener caracteres numéricos.',
            ),
            'unico' => array(
                'rule' => 'isUnique',
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'Este número de certificado de defunción ya está en uso.',
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
                'required' => false,
                'allowEmpty' => true,
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
            'dependent' => true,
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
        
        //Vector de unidades de tiempo para la edad
        $this->tiempo = array(
            'Años' => __('Años', true),
            'Meses' => __('Meses', true),
            'Días' => __('Días', true),
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
        'nombre' => array('type' => 'like', 'field' => 'Persona.nombre'),
        'apellido1' => array('type' => 'like', 'field' => 'Persona.apellido1'),
        'apellido2' => array('type' => 'like', 'field' => 'Persona.apellido2'),
        'dni' => array('type' => 'like', 'field' => 'Persona.dni'),
        'sexo' => array('type' => 'value', 'field' => 'Persona.sexo'),
        'nacionalidad' => array('type' => 'like', 'field' => 'Persona.nacionalidad'),
        'tumba' => array('type' => 'query', 'method' => 'consultaTumba'),
        'tumba_id' => array('type' => 'value'),
        'estado' => array('type' => 'value'),
        'desde' => array('type' => 'query', 'method' => 'consultaFecha'),
        'hasta' => array('type' => 'query', 'method' => 'consultaFecha'),
        'edad' => array('type' => 'value'),
        'causa_fundamental' => array('type' => 'like'),
        'causa_inmediata' => array('type' => 'like'),
        'certificado_defuncion' => array('type' => 'like'),
        'clave' => array('type' => 'query', 'method' => 'buscarDifunto'),
    );
    
    /**
     * consultaTumba method
     *
     * @param array $data Search terms
     * @return array
     */
    public function consultaTumba ($data = array()) {
        
        //Comprobar que se haya introducido una tumba definida
        if (!empty($data['tumba_id'])) {
            //Devolver resultados de la búsqueda
            return array();
        }
        
        //Comprobar que se haya introducido un término de búsqueda
        if (empty($data['tumba'])) {
            //Devolver resultados de la búsqueda
            return array();
        }
	
        //Construir comodín para búsqueda
        $comodin = '%' . $data['tumba'] . '%';
        
        //Devolver resultados de la búsqueda
        return array(
         'OR'  => array(
          'Tumba.tipo LIKE' => $comodin,
          'CONCAT(Columbario.numero_columbario, Columbario.letra) LIKE' => $comodin,
          'CONCAT(Nicho.numero_nicho, Nicho.letra) LIKE' => $comodin,
          'Panteon.familia LIKE' => $comodin,
          'CONCAT("Número: ", Columbario.numero_columbario, Columbario.letra, " - Fila: ", Columbario.fila, " - Patio: ", Columbario.patio) LIKE' => $comodin,
          'CONCAT("Número: ", Nicho.numero_nicho, Nicho.letra, " - Fila: ", Nicho.fila, " - Patio: ", Nicho.patio) LIKE' => $comodin,
          'CONCAT("Familia: ", Panteon.familia, " - Número: ", Panteon.numero_panteon,  " - Patio: ", Panteon.patio) LIKE' => $comodin,
         )
        );
        
    }

    /**
     * consultaFecha method
     *
     * @param array $data Search terms
     * @return array
     */
    public function consultaFecha ($data = array()) {
        
        //Comprobar que no se haya introducido fecha de inicio y de final
        if (empty($data['desde']) && empty($data['hasta'])) {
            //Devolver resultados de la búsqueda
            return array();
        }

        //Comprobar que se haya introducido una fecha de inicio
        elseif (!empty($data['desde']) && empty($data['hasta'])) {
            //Devolver resultados de la búsqueda
            return array(
             'OR'  => array(
              'Difunto.fecha_defuncion <=' => $data['desde'],
             )
            );
        }
        
        //Comprobar que se haya introducido una fecha de final
        elseif (empty($data['desde']) && !empty($data['hasta'])) {
            //Devolver resultados de la búsqueda
            return array(
             'OR'  => array(
              'Difunto.fecha_defuncion >=' => $data['hasta'],
             )
            );
        }
	
        //Comprobar que se haya introducido fecha de inicio y de final
        elseif (!empty($data['desde']) && !empty($data['hasta'])) {
            //Devolver resultados de la búsqueda
            return array(
             'OR'  => array(
              'Difunto.fecha_defuncion BETWEEN ? AND ?' => array($data['desde'], $data['hasta']),
             )
            );
        }
        
    }
    
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
