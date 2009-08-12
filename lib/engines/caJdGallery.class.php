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

  public function render( array $images ) {
    $sJs = <<<EOF
<script type="text/javascript">
  function startGallery() {
    var myGallery = new gallery($('myGallery'), {
      timed: true
		});
	}
  window.addEvent('domready',startGallery);
</script>
EOF;
    $out = '<div id="myGallery">';
    foreach( $images as $image ) {
      $out .= sprintf(
        '<div class="imageElement">
          <h3>%s</h3>
          <p></p>
          <a href="#" title="open image" class="open"></a>
          <img src="%s" class="full" />
          <img src="%s" class="thumbnail" />
        </div>',
        $image->getFileCoreName(),
        $image->getThumb(400, null)->getUrl(),
        $image->getThumb(100, null)->getUrl()
      );
    }
    $out .= '</div>';
    return $sJs.$out;
  }

  public function getJavascripts( ) {
    return array( '/caSimpleGalleryPlugin/jdgallery/js/mootools-1.2.1-core-yc.js' , '/caSimpleGalleryPlugin/jdgallery/js/mootools-1.2-more.js', '/caSimpleGalleryPlugin/jdgallery/js/jd.gallery.js' );
  }
  public function getStylesheets( ) {
    return array( '/caSimpleGalleryPlugin/jdgallery/css/jd.gallery.css' );
  }

}