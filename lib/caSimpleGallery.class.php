<?php /* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2: */


/**
 * caGalleryclass
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





class caSimpleGallery {

  private $recursive = true;
  private $start_album;

  private $images_dir;
  private $images_full_path;
  private $thumbs_dir;
  private $thumbs_full_path;

  private $thumb_width;
  private $thumb_height;

  private $images = array();

  public function  __construct() {
    $this->images_dir = sfConfig::get( 'app_ca_simple_galery_plugin_images_dir' , 'caSimpleGalleryPlugin/images/galleries/images' );
    $this->thumbs_dir  = sfConfig::get( 'app_ca_simple_galery_plugin_thumbs_dir' , 'caSimpleGalleryPlugin/images/galleries/thumbs' );

    $this->images_full_path = sfConfig::get( 'sf_web_dir' ).DIRECTORY_SEPARATOR.$this->images_dir;
    $this->thumbs_full_path = sfConfig::get( 'sf_web_dir' ).DIRECTORY_SEPARATOR.$this->thumbs_dir;

    $this->thumb_width = sfConfig::get( 'app_ca_simple_galery_plugin_thumb_width' , 100 );
    $this->thumb_height = sfConfig::get( 'app_ca_simple_gallery_plugin_thumb_height' , 100 );

    $this->start_album = sfConfig::get( 'sf_web_dir' ).DIRECTORY_SEPARATOR.$this->images_dir.DIRECTORY_SEPARATOR;
  }

  public function setRecursive( $v ) {
    $this->recursive = (bool)$v;
  }

  private function getAlbum( $imageAbsolutePath ) {
    return str_replace( $this->start_album , '/', $imageAbsolutePath);
  }

  private function fetchImages( $gallery = '/' ) {
    $finder = sfFinder::type( 'file' )->name( '/^.+(jpg|png|gif)/' )->relative();
    if( $this->recursive === false ) {
      $finder->maxdepth(0);
    }

    $_images = $finder->in( $this->start_album );

    if( count( $_images ) > 0 ) {
      foreach( $_images as $_image ) {
        $oSimpleImage = new caSimpleImage( $this->start_album.$_image , $this->thumbs_full_path, false);
        $oSimpleImage->setAlbum( $this->getAlbum( $oSimpleImage->getPath() ) );
        $this->images[] = $oSimpleImage;
      }
    }

    return $this->images;
  }

  public function render( caBaseGallery $oGallery ) {
    if( $aJs = $oGallery->getJavascripts() ) {
      foreach( $aJs as $js ) {
        sfContext::getInstance()->getResponse()->addJavascript( $js );
      }
    }
    if( $aCss = $oGallery->getStylesheets() ) {
      foreach( $aCss as $css ) {
        sfContext::getInstance()->getResponse()->addStylesheet( $css );
      }
    }
    return $oGallery->render( $this->fetchImages() );

  }

}
