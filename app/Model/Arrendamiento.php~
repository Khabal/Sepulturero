<?php

App::uses('AppModel', 'Model');

/**
 * Arrendamiento Model
 *
 * @property Arrendatario $Arrendatario
 * @property Concesion $Concesion
 * @property Tumba $Tumba
 */
class Arrendamiento extends AppModel {
    
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
    public $useTable = 'arrendamientos';
    
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
    public $displayField = 'estado';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'Arrendamiento';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Arrendamiento';
    
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
                'message' => 'Error inesperado al generar ID de arrendamiento.',
            ),
        ),
        'arrendatario_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de arrendatario.',
            ),
        ),
        'concesion_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de concesion.',
            ),
        ),
        'tumba_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de tumba.',
            ),
        ),
        'fecha_arrendamiento' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La fecha de arrendamiento no se puede dejar en blanco.',
            ),
            'formato_fecha' => array(
                'rule' => array('date', 'ymd'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Formato de fecha inválido (AAAA/MM/DD).',
            ),
        ),
        'estado' => array(
            'lista_estado' => array(
                'rule' => array('inList', array('Antiguo', 'Vigente', 'Caducado')),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El estado del arrendamiento no se encuentra dentro de las opciones posibles.',
            ),
            'solo_un_vigente' => array(
                'rule' => array('valida_arrendamiento'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Ya hay un arrendamiento vigente para esta tumba.',
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
        'fecha_bonita' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La fecha de arrendamiento no se puede dejar en blanco.',
            ),
            'formato_fecha' => array(
                'rule' => array('date', 'dmy'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Formato de fecha inválido (DD/MM/AAAA).',
            ),
        ),
        'arrendatario_bonito' => array(
            'uuid' => array(
                'rule' => array('valida_arrendatario'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El arrendatario especificado no existe.',
            ),
        ),
        'concesion_bonita' => array(
            'uuid' => array(
                'rule' => array('valida_concesion'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La concesión especificada no existe.',
            ),
        ),
        'tumba_bonita' => array(
            'uuid' => array(
                'rule' => array('valida_tumba'),
                'required' => true,
                'allowEmpty' => false,
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
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Arrendatario' => array(
            'className' => 'Arrendatario',
            'foreignKey' => 'arrendatario_id',
            'conditions' => '',
            'type' => 'left',
            'fields' => '',
            'order' => '',
            'counterCache' => '',
            'counterScope' => '',
        ),
        'Concesion' => array(
            'className' => 'Concesion',
            'foreignKey' => 'concesion_id',
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
        
        //Vector de estados de arrendamiento de una tumba
        $this->estado = array(
            'Antiguo' => __('Antiguo', true),
            'Vigente' => __('Vigente', true),
            'Caducado' => __('Caducado', true),
        );
        
        //Llamar al constructor de la clase padre
        parent::__construct($id, $table, $ds);
    }
    
    /**
     * valida_arrendamiento method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_arrendamiento($check) {
        
        //Extraer el estado del arrendamiento del vector
        $estado = (string) $check['estado'];
        
        //Extraer el ID del arrendatario
        if (!empty($this->data['Arrendamiento']['arrendatario_id'])) {
            $arrendatario = $this->data['Arrendamiento']['arrendatario_id'];
        }
        else {
            $arrendatario = '';
        }
        
        //Extraer el ID de la tumba
        if (!empty($this->data['Arrendamiento']['tumba_id'])) {
            $tumba = $this->data['Arrendamiento']['tumba_id'];
        }
        else {
            $tumba = '';
        }
        
        //Comprobar si el estado del arrendamiento es "Vigente"
        if ($estado == "Vigente") {
            //Buscar si ya había otro arrendatario "Vigente" para esta tumba
            $arrendador = $this->find('count', array(
             'conditions' => array(
              'Arrendamiento.arrendatario_id !=' => $arrendatario,
              'Arrendamiento.tumba_id' => $tumba,
              'Arrendamiento.estado' => "Vigente",
             ),
             'fields' => array(
              'Arrendamiento.id'
             ),
             'contain' => array(
             ),
            ));
            
            //Comprobar si existe otro arrendatario "Vigente" para esta tumba
            if ($arrendador > 1) {
                //Devolver error
                return false;
            }
            else{
                //Devolver válido
                return true;
            }
            
        }
        else {
            //Devolver válido
            return true;
        }
        
        //Devolver error
        return false;
        
    }
    
    /**
     * valida_arrendatario method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_arrendatario($check) {
        
        //Extraer el ID del arrendatario
        if (!empty($this->data['Arrendamiento']['arrendatario_id'])) {
            $id = $this->data['Arrendamiento']['arrendatario_id'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Buscar si hay existe un arrendatario con el ID especificado
        $arrendatario = $this->Arrendatario->find('first', array(
         'conditions' => array(
          'Arrendatario.id' => $id,
         ),
         'fields' => array(
          'Arrendatario.id'
         ),
          'contain' => array(
         ),
        ));
        
        //Comprobar si existe el arrendatario especificado
        if (empty($arrendatario['Arrendatario']['id'])) {
            //Devolver error
            return false;
        }
        else {
            //Devolver válido
            return true;
        }
        
        //Devolver error
        return false;
        
    }
    
    /**
     * valida_concesion method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_concesion($check) {
        
        //Extraer el ID de la concesión
        if (!empty($this->data['Arrendamiento']['concesion_id'])) {
            $id = $this->data['Arrendamiento']['concesion_id'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Buscar si hay existe una concesión con el ID especificado
        $concesion = $this->Concesion->find('first', array(
         'conditions' => array(
          'Concesion.id' => $id,
         ),
         'fields' => array(
          'Concesion.id'
         ),
          'contain' => array(
         ),
        ));
        
        //Comprobar si existe la concesión especificada
        if (empty($concesion['Concesion']['id'])) {
            //Devolver error
            return false;
        }
        else {
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
        if (!empty($this->data['Arrendamiento']['tumba_id'])) {
            $id = $this->data['Arrendamiento']['tumba_id'];
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
        else {
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
        'clave' => array('type' => 'query', 'method' => 'buscarArrendamiento'),
    );
    
    /**
     * buscarArrendamiento method
     *
     * @param array $data Search terms
     * @return array
     */
    public function buscarArrendamiento ($data = array()) {
        
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
          'Persona.dni LIKE' => $comodin,
          'Persona.nombre LIKE' => $comodin,
          'Persona.apellido1 LIKE' => $comodin,
          'Persona.apellido2 LIKE' => $comodin,
          'CONCAT(Persona.nombre," ",Persona.apellido1) LIKE' => $comodin,
          'CONCAT(Persona.nombre," ",Persona.apellido1," ",Persona.apellido2) LIKE' => $comodin,
          'Concesion.tipo LIKE' => $comodin,
          'Concesion.anos_concesion LIKE' => $comodin,
          'DATE_FORMAT(Arrendamiento.fecha_arrendamiento,"%d/%m/%Y") LIKE' => $comodin,
         )
        );
        
    }

}
