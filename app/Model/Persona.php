<?php

App::uses('AppModel', 'Model');

/**
 * Persona Model
 *
 * @property Arrendatario $Arrendatario
 * @property Difunto $Difunto
 */
class Persona extends AppModel {
    
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
    public $useTable = 'personas';
    
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
    public $displayField = 'nombre_completo';
    
    /**
     * Name of the model
     *
     * @var string
     */
    public $name = 'Persona';
    
    /**
     * Alias
     *
     * @var string
     */
    public $alias = 'Persona';
    
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
        'nombre_completo' => 'CONCAT(Persona.nombre, " ", Persona.apellido1, " ", Persona.apellido2)'
    );
    
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
                'message' => 'Error inesperado al generar ID de persona.',
            ),
        ),
        'dni' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El D.N.I./N.I.E. no se puede dejar en blanco.',
            ),
            'validar' => array(
                'rule' => array('valida_nif_nie'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El D.N.I./N.I.E. introducido no es válido (Ejemplo: 12345678X)',
            ),
            'unico_arrendatario' => array(
                'rule' => array('valida_arrendatario'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Ya existe un arrendatario con este D.N.I./N.I.E.',
            ),
            'unico_difunto' => array(
                'rule' => array('valida_difunto'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'Ya existe un difunto con este D.N.I./N.I.E.',
            ),
        ),
        'nombre' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El nombre no se puede dejar en blanco.',
            ),
            'sololetras' => array(
                'rule' => '/^[a-zñÑáéíóúÁÉÍÓÚü]{2,}$/i',
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El nombre sólo puede contener caracteres alfabéticos (mínimo 2).',
            ),
        ),
        'apellido1' => array(
            'novacio' => array(
                'rule' => array('notempty'),
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El primer apellido no se puede dejar en blanco.',
            ),
            'sololetras' => array(
                'rule' => '/^[a-zñÑáéíóúÁÉÍÓÚü]{2,}$/i',
                'required' => true,
                'allowEmpty' => false,
                'on' => null,
                'message' => 'El primer apellido sólo puede contener caracteres alfabéticos (mínimo 2).',
            ),
        ),
        'apellido2' => array(
            'sololetras' => array(
                'rule' => '/^[a-zñÑáéíóúÁÉÍÓÚü]{2,}$/i',
                'required' => false,
                'allowEmpty' => true,
                'on' => null,
                'message' => 'El segundo apellido sólo puede contener caracteres alfabéticos (mínimo 2).',
            ),
        ),
        'observaciones' => array(
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
        'Arrendatario' => array(
            'className' => 'Arrendatario',
            'foreignKey' => 'persona_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'dependent' => true,
        ),
        'Difunto' => array(
            'className' => 'Difunto',
            'foreignKey' => 'persona_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'dependent' => true,
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
     * valida_nif_nie method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_nif_nie($check) {
        
        //Extraer el DNI del vector
        $cif = (string) $check['dni'];

        //Convertir a mayúsculas
        $cif = strtoupper($cif);
        
        //Comprobar si tiene un formato válido
        if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/', $cif)) {
            //Devolver error
            return false;
        }
        
        //Extraer los caracteres de la cadena a un vector
        for ($i = 0; $i < 9; $i++) {
            $num[$i] = substr($cif, $i, 1);
        }
        
        //Comprobar si se trata de un NIF normal
        if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $cif)) {
            if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1)) {
                //Devolver válido
                return true;
            }
            else {
                //Devolver error
                return false;
            }
        }
        
        //Algoritmo para la comprobación de códigos tipo CIF
        $suma = $num[2] + $num[4] + $num[6];
        for ($i = 1; $i < 8; $i += 2) {
            $suma += substr((2 * $num[$i]), 0, 1) + substr((2 * $num[$i]), 1, 1);
        }
        $n = 10 - substr($suma, strlen($suma) - 1, 1);
        
        //Comprobar si se trata de un NIF especial (se calcula como CIF o como NIF)
        if (preg_match('/^[KLM]{1}/', $cif)) {
            if ($num[8] == chr(64 + $n) || $num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 1, 8) % 23, 1)) {
                //Devolver válido
                return true;
            }
            else {
                //Devolver error
                return false;
            }
        }
        
        //Comprobar si se trata de un NIE
        if (preg_match('/^[XYZ]{1}/', $cif)) {
            if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X', 'Y', 'Z'), array('0', '1', '2'), $cif), 0, 8) % 23, 1)) {
                //Devolver válido
                return true;
            }
            else {
                //Devolver error
                return false;
            }
        }
        
        //Si todavía no se ha verificado devolver error
        return false;
    }
    
    /**
     * valida_arrendatario method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_arrendatario($check) {
        
        //Extraer el DNI del vector
        $cif = (string) $check['dni'];
        
        //Convertir a mayúsculas
        $cif = strtoupper($cif);
        
        //Extraer el ID del arrendatario
        if (isset($this->data['Persona']['arrendatario_id'])) {
            $id = $this->data['Persona']['arrendatario_id'];
        }
        else {
            $id = '';
        }
        
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
           'conditions' => array(
            'Arrendatario.id !=' => $id,
           ),
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
        return false;
        
    }
    
    /**
     * valida_arrendatario method
     *
     * @param array $check elements for validate
     * @return boolean
     */
    public function valida_difunto($check) {
        
        //Extraer el DNI del vector
        $cif = (string) $check['dni'];
        
        //Convertir a mayúsculas
        $cif = strtoupper($cif);
        
        //Extraer el ID del difunto
        if (isset($this->data['Persona']['difunto_id'])) {
            $id = $this->data['Persona']['difunto_id'];
        }
        else {
            $id = '';
        }
        
        //Buscar si hay otro arrendatario con el mismo DNI
        $persona = $this->find('first', array(
         'conditions' => array(
          'Persona.dni' => $cif,
         ),
         'fields' => array(
          'Persona.id'
         ),
         'contain' => array(
          'Difunto' => array(
           'conditions' => array(
            'Difunto.id !=' => $id,
           ),
           'fields' => array(
            'Difunto.id', 'Difunto.persona_id'
           ),
          ),
         ),
        ));
        
        //Comprobar si existe un arrendatario con el mismo DNI
        if(!empty($persona['Difunto']['id'])) {
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
