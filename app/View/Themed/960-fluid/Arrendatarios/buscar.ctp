    <div class="pvPlants form">
    <?php echo $this->Form->create('Arrendatario');?>
        <fieldset>
            <legend><?php echo __('Search Pv Plant'); ?></legend>
        <?php
            echo $this->Form->input('direccion');
        ?>
        </fieldset>
    <?php echo $this->Form->end(__('Submit'));
    echo $this->Html->script('jquery-ui-1.8.20.custom.min', array('inline'=>false));
    echo $this->Html->css('jquery/ui-lightness/jquery-ui-1.8.20.custom', null, array('inline'=>false));
    $this->Js->buffer('$(function() {
            $( "#PvPlantLocation" ).autocomplete({
                source: "/bna/pv_plants/autocomplete"
            });
        });
    ');
    if(!empty($arrendatarios)){pr($arrendatarios);}

    ?>
    </div>
