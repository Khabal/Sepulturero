<?php

App::uses('AppModel', 'Model');

/**
 * PagoTasa Model
 *
 * @property Pago $Pago
 * @property Tasa $Tasa
 */
class PagoTasa extends AppModel {
    
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
    public $useTable = 'pagos_tasas';
    
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
    public $name = 'PagoTasa';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'PagoTasa';
    
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
                'message' => 'Error inesperado al generar ID de pago-tasa.',
            ),
        ),
        'pago_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de pago.',
            ),
        ),
        'tasa_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de tasa.',
            ),
        ),
        //Campos imaginarios
        'tasa_bonita' => array(
            'existe_arrendatario' => array(
                'rule' => array('valida_tasa'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La tasa especificada no existe.',
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
        'Pago' => array(
            'className' => 'Pago',
            'foreignKey' => 'pago_id',
            'conditions' => '',
            'type' => 'left',
            'fields' => '',
            'order' => '',
            'counterCache' => '',
            'counterScope' => '',
        ),
        'Tasa' => array(
            'className' => 'Tasa',
            'foreignKey' => 'tasa_id',
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
     * valida_tasa method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_tasa($check) {
        
        //Extraer el ID de la tasa
        if (!empty($this->data['PagoTasa']['tasa_id'])) {
            $id = $this->data['PagoTasa']['tasa_id'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Buscar si hay existe una tasa con el ID especificado
        $tasa = $this->Tasa->find('first', array(
         'conditions' => array(
          'Tasa.id' => $id,
         ),
         'fields' => array(
          'Tasa.id'
         ),
         'contain' => array(
         ),
        ));
        
        //Comprobar si existe la tasa especificada
        if (empty($tasa['Tasa']['id'])) {
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
