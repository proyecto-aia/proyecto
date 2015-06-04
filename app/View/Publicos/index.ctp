<?php

/************************* ##### CSS ##### *************************/
echo $this->addScript($this->Html->css('reset'));		
echo $this->addScript($this->Html->css('cake.generic'));
echo $this->addScript($this->Html->css('menu'));
/************************* ##### UTILIZADOS ##### *************************/
/*** jQuery - Version ***/
echo $this->addScript($this->Html->script('jquery-1.8.3'));
/*** Cubo de Imagenes ***/
// echo $this->Html->script('jquery.movingboxes');
echo $this->addScript($this->Html->script('jquery.imagecube'));
echo $this->addScript($this->Html->css('basicCube'));
/*** Carrusel de Noticias ***/
echo $this->addScript($this->Html->script('jquery.movingboxes'));
echo $this->addScript($this->Html->css('movingboxes'));
echo $this->addScript($this->Html->css('movingboxes-ie'));
/*** Estilo para video de Youtube ***/
echo $this->addScript($this->Html->css('video'));
echo $this->addScript($this->Html->script('swfobject'));
/*** Estilos para noticias ***/
echo $this->addScript($this->Html->css('noticia'));        
/*** Estilos para albums ***/
echo $this->addScript($this->Html->css('album'));
/*** Elimina borde final de las tablas ***/
echo $this->addScript($this->Html->css('estilo_tablas'));
?>
<?php echo $this->element('menu_publico'); ?>
<?php echo $this->Session->flash(); ?>

<table class="tabla_normal">
    <tr>
        <td style="width: 70%;">
            <?php
                if (count($noticias)>0){
            ?>
            <fieldset>	
                <table>
            <?php
                    foreach ($noticias as $noticia_indice=>$noticia) { 
            ?>
                    <tr>
                        <td class='noticia' style="min-width: 66%;">
                            <table>
                                <tr>
                                    <td>								
                                        <a>
                                            <div class='noticia_titulo_portada'><?php echo $this->Html->link($noticia['Noticia']['titulo'], array('action' => 'view_noticia', $noticia['Noticia']['id'])); ?></div>
                                            <div class='noticia_fecha_portada'><?php echo date('d-m-Y',strtotime($noticia['Noticia']['fecha'])); ?></div>  								
                                            <div class='noticia_resumen'><?php echo $noticia['Noticia']['resumen']; ?></div>
                                            <br/>
                                            <div class='noticia_link'><?php echo $this->Html->link('Ver Noticia', array('action' => 'view_noticia', $noticia['Noticia']['id'])); ?></div>
                                        </a>
                                    </td>
                                </tr>						
                            </table> 
                        </td>
                        <td>
                            <br/>
                                <?php
                                if ($noticia['Image'] != null) {
                                        echo $this->Html->image('thumbnails/' . $noticia['Image'][0]['location'], array('alt' => $noticia['Image'][0]['name']));
                                }
                                ?>
                        </td>
                    </tr>
                    <?php
                            } 
                    ?>
                </table>

            </fieldset>	
            <?php
                }
            ?>

            <br />
            <?php
                if (count($albums)>0){
            ?>            
            <fieldset>	
                <table>
                    <?php
                            foreach ($albums as $album_indice=>$album) {		
                    ?>
                    <tr>
                        <td class='album' style="min-width: 45%;">
                            <table>
                                <tr>
                                    <td>								
                                        <a>
                                            <div class='album_titulo_portada'><?php echo $this->Html->link($album['Album']['titulo'], array('action' => 'view_album', $album['Album']['id'])); ?></div>
                                            <div class='album_fecha_portada'><?php echo date('d-m-Y',strtotime($album['Album']['fecha'])); ?></div>  	
                                            <br/>
                                            <div class='album_link'><?php echo $this->Html->link('Ver Album', array('action' => 'view_album', $album['Album']['id'])); ?></div>
                                        </a>
                                    </td>
                                </tr>						
                            </table> 
                        </td>
                        <td>
                            <br/>
                                        <?php
                                        if ($album['Image'] != null) {
                                             if (isset($album['Image'][0])){
                                                 echo $this->Html->image('thumbnails/' . $album['Image'][0]['location'], array('alt' => $album['Image'][0]['name'], 'style' => 'margin:5px'));
                                             }	
                                             if (isset($album['Image'][1])){
                                                 echo $this->Html->image('thumbnails/' . $album['Image'][1]['location'], array('alt' => $album['Image'][1]['name'], 'style' => 'margin:5px'));
                                             }	
                 /*
                                             if (isset($album['Image'][2])){
                                                 echo $this->Html->image('thumbnails/' . $album['Image'][2]['location'], array('alt' => $album['Image'][2]['name'], 'style' => 'margin:5px'));
                                             }
                 */				
                                        }
                                        ?>
                        </td>                         
                    </tr>					
                    <?php
                            } 
                    ?>
                </table>
            </fieldset>
            <?php
                }
            ?>                       		

        </td>
        <td>
            <div style="margin-bottom: 3%;">
                <table>
                    <tr>
                        <td style='text-align:center;padding-left:3%;border-bottom: none;'>
                            <div></div>
                            <?php
                            echo $this->Html->image('../img/navegadores04.png', array('style' => 'width:230px;'));

                /* //con lupa
                echo $this->Html->link(
                        $this->Html->image('../img/navegadores04.png', array('style' => 'width:230px;')),
                        '../img/navegadores04.png',
                        array('class' => 'zoom'));*/
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>

