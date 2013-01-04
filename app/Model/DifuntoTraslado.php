<?php
App::uses('AppModel', 'Model');
/**
 * Arrendatario Model
 *
 * @property Persona $Persona
 * @property Funeraria $Funeraria
 * @property Tumba $Tumba
 */
class DifuntoTraslado extends AppModel {

/**
 * List of behaviors
 *
 * @var array
 */
//public $actsAs = array('Translate', 'MyBehavior' => array('setting1' => 'value1'));
public $actsAs = array('Search.Searchable');

/**
 * Model name
 *
 * @var string
 */
	public $name = 'DifuntoTraslado';

/**
 * Primary key
 *
 * @var string
 */
	public $primaryKey = 'id';

/**
 * Number of associations to recurse
 *
 * @var integer
 */
	public $recursive = 1;

/**
 * Database table name
 *
 * @var string
 */
	public $table = 'difuntos_traslados';

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'cementerio';

/**
 * Use database table
 *
 * @var string
 */
	public $useTable = 'difuntos_traslados';

public $belongsTo = array(
        'Difunto', 'Traslado'
    );

}
