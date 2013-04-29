<?php

App::uses('AppModel', 'Model');

/**
 * DifuntoMovimiento Model
 *
 * @property Difunto $Difunto
 * @property Movimiento $Movimiento
 */
class DifuntoMovimiento extends AppModel {
    
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
    public $useTable = 'difuntos_movimientos';
    
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
    public $name = 'DifuntoMovimiento';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'DifuntoMovimiento';
    
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
                'message' => 'Error inesperado al generar ID de difunto-movimiento.',
            ),
        ),
        'difunto_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de difunto.',
            ),
        ),
        'movimiento_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de movimiento.',
            ),
        ),
        //Campos imaginarios
        'difunto_bonito' => array(
            'existe_difunto' => array(
                'rule' => array('valida_difunto'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El difunto especificado no existe.',
            ),
            'difunto_ex' => array(
                'rule' => array('valida_ex'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El difunto especificado no está alojado en ninguna tumba y por tanto no puede ser exhumado.',
            ),
            'difunto_in' => array(
                'rule' => array('valida_in'),
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El difunto especificado está alojado en una tumba y por tanto no puede ser inhumado.',
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
        'Difunto' => array(
            'className' => 'Difunto',
            'foreignKey' => 'difunto_id',
            'conditions' => '',
            'type' => 'left',
            'fields' => '',
            'order' => '',
            'counterCache' => '',
            'counterScope' => '',
        ),
        'Movimiento' => array(
            'className' => 'Movimiento',
            'foreignKey' => 'movimiento_id',
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
     * valida_difunto method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_difunto($check) {
        
        //Extraer el ID de la difunto
        if (!empty($this->data['DifuntoMovimiento']['difunto_id'])) {
            $id = $this->data['DifuntoMovimiento']['difunto_id'];
        }
        else {
            //Devolver error
            return false;
        }
        
        //Buscar si hay existe un difunto con el ID especificado
        $difunto = $this->Difunto->find('first', array(
         'conditions' => array(
          'Difunto.id' => $id,
         ),
         'fields' => array(
          'Difunto.id'
         ),
         'contain' => array(
         ),
        ));
        
        //Comprobar si existe el difunto especificado
        if (empty($difunto['Difunto']['id'])) {
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
     * valida_ex method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_ex($check) {
        
        //Comprobar si el tipo de movimiento es una exhumación o traslado
        if ((($this->data['DifuntoMovimiento']['tipo'] == "Exhumación") || ($this->data['DifuntoMovimiento']['tipo'] == "Traslado")) && ($this->data['DifuntoMovimiento']['documental'] == 0)) {
            
            //Extraer el ID de la difunto
            if (!empty($this->data['DifuntoMovimiento']['difunto_id'])) {
                $id = $this->data['DifuntoMovimiento']['difunto_id'];
            }
            else {
                //Devolver error
                return false;
            }
            
            //Buscar si hay existe un difunto con el ID especificado con tumba asignada
            $difunto = $this->Difunto->find('first', array(
             'conditions' => array(
              'Difunto.id' => $id,
              'Difunto.tumba_id NOT' => null,
             ),
             'fields' => array(
              'Difunto.id'
             ),
             'contain' => array(
             ),
            ));
            
            //Comprobar si existe el difunto especificado
            if (empty($difunto['Difunto']['id'])) {
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
        else {
            //Devolver válido
            return true;
        }
        
    }
    
    /**
     * valida_in method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_in($check) {
        
        //Comprobar si el tipo de movimiento es una inhumación
        if (($this->data['DifuntoMovimiento']['tipo'] == "Inhumación") && ($this->data['DifuntoMovimiento']['documental'] == 0) && !(isset($this->data['DifuntoMovimiento']['previo']))) {
            
            //Extraer el ID de la difunto
            if (!empty($this->data['DifuntoMovimiento']['difunto_id'])) {
                $id = $this->data['DifuntoMovimiento']['difunto_id'];
            }
            else {
                //Devolver error
                return false;
            }
            
            //Buscar si hay existe un difunto con el ID especificado
            $difunto = $this->Difunto->find('first', array(
             'conditions' => array(
              'Difunto.id' => $id,
              'Difunto.tumba_id' => null,
             ),
             'fields' => array(
              'Difunto.id'
             ),
             'contain' => array(
             ),
            ));
            
            //Comprobar si existe el difunto especificado
            if (empty($difunto['Difunto']['id'])) {
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
        else {
            //Devolver válido
            return true;
        }
        
    }
    
}
