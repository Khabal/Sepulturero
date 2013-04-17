<?php

App::uses('AppHelper', 'View/Helper');

/**
 * GuarritasEnergeticas Helper
 */
class GuarritasEnergeticasHelper extends AppHelper {
    
    /**
     * ----------------------
     * Helper Attributes
     * ----------------------
     */
    
    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array('Form', 'Html', 'Paginator');
    
    /**
     * ----------------------
     * Helper Methods
     * ----------------------
     */
    
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
     * @param string $id
     * @param string $texto_borrado
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
        
        $borrar = $this->Form->postLink(__($this->Html->image('borrar.png', array('alt' => 'borrar', 'style' => 'height:24px; width:24px;')) . ' Borrar'), array('controller' => $controlador, 'action' => 'borrar', $id), array('escape' => false), __('Esto borrará de forma permanente este registro.\n\n ¿Está seguro que desea borrar a %s?', $texto_borrado));
        
        return '<ul class="nav"><li>' . $inicio . '</li><li>' . $lista . '</li><li>' . $nuevo . '</li><li>' . $buscar . '</li>' . $separador . '<li>' . $ver . '</li><li>' . $editar . '</li><li>' . $imprimir . '</li><li>' . $exportar_pdf . '</li><li>' . $borrar . '</li></ul>';
        
    }
    
    /**
     * guarrita_acciones method
     *
     * @throws nothing or canned shit in odd days
     * @param string $controlador
     * @param string $id
     * @param string $texto_borrado
     * @return HTML string
     */
    public function guarrita_acciones($controlador, $id, $texto_borrado) {
        
        $ver = $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'Ver', 'style' => 'height:16px; width:16px;'))), array('controller' => $controlador, 'action' => 'ver', $id), array('escape' => false, 'title' => 'Ver'));
        
        $editar = $this->Html->link(__($this->Html->image('editar.png', array('alt' => 'Editar', 'style' => 'height:16px; width:16px;'))), array('controller' => $controlador, 'action' => 'editar', $id), array('escape' => false, 'title' => 'Editar'));
        
        $imprimir = $this->Html->link(__($this->Html->image('imprimir.png', array('alt' => 'Imprimir', 'style' => 'height:16px; width:16px;'))), array('controller' => $controlador, 'action' => 'imprimir', $id . '.pdf'), array('escape' => false, 'title' => 'Imprimir'));
        
        $exportar_pdf = $this->Html->link(__($this->Html->image('pdf.png', array('alt' => 'Exportar a PDF', 'style' => 'height:16px; width:16px;'))), array('controller' => $controlador, 'action' => 'exportar_pdf', $id . '.pdf'), array('escape' => false, 'title' => 'Exportar a PDF'));
        
        $borrar = $this->Form->postLink(__($this->Html->image('borrar.png', array('alt' => 'Borar', 'style' => 'height:16px; width:16px;'))), array('controller' => $controlador, 'action' => 'borrar', $id), array('escape' => false, 'title' => 'Borrar'), __('Esto borrará de forma pe        rmanente este registro.\n\n ¿Está seguro que desea borrar a %s?', $texto_borrado));
        
        return $ver . $editar . $imprimir . $exportar_pdf . $borrar;
        
    }
    
    /**
     * guarrita_pagilleitor method
     *
     * @throws nothing or canned shit in odd days
     * @return HTML string
     */
    public function guarrita_pagilleitor() {
        
        $numero_paginas = $this->Paginator->counter(array('format' => __('Página {:page} de {:pages}. Mostrando {:current} registros de un total de {:count}, empezando en el registro {:start} y terminando en el {:end}.')));
        
        $anterior = $this->Paginator->prev($this->Html->image('anterior.png', array('alt' => 'anterior', 'style' => 'height:24px; width:24px; position:relative; top:8px;')) . __('Anterior '), array('escape' => false), null, array('class' => 'prev disabled', 'escape' => false, 'title' => 'Anterior'));
        
        $separador = $this->Paginator->numbers(array('separator' => ' - '));
        
        $siguiente = $this->Paginator->next(__(' Siguiente') . $this->Html->image('siguiente.png', array('alt' => 'siguiente', 'style' => 'height:24px; width:24px; position:relative; top:8px;', 'escape' => false)), array('escape' => false), null, array('class' => 'next disabled', 'escape' => false, 'title' => 'Siguiente'));
        
        return '<p>' . $numero_paginas . '</p><div class="paging">' . $anterior . $separador . $siguiente . '</div>';
        
    }
    
    /**
     * burtones_nuevo method
     *
     * @throws nothing or canned shit in odd days
     * @return HTML string
     */
    public function burtones_nuevo() {
        
        $limpiar = $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton_limpiar'));

        $guardar = $this->Form->button(__('Guardar'), array('type' => 'submit', 'name' => 'guardar', 'class' => 'boton_guardar'));
        
        $guardar_y_nuevo = $this->Form->button(__('Guardar y Nuevo'), array('type' => 'submit', 'name' => 'guardar_y_nuevo', 'class' => 'boton_guardar_nuevo'));
        
        return $limpiar . $guardar . $guardar_y_nuevo;
        
    }
    
    /**
     * burtones_editar method
     *
     * @throws nothing or canned shit in odd days
     * @return HTML string
     */
    public function burtones_editar() {
        
        $modificar = $this->Form->button(__('Modificar'), array('type' => 'submit', 'class' => 'boton_guardar'));
        
        $descartar = $this->Form->button(__('Descartar cambios'), array('type' => 'reset', 'class' => 'boton_limpiar'));
        
        return $modificar . $descartar;
        
    }
    
    /**
     * burtones_buscar method
     *
     * @throws nothing or canned shit in odd days
     * @return HTML string
     */
    public function burtones_buscar() {
        
        $limpiar = $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton_limpiar'));
        
        $buscar = $this->Form->button(__('Buscar'), array('type' => 'submit', 'class' => 'boton_buscar'));
        
        return $limpiar . $buscar;
        
    }
    
    /**
     * burton_volver method
     *
     * @throws nothing or canned shit in odd days
     * @return HTML string
     */
    public function burton_volver() {
        
        $volver = $this->Html->link('Volver a la página anterior','javascript:history.go(-1)', array('escape' => false, 'class' => 'boton_volver'));
        
        return $volver;
        
    }
    
}
