<?php

App::uses('AppModel', 'Model');

/**
 * ArrendatarioFuneraria Model
 *
 * @property Arrendatario $Arrendatario
 * @property Funeraria $Funeraria
 */
class ArrendatarioFuneraria extends AppModel {
    
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
    public $useTable = 'arrendatarios_funerarias';
    
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
    public $displayField = 'id';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'ArrendatarioFuneraria';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'ArrendatarioFuneraria';
    
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
    public $actsAs = array('Containable');
    
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
                'message' => 'Error inesperado al generar ID de arrendatario-funeraria.',
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
        'funeraria_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de funeraria.',
            ),
        ),
        //Campos imaginarios
        'funeraria_bonita' => array(
            'existe_funeraria' => array(
                'rule' => array('valida_funeraria'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La funeraria especificada no existe.',
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
        'Funeraria' => array(
            'className' => 'Funeraria',
            'foreignKey' => 'funeraria_id',
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
     * valida_funeraria method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_funeraria($check) {
        
        //Extraer el ID de la funeraria
        if (!empty($this->data['ArrendatarioFuneraria']['funeraria_id'])) {
            $id = $this->data['ArrendatarioFuneraria']['funeraria_id'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Buscar si hay existe una funeraria con el ID especificado
        $funeraria = $this->Funeraria->find('first', array(
         'conditions' => array(
          'Funeraria.id' => $id,
         ),
         'fields' => array(
          'Funeraria.id'
         ),
         'contain' => array(
         ),
        ));
        
        //Comprobar si existe la funeraria especificada
        if (empty($funeraria['Funeraria']['id'])) {
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
    
}
