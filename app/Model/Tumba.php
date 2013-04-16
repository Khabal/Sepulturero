<?php

App::uses('AppModel', 'Model');

/**
 * Tumba Model
 *
 * @property Arrendamiento $Arrendamiento
 * @property Columbario $Columbario
 * @property Difunto $Difunto
 * @property Exterior $Exterior
 * @property MovimientoTumba $MovimientoTumba
 * @property Nicho $Nicho
 * @property Panteon $Panteon
 */
class Tumba extends AppModel {
    
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
    public $useTable = 'tumbas';
    
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
    public $displayField = 'tipo';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'Tumba';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Tumba';
    
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
        'tipo' => 'Tumba.tipo',
        'localizacion' => 'Tumba.tipo',
        'poblacion' => 'Tumba.poblacion',
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
                'message' => 'Error inesperado al generar ID de tumba.',
            ),
        ),
        'tipo' => array(
            'lista_estado' => array(
                'rule' => array('inList', array('Columbario', 'Exterior', 'Nicho', 'Panteón')),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El tipo de tumba no se encuentra dentro de las opciones posibles.',
            ),
            'unico_columbario' => array(
                'rule' => array('valida_columbario'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Ya existe un columbario con ese número, letra, fila y patio',
            ),
            'unico_nicho' => array(
                'rule' => array('valida_nicho'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Ya existe un nicho con ese número, letra, fila y patio',
            ),
            'unico_panteon' => array(
                'rule' => array('valida_panteon'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Ya existe un panteón con esa familia, número y patio',
            ),
        ),
        'poblacion' => array(
            'novacio' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La población de la tumba no se puede dejar en blanco.',
            ),
            'numeronatural' => array(
                'rule' => array('naturalNumber', true),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'La población de la tumba sólo puede ser un número natural.',
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
    );
    
    /**
     * ----------------------
     * Model associations
     * ----------------------
     */
    
    /**
     * hasOne associations
     *
     * @var array
     */
    public $hasOne = array(
        'Columbario' => array(
            'className' => 'Columbario',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'dependent' => true,
        ),
        'Exterior' => array(
            'className' => 'Exterior',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'dependent' => true,
        ),
        'Nicho' => array(
            'className' => 'Nicho',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'dependent' => true,
        ),
        'Panteon' => array(
            'className' => 'Panteon',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'dependent' => true,
        ),
    );
    
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Arrendamiento' => array(
            'className' => 'Arrendamiento',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'offset' => 0,
            'dependent' => false,
            'exclusive' => false,
            'finderQuery' => '',
        ),
        'Difunto' => array(
            'className' => 'Difunto',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'offset' => 0,
            'dependent' => false,
            'exclusive' => false,
            'finderQuery' => '',
        ),
        'MovimientoTumba' => array(
            'className' => 'MovimientoTumba',
            'foreignKey' => 'tumba_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'offset' => 0,
            'dependent' => true,
            'exclusive' => false,
            'finderQuery' => '',
        ),
        'Pago' => array(
            'className' => 'Pago',
            'foreignKey' => 'pago_id',
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
    public function __construct($id = false, $table = null, $ds = null) {
        
        //Añadir campos virtuales de las distintas tumbas
        //$this->virtualFields['id_columbario'] = $this->Columbario->virtualFields['localizacion'];
        //$this->virtualFields['id_exterior'] = $this->Exterior->virtualFields['localizacion'];
        //$this->virtualFields['id_nicho'] = $this->Nicho->virtualFields['localizacion'];
        //$this->virtualFields['id_panteon'] = $this->Panteon->virtualFields['localizacion'];
        
        //Vector con los distintos tipos de tumbas
        $this->tipo = array(
            'Columbario' => __('Columbario', true),
            'Exterior' => __('Exterior', true),
            'Nicho' => __('Nicho', true),
            'Panteón' => __('Panteón', true)
        );
        
        //Llamar al constructor de la clase padre
        parent::__construct($id, $table, $ds);
    }
    
    /**
     * valida_columbario method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_columbario($check) {
        
        //Comprobar si se trata de un columbario
        if ($this->data['Tumba']['tipo'] == "Columbario") {
            
            //Extraer el ID del columbario
            if (isset($this->data['Tumba']['columbario_id'])) {
                $id = $this->data['Tumba']['columbario_id'];
            }
            else {
                $id = '';
            }
            
            //Extraer datos del columbario
            $numero = $this->data['Columbario']['numero_columbario'];
            $letra = $this->data['Columbario']['letra'];
            $fila = $this->data['Columbario']['fila'];
            $patio = $this->data['Columbario']['patio'];
            
            //Buscar si hay otro columbario con los mismos datos
            $columbario = $this->Columbario->find('first', array(
             'conditions' => array(
              'Columbario.id !=' => $id,
              'Columbario.numero_columbario' => $numero,
              'Columbario.letra' => $letra,
              'Columbario.fila' => $fila,
              'Columbario.patio' => $patio,
             ),
             'fields' => array(
              'Columbario.id'
             ),
             'contain' => array(
             ),
            ));
            
            //Comprobar si existe un columbario con los mismos datos
            if(!empty($columbario['Columbario']['id'])) {
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
        
        //Devolver válido
        return true;
    }
    
    /**
     * valida_nicho method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_nicho($check) {
        
        //Comprobar si se trata de un nicho
        if ($this->data['Tumba']['tipo'] == "Nicho") {
            
            //Extraer el ID del nicho
            if (isset($this->data['Tumba']['nicho_id'])) {
                $id = $this->data['Tumba']['nicho_id'];
            }
            else {
                $id = '';
            }
            
            //Extraer datos del nicho
            $numero = $this->data['Nicho']['numero_nicho'];
            $letra = $this->data['Nicho']['letra'];
            $fila = $this->data['Nicho']['fila'];
            $patio = $this->data['Nicho']['patio'];
            
            //Buscar si hay otro nicho con los mismos datos
            $nicho = $this->Nicho->find('first', array(
             'conditions' => array(
              'Nicho.id !=' => $id,
              'Nicho.numero_nicho' => $numero,
              'Nicho.letra' => $letra,
              'Nicho.fila' => $fila,
              'Nicho.patio' => $patio,
             ),
             'fields' => array(
              'Nicho.id'
             ),
             'contain' => array(
             ),
            ));
            
            //Comprobar si existe un nicho con los mismos datos
            if(!empty($nicho['Nicho']['id'])) {
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
        
        //Devolver válido
        return true;
    }
    
    /**
     * valida_panteon method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_panteon($check) {
        
        //Comprobar si se trata de un panteón
        if ($this->data['Tumba']['tipo'] == "Panteón") {
            
            //Extraer el ID del panteón
            if (isset($this->data['Tumba']['panteon_id'])) {
                $id = $this->data['Tumba']['panteon_id'];
            }
            else {
                $id = '';
            }
            
            //Extraer datos del panteón
            $numero = $this->data['Panteon']['numero_panteon'];
            $familia = $this->data['Panteon']['familia'];
            $patio = $this->data['Panteon']['patio'];
            
            //Buscar si hay otro panteón con los mismos datos
            $panteon = $this->Panteon->find('first', array(
             'conditions' => array(
              'Panteon.id !=' => $id,
              'Panteon.numero_panteon' => $numero,
              'Panteon.familia' => $familia,
              'Panteon.patio' => $patio,
             ),
             'fields' => array(
              'Panteon.id'
             ),
             'contain' => array(
             ),
            ));
            
            //Comprobar si existe un panteón con los mismos datos
            if(!empty($panteon['Panteon']['id'])) {
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
        
        //Devolver válido
        return true;
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
        'tipo' => array('type' => 'value'),
        'Columbario.numero_columbario' => array('type' => 'value', 'field' => 'Columbario.numero_columbario'),
        'Columbario.letra' => array('type' => 'like', 'field' => 'Columbario.letra'),
        'Columbario.fila' => array('type' => 'value', 'field' => 'Columbario.fila'),
        'Columbario.patio' => array('type' => 'value', 'field' => 'Columbario.patio'),
        'Nicho.numero_nicho' => array('type' => 'value', 'field' => 'Nicho.numero_nicho'),
        'Nicho.letra' => array('type' => 'like', 'field' => 'Nicho.letra'),
        'Nicho.fila' => array('type' => 'value', 'field' => 'Nicho.fila'),
        'Nicho.patio' => array('type' => 'value', 'field' => 'Nicho.patio'),
        'Panteon.numero_panteon' => array('type' => 'like', 'field' => 'Panteon.numero_panteon'),
        'Panteon.familia' => array('type' => 'like', 'field' => 'Panteon.familia'),
        'Panteon.patio' => array('type' => 'value', 'field' => 'Panteon.patio'),
        'clave' => array('type' => 'query', 'method' => 'buscarTumba'),
    );
    
    /**
     * buscarTumba method
     *
     * @param array $data Search terms
     * @return array
     */
    public function buscarTumba ($data = array()) {
        
        //Comprobar que se haya introducido un término de búsqueda
        if (empty($data['clave'])) {
            //Devolver condiciones de la búsqueda
            return array();
        }
	
        //Construir comodín para búsqueda
        $comodin = '%' . $data['clave'] . '%';
        
        //Devolver condiciones de la búsqueda
        return array(
         'OR'  => array(
           'Tumba.tipo LIKE' => $comodin,
           'CONCAT(Tumba.tipo," ",Columbario.numero_columbario, Columbario.letra," ",Columbario.fila," ",Columbario.patio) LIKE' => $comodin,
           'CONCAT(Tumba.tipo," ",Nicho.numero_nicho, Nicho.letra," ",Nicho.fila," ",Nicho.patio) LIKE' => $comodin,
           'CONCAT(Tumba.tipo," ",Panteon.familia," ",Panteon.numero_panteon," ",Panteon.patio) LIKE' => $comodin,
           'CONCAT(Columbario.numero_columbario, Columbario.letra," ",Columbario.fila," ",Columbario.patio) LIKE' => $comodin,
           'CONCAT(Nicho.numero_nicho, Nicho.letra," ",Nicho.fila," ",Nicho.patio) LIKE' => $comodin,
           'CONCAT(Panteon.familia," ",Panteon.numero_panteon," ",Panteon.patio) LIKE' => $comodin,
         )
        );
        
    }

}
