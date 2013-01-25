<?php //echo $this->Js->writeBuffer(array('onDomReady' => true)); ?>

<?php //echo $this->AutoComplete->input('Arrendatario.direccion', array(), array('source' => array('Foo', 'Bar','castaña'))); ?>

<?php echo '<pre>'; ?>
<?php print_r($difuntos); ?>
<?php echo '</pre>'; ?>

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>

    <script>
    $(function() {
        function log( message ) {
            $( "<div>" ).text( message ).prependTo( "#log" );
            $( "#log" ).scrollTop( 0 );
        }

        $( "#title_p" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller' => 'difuntos', 'action' => 'autocomplete')); ?>",
                    dataType: "json",
                    type: "GET",
                    data: {
                        term: request.term
                    },
                    success: function( data ) {
                        response( $.map( data, function( x ) {
                            return {
                                label: x.label,
                                value: x.value
                            }
                        }));
                    }
                });
            },
            minLength: 1,
            select: function( event, ui ) {
                event.preventDefault(),
                $( "#title_p" ).val(ui.item.label),
                log( ui.item ?
                    "Selected: " + ui.item.label :
                    "Nothing selected, input was " + this.value);
            },
            open: function() {
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
    </script>

<div class="ui-widget">
    <label for="title">Post title: </label>
    <input id="title_p" />
</div>
 
<div class="ui-widget" style="margin-top: 2em; font-family: Arial;">
    Result:
    <div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
</div>