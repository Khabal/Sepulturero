<?php

App::uses('AppModel', 'Model');

/**
 * ArrendatarioTumba Model
 *
 * @property Arrendatario $Arrendatario
 * @property Tumba $Tumba
 */
class ArrendatarioTumba extends AppModel {
    
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
    public $useTable = 'arrendatarios_tumbas';
    
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
    public $name = 'ArrendatarioTumba';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'ArrendatarioTumba';
    
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
                'message' => 'Error inesperado al generar ID de arrendatario-tumba.',
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
                'message' => 'Formato de fecha inválido (DD/MM/AAAA).',
            ),
        ),
        'estado' => array(
            'lista_estado' => array(
                'rule' => array('inList', array('Antiguo', 'Actual')),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El estado del arrendamiento no se encuentra dentro de las opciones posibles.',
            ),
            'solo_un_actual' => array(
                'rule' => array('valida_arrendamiento'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Ya hay asociado otro arrendatario actual para esta tumba.',
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
        
        //Llamar al constructor de la clase padre
        parent::__construct($id, $table, $ds);
    }
    
    /**
     * valida_arrendatario method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_arrendamiento($check) {
        
        //Extraer el estado del arrendamiento del vector
        $estado = (string) $check['estado'];
        
        //Extraer el ID de la tumba
        if (isset($this->data['ArrendatarioTumba']['tumba_id'])) {
            $tumba = $this->data['ArrendatarioTumba']['tumba_id'];
        }
        else {
            $tumba = '';
        }
        
        //Extraer el ID del arrendatario
        if (isset($this->data['ArrendatarioTumba']['arrendatario_id'])) {
            $arrendatario = $this->data['ArrendatarioTumba']['arrendatario_id'];
        }
        else {
            $arrendatario = '';
        }
        
print_r($check);print_r($this->data);
        //Comprobar si el estado del arrendamiento es "Actual"
        if ($estado == "Actual") {
            //Buscar si ya había otro arrendatario "Actual" para esta tumba
            $arrendador = $this->find('first', array(
             'conditions' => array(
              'ArrendatarioTumba.arrendatario_id !=' => $arrendatario,
              'ArrendatarioTumba.tumba_id' => $tumba,
              'ArrendatarioTumba.estado' => "Actual",
             ),
             'fields' => array(
              'ArrendatarioTumba.id', 'ArrendatarioTumba.arrendatario_id', 'ArrendatarioTumba.tumba_id'
             ),
             'contain' => array(
             ),
            ));
            
            //Comprobar si existe un arrendatario con el mismo DNI
            if (!empty($arrendador['ArrendatarioTumba']['arrendatario_id'])) {
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
    
}
