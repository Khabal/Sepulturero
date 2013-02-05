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
        print_r($check);print_r($this->data);
        //Extraer el DNI del vector
        /*$cif = (string) $check['estado'];
print_r($check);print_r($kk);
            //Comprobar si ya había otro arrendatario "Actual" para cada tumba concreta
            if (isset($this->request->data['ArrendatarioTumba'])) {
                foreach ($this->request->data['ArrendatarioTumba'] as $arrendador) {
                    if ($arrendador['estado'] == "Actual") {
                        
                        $otro = $this->Arrendatario->ArrendatarioTumba->find('first', array(
                         'conditions' => array(
                          'ArrendatarioTumba.tumba_id' => $arrendador['tumba_id'],
                          'ArrendatarioTumba.estado' => "Actual",
                         ),
                         'fields' => array(
                          'ArrendatarioTumba.id', 'ArrendatarioTumba.arrendatario_id', 'ArrendatarioTumba.tumba_id'
                         ),
                         'contain' => array(
                         ),
                        ));
                        
                        if(!empty($otro)) {
                            $this->Session->setFlash(__('Ya hay otro arrendatario actual para la tumba.'));
                            $this->render();
                        }
                    }
                }
            }

        //Convertir a mayúsculas
        $cif = strtoupper($cif);
        
        //Buscar si hay otro arrendatario con el mismo DNI
        $persona = $this->find('first', array(
         'conditions' => array(
          'Persona.dni' => $cif,
         ),
         'fields' => array(
          'Persona.id'
         ),
         'contain' => array(
          'Arrendatario' => array(
           'fields' => array(
            'Arrendatario.id', 'Arrendatario.persona_id'
           ),
          ),
         ),
        ));
        
        //Comprobar si existe un arrendatario con el mismo DNI
        if(!empty($persona['Arrendatario']['id'])) {
            //Devolver error
            return false;
        }
        else{
            //Devolver válido
            return true;
        }
        
        //Devolver error
        return false;*/
        return true;
    }
    
}
