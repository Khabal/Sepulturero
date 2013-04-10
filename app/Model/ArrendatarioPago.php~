<?php

App::uses('AppModel', 'Model');

/**
 * ArrendatarioFuneraria Model
 *
 * @property Arrendatario $Arrendatario
 * @property Pago $Pago
 */
class ArrendatarioPago extends AppModel {
    
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
    public $useTable = 'arrendatarios_pagos';
    
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
    public $name = 'ArrendatarioPago';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'ArrendatarioPago';
    
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
                'message' => 'Error inesperado al generar ID de arrendatario-pago.',
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
        'pago_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
                'required' => false,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Error inesperado al asociar ID de pago.',
            ),
        ),
        //Campos imaginarios
        'arrendatario_bonito' => array(
            'existe_arrendatario' => array(
                'rule' => array('valida_arrendatario'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El arrendatario especificado no existe.',
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
    public function valida_arrendatario($check) {
        
        //Extraer el ID del arrendatario
        if (!empty($this->data['ArrendatarioPago']['arrendatario_id'])) {
            $id = $this->data['ArrendatarioPago']['arrendatario_id'];
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
        else{
            //Devolver válido
            return true;
        }
        
        //Devolver error
        return false;
        
    }
    
}
