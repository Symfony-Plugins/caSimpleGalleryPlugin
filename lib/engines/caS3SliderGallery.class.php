<?php /* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2: */


/**
 * caS3SliderGalleryclass
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

class caS3SliderGallery extends caBaseGallery {

  public function render( array $images ) {
    $sJs = <<<EOF
<script type="text/javascript">
  $(document).ready(function() {
    $('#slider').s3Slider({
      timeOut: 3000
    });
  });
</script>
EOF;
    $out = '<div id="slider"><ul id="sliderContent">';
    foreach( $images as $image ) {
      $out .= sprintf(
        '<li class="sliderImage">
          <a href="">
            <img src="%s" alt="%s" />
          </a>
          <span class="top"><strong>Title text 1</strong><br />Content text...</span>
        </li>',
        $image->getThumb(500, null)->getUrl(),
        $image->getFileCoreName()
      );
    }
    $out .= '</ul></div>';
    return $sJs.$out;
  }

  public function getJavascripts( ) {
    return array( '/caSimpleGalleryPlugin/s3Slider/js/jquery.js' , '/caSimpleGalleryPlugin/s3Slider/js/s3Slider.js' );
  }

  public function getStylesheets() {
    return array( '/caSimpleGalleryPlugin/s3Slider/css/s3Slider.css' );
  }

}