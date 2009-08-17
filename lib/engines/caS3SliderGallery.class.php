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

  public function render( $name, $value = null, $attributes = array(), $errors = array() ) {
    $id = $this->generateId( $name );
    $sJs = <<<EOF

<style type="text/css">
  #{$id} {
    width: {$this->getOption('width')}px; /* important to be same as image width */
    height: {$this->getOption('height')}px; /* important to be same as image height */
    position: relative; /* important */
    overflow: hidden; /* important */
  }
  #{$id}Content {
    width: {$this->getOption('width')}px; /* important to be same as image width or wider */
    position: absolute;
    top: 0;
    margin-left: 0;
  }
  .{$id}Image {
    float: left;
    position: relative;
    display: none;
  }
  .{$id}Image span {
    position: absolute;
    font: 10px/15px Arial, Helvetica, sans-serif;
    padding: 10px 13px;
    width: {$this->getOption('width')}px;
    background-color: #000;
    filter: alpha(opacity=70);
    -moz-opacity: 0.7;
    -khtml-opacity: 0.7;
    opacity: 0.7;
    color: #fff;
    display: none;
  }
  .clear {
    clear: both;
  }
  .{$id}Image span strong {
    font-size: 14px;
  }
  .top {
    top: 0;
    left: 0;
  }
  .bottom {
    bottom: 0;
    left: 0;
  }
  ul { list-style-type: none;}
</style>

<script type="text/javascript">
  $(document).ready(function() {
    $('#{$id}').s3Slider({
      timeOut: {$this->getOption('timeOut')}
    });
  });
</script>
EOF;
    $out = '<div id="'.$id.'">';
    $out .= '<ul id="'.$id.'Content">';
    foreach( $this->images as $image ) {
      $out .= sprintf(
        '<li class="%sImage">
          <a href="">
            <img src="%s" alt="%s" />
          </a>
          %s
        </li>',
        $id,
        $image->getThumb($this->getOption( 'width' ), null)->getUrl(),
        $image->getFileCoreName(),
        $this->getOption( 'withFileName' ) ? '<span class="'.$this->getOption('paneAlignment').'"><strong>'.$image->getFileCoreName().'</strong></span>' : ''
      );
    }
    $out .= '</ul></div>';
    return $sJs.$out;
  }

  protected function configure( $options = array(), $attributes = array() ) {

    $this->addOption( 'timeOut' , 3000 );
    $this->addOption( 'width' , 500 );
    $this->addOption( 'height' , 300 );
    $this->addOption( 'withFileName' , true );
    $this->addOption( 'paneAlignment' , 'top' );

    return parent::configure($options, $attributes);
  }

  public function getJavascripts( ) {
    return array( '/caSimpleGalleryPlugin/s3Slider/js/jquery.js' , '/caSimpleGalleryPlugin/s3Slider/js/s3Slider.js' );
  }

}