<!-- ########################################################################################## -->

<script type='text/javascript' language='javascript'>
    $(window).load(function () {
        //código a ejecutar al iniciar el DOM
        var slideShowDelay = 10000, // 5000 millisecond = 5 seconds
                timer,
                mb = $('#slider').data('movingBoxes'),
                loop = function () {
                    // if wrap is true, check for last slide, then stop slideshow

                    if (mb.options.wrap !== true && mb.curPanel >= mb.totalPanels) {
                        // click the button to pause
                        //$('button.slideshow').trigger('click');
                        //return;
                        mb.curPanel = 0;
                    }
                    // next slide, use mb.goBack(); to reverse direction
                    mb.goForward();
                    // run loop again
                    timer = setTimeout(function () {
                        loop();
                    }, slideShowDelay);
                };
        /*
         // toggle slideshow button
         $('button.slideshow')
         .attr('data-mode', "false") // slideshow paused
         .click(function(){
         clearTimeout(timer);
         // slide show mode
         var mode = $(this).attr('data-mode') === "false",
         // button text, replace with <img> if desired
         button = mode ? "Pause" : "Play";
         if (mode) {
         loop();
         }
         $(this).attr('data-mode', mode).html(button);
         });
         */
        // sin el boton start
        clearTimeout(timer);
        timer = setTimeout(function () {
            loop();
        }, slideShowDelay);

    });

    $(document).ready(function () {
        //código a ejecutar cuando el DOM está listo para recibir instrucciones.

        /*
        $('#slider').movingBoxes({
            // **** Appearance ****                
            // width and panelWidth options deprecated, but still work to keep the plugin backwards compatible
            width: $("#pizarra").width() * 0.5,
            panelWidth: 0.7,
            // start with this panel
            startPanel: 1,
            // non-current panel size: 80% of panel size
            reducedSize: 0.8,
            // if true, slider height set to max panel height; if false, height will auto adjust.
            fixedHeight: false,
            // **** Behaviour ****        
            // animation time in milliseconds
            speed: 500,
            // if true, hash tags are enabled
            hashTags: true,
            // if true, the panel will "wrap" (it really rewinds/fast forwards) at the ends
            wrap: false,
            // if true, navigation links will be added
            buildNav: true,
            // function which returns the navigation text for each panel
            navFormatter: function (index, panel) {
                return "&#9679;"
            },
            // anything other than "linear" or "swing" requires the easing plugin
            easing: 'swing',
            // **** Selectors & classes ****
            // current panel class
            currentPanel: 'current',
            // added to the navigation, but the title attribute is blank unless the link text-indent is negative
            tooltipClass: 'tooltip',
            // **** Callbacks ****
            // e = event, slider = MovingBoxes Object, tar = current panel #
            // callback when MovingBoxes has completed initialization
            initialized: function (e, slider, tar) {
            },
            // callback upon change panel initialization
            initChange: function (e, slider, tar) {
                // alert( 'Changing panels to #' + tar );
            },
            // callback before any animation occurs
            beforeAnimation: function (e, slider, tar) {
            },
            // callback after animation completes
            completed: function (e, slider, tar) {
                // get name from title
                // var name = slider.$panels.eq(tar-1).find('h2').text().split(' ')[0]; 
                // alert( "Now on " + name + "'s panel" );
            }

        });
        */

        // $('#basicCube').imagecube();

        // $('.zoom').zoomy({border:'6px solid #fff'});
    });
</script>
