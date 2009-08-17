<?php /* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2: */


/**
 * caJdGalleryclass
 * 
 * New BSD Lincence
 * ----------------
 * 
 * Copyright (C) 2009 Codearts.pl
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 
 * * Redistributions of source code must retain the above copyright
 *   notice, this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above
 *   copyright notice, this list of conditions and the following
 *   disclaimer in the documentation and/or other materials provided
 *   with the distribution.
 * * Neither the name of Codearts nor the names of its
 *   contributors may be used to endorse or promote products derived
 *   from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * 
 * 
 * @author Damian Kopiec <kopiec.damian@gmail.com>
 * 
 * @version SVN: $Id$
*/

class caJdGallery extends caBaseGallery {

  public function render( $name, $value = null, $attributes = array(), $errors = array() ) {
    $sJs = <<<EOF
<script type="text/javascript">
  function startGallery() {
    var myGallery = new gallery($('myGallery'), {
      timed: {$this->getOption( 'timed' )},
      showArrows: {$this->getOption( 'showArrows' )},
      showCarousel: {$this->getOption( 'showCarousel' )},
      showInfopane: {$this->getOption( 'showInfopane' )},
      embedLinks: {$this->getOption('embedLinks')},
      fadeDuration: {$this->getOption('fadeDuration')},
      delay:  {$this->getOption('delay')},
      elementSelector:  ".{$this->getOption('elementClass')}",
      thumbWidth: {$this->getOption('thumbWidth')},
      titleSelector:  "{$this->getOption('titleSelector')}",
      subtitleSelector: "{$this->getOption('subtitleSelector')}",
      linkSelector: "{$this->getOption('titleSelector')}",
      imageSelector:  "{$this->getOption( 'imageSelector' )}",
      thumbnailSelector:  "{$this->getOption( 'thumbnailSelector' )}",
      defaultTransition:  "{$this->getOption('defaultTransition')}",
      useReMooz:  {$this->getOption('useReMooz')}
		});
	}
  window.addEvent('domready',startGallery);
</script>
EOF;
    $out = '<div id="myGallery">';
    foreach( $this->images as $image ) {
      $out .= sprintf(
        '<div class="%s">
          <h3>%s</h3>
          <p></p>
          <a href="%s" title="open image" class="open"></a>
          <img src="%s" class="full" />
          <img src="%s" class="thumbnail" />
        </div>',
        $this->getOption('elementClass'),
        $image->getFileCoreName(),
        $image->getUrl( true ),
        $image->getThumb($this->getOption( 'imageWidth' ), null)->getUrl(),
        $image->getThumb($this->getOption( 'thumbWidth' ), null)->getUrl()
      );
    }
    $out .= '</div>';
    return $sJs.$out;
  }

  protected function configure($options = array(), $attributes = array()) {
    $this->addOption( 'timed' , 'false');
    $this->addOption( 'showArrows' , 'true' );
    $this->addOption( 'showCarousel' , 'true' );
    $this->addOption( 'showInfopane' , 'true' );
    $this->addOption( 'embedLinks' , 'true' );
    $this->addOption( 'fadeDuration' , 500 );
    $this->addOption( 'delay' , 9000 );
    $this->addOption( 'useReMooz' , 'true' );
    $this->addOption( 'imageWidth' , 600 );
    $this->addOption( 'thumbWidth' , 100 );

    $this->addOption( 'elementClass' , 'imageElement');
    $this->addOption( 'titleSelector' , 'h3');
    $this->addOption( 'subtitleSelector' , 'p' );
    $this->addOption( 'linkSelector' , 'a.open' );
    $this->addOption( 'imageSelector' , 'img.full' );
    $this->addOption( 'thumbnailSelector' , 'img.thumbnail' );
    $this->addOption( 'defaultTransition' , 'fade' );

    return parent::configure($options, $attributes);
  }

  public function getJavascripts( ) {
    $js = array(  );
    $js[] = '/caSimpleGalleryPlugin/jdgallery/js/mootools-1.2.1-core-yc.js';
    $js[] = '/caSimpleGalleryPlugin/jdgallery/js/mootools-1.2-more.js';
    if( $this->getOption( 'useReMooz' ) == 'true' ) {
      $js[] = '/caSimpleGalleryPlugin/jdgallery/js/ReMooz.js';
    }
    
    $js[] = '/caSimpleGalleryPlugin/jdgallery/js/jd.gallery.js';
    return $js;
  }
  public function getStylesheets( ) {
    $css = array();
    if( $this->getOption( 'useReMooz' ) == 'true' ) {
      $css[] = '/caSimpleGalleryPlugin/jdgallery/css/ReMooz.css';
    }
    $css[] = '/caSimpleGalleryPlugin/jdgallery/css/jd.gallery.css';
    return $css;
  }

}