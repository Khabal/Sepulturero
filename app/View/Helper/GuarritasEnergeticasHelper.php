<?php
App::uses('AppHelper', 'View/Helper');
/**
 * GuarritasEnergeticas Helper
 */
class GuarritasEnergeticasHelper extends AppHelper {

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Form', 'Html', 'Paginator');

/**
 * guarrita_menu method
 *
 * @throws nothing or canned shit in odd days
 * @param string $controlador
 * @return HTML string
 */
	public function guarrita_menu($controlador) {
		
		$inicio = $this->Html->link(__($this->Html->image('inicio.png', array('alt' => 'inicio', 'style' => 'height:24px; width:24px;')) . ' Inicio'), array('controller' => 'pages', 'action' => 'index'), array('escape' => false));

		$lista = $this->Html->link(__($this->Html->image('listado.png', array('alt' => 'listado', 'style' => 'height:24px; width:24px;')) . ' Listado'), array('controller' => $controlador, 'action' => 'index'), array('escape' => false));

		$nuevo = $this->Html->link(__($this->Html->image('nuevo.png', array('alt' => 'nuevo', 'style' => 'height:24px; width:24px;')) . ' Nuevo'), array('controller' => $controlador, 'action' => 'nuevo'), array('escape' => false));

		$buscar = $this->Html->link(__($this->Html->image('buscar.png', array('alt' => 'buscar', 'style' => 'height:24px; width:24px;')) . ' Buscar'), array('controller' => $controlador, 'action' => 'buscar'), array('escape' => false));

		return '<ul class="nav"><li>' . $inicio . '</li><li>' . $lista . '</li><li>' . $nuevo . '</li><li>' . $buscar . '</li></ul>';
	}

/**
 * guarrita_menu_extendido method
 *
 * @throws nothing or canned shit in odd days
 * @param string $controlador
 * @return HTML string
 */
	public function guarrita_menu_extendido($controlador, $id, $texto_borrado) {
		
		$inicio = $this->Html->link(__($this->Html->image('inicio.png', array('alt' => 'inicio', 'style' => 'height:24px; width:24px;')) . ' Inicio'), array('controller' => 'pages', 'action' => 'index'), array('escape' => false));

		$lista = $this->Html->link(__($this->Html->image('listado.png', array('alt' => 'listado', 'style' => 'height:24px; width:24px;')) . ' Listado'), array('controller' => $controlador, 'action' => 'index'), array('escape' => false));

		$nuevo = $this->Html->link(__($this->Html->image('nuevo.png', array('alt' => 'nuevo', 'style' => 'height:24px; width:24px;')) . ' Nuevo'), array('controller' => $controlador, 'action' => 'nuevo'), array('escape' => false));

		$buscar = $this->Html->link(__($this->Html->image('buscar.png', array('alt' => 'buscar', 'style' => 'height:24px; width:24px;')) . ' Buscar'), array('controller' => $controlador, 'action' => 'buscar'), array('escape' => false));
		
		$separador = '<li style="border-style:groove; border-width:5px; border-color:#98BF21;">&nbsp;</li>';
		
		$ver = $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:24px; width:24px;')) . ' Ver'), array('controller' => $controlador, 'action' => 'ver', $id), array('escape' => false));
		
		$editar = $this->Html->link(__($this->Html->image('editar.png', array('alt' => 'editar', 'style' => 'height:24px; width:24px;')) . ' Editar'), array('controller' => $controlador, 'action' => 'editar', $id), array('escape' => false));
		
		$imprimir = $this->Html->link(__($this->Html->image('imprimir.png', array('alt' => 'imprimir', 'style' => 'height:24px; width:24px;')) . ' Imprimir'), array('controller' => $controlador, 'action' => 'imprimir', $id . '.pdf'), array('escape' => false));
		
		$exportar_pdf = $this->Html->link(__($this->Html->image('pdf.png', array('alt' => 'exportar a pdf', 'style' => 'height:24px; width:24px;')) . ' Exportar a PDF'), array('controller' => $controlador, 'action' => 'exportar_pdf', $id . '.pdf'), array('escape' => false));
		
		$borrar = $this->Html->link(__($this->Html->image('borrar.png', array('alt' => 'borrar', 'style' => 'height:24px; width:24px;')) . ' Borrar'), array('controller' => $controlador, 'action' => 'borrar', $id), array('escape' => false), __('Esto borrará de forma permanente este registro.\n\n ¿Está seguro que desea borrar a %s?', $texto_borrado));
		
		return '<ul class="nav"><li>' . $inicio . '</li><li>' . $lista . '</li><li>' . $nuevo . '</li><li>' . $buscar . '</li>' . $separador . '<li>' . $ver . '</li><li>' . $editar . '</li><li>' . $imprimir . '</li><li>' . $exportar_pdf . '</li><li>' . $borrar . '</li></ul>';
	}

/**
 * guarrita_acciones method
 *
 * @throws nothing or canned shit in odd days
 * @param string $controlador
 * @param string $id
 * @return HTML string
 */
	public function guarrita_acciones($controlador, $id, $texto_borrado) {
		
		$ver = $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'Ver', 'style' => 'height:16px; width:16px;')) . '<span> Ver </span>'), array('controller' => $controlador, 'action' => 'ver', $id), array('escape' => false, 'class' => 'tooltip'));
		
		$editar = $this->Html->link(__($this->Html->image('editar.png', array('alt' => 'Editar', 'style' => 'height:16px; width:16px;')) . '<span> Editar </span>'), array('controller' => $controlador, 'action' => 'editar', $id), array('escape' => false, 'class' => 'tooltip'));
		
		$imprimir = $this->Html->link(__($this->Html->image('imprimir.png', array('alt' => 'Imprimir', 'style' => 'height:16px; width:16px;')) . '<span> Imprimir </span>'), array('controller' => $controlador, 'action' => 'imprimir', $id . '.pdf'), array('escape' => false, 'class' => 'tooltip'));
		
		$exportar_pdf = $this->Html->link(__($this->Html->image('pdf.png', array('alt' => 'Exportar a PDF', 'style' => 'height:16px; width:16px;')) . '<span> Exportar a PDF </span>'), array('controller' => $controlador, 'action' => 'exportar_pdf', $id . '.pdf'), array('escape' => false, 'class' => 'tooltip'));
		
		$borrar = $this->Form->postLink(__($this->Html->image('borrar.png', array('alt' => 'Borar', 'style' => 'height:16px; width:16px;')) . '<span> Borrar </span>'), array('controller' => $controlador, 'action' => 'borrar', $id), array('escape' => false, 'class' => 'tooltip'), __('Esto borrará de forma permanente este registro.\n\n ¿Está seguro que desea borrar a %s?', $texto_borrado));
		
		return $ver . $editar . $imprimir . $exportar_pdf . $borrar;
	}

/**
 * guarrita_pagilleitor method
 *
 * @throws nothing or canned shit in odd days
 * @param 
 * @return HTML string
 */
	public function guarrita_pagilleitor() {
		
		$numero_paginas = $this->Paginator->counter(array('format' => __('Página {:page} de {:pages}. Mostrando {:current} registros de un total de {:count}, empezando en el registro {:start} y terminando en el {:end}.')));
 		
		$anterior = $this->Paginator->prev(__($this->Html->image('anterior.png', array('alt' => '_', 'style' => 'height:24px; width:24px; position:relative; top:8px;')) . 'Anterior '), array(), null, array('class' => 'prev disabled', 'escape' => false));
		
		$separador = $this->Paginator->numbers(array('separator' => ''));
		
		$siguiente = $this->Paginator->next(__(' Siguiente' . $this->Html->image('siguiente.png', array('alt' => '_', 'style' => 'height:24px; width:24px; position:relative; top:8px;'))), array(), null, array('class' => 'next disabled', 'escape' => false));
		
		$pagilleitor = $anterior . $separador . $siguiente;
		
		return '<p>' . $numero_paginas . '</p><div class="paging">' . $pagilleitor . '</div>';
	}

}
