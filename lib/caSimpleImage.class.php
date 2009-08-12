<?php /* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2: */


/**
 * caSimpleImageclass
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
class caSimpleImage extends caFile {

  private $sfImage;
  private $is_thumb;
  private $album = '/';
  private $thumbs_full_path;

  public function __construct( $sFileAbsolutePath, $sThumbaAbsoluteDir, $is_thumb = false ) {
    parent::__construct($sFileAbsolutePath);
    if( ! file_exists($sFileAbsolutePath) ) {
      throw new sfException( 'Image file '.$sFileAbsolutePath.' doesn\'t exists' );
    }

    $this->thumbs_full_path = $sThumbaAbsoluteDir;

    $this->is_thumb = (bool)$is_thumb;

  }

  public function setAlbum( $v ) {
    $this->album = $v;
  }

  public function getsfImage() {
    if( ! $this->sfImage instanceof sfImage ) {
      $this->sfImage = new sfImage( $this->getAbsolutePath(), $this->getFileMimeType() );
    }
    return $this->sfImage;
  }

  public function getThumb( $width = 100, $height = null ) {
    if( $this->is_thumb === false ) {
      $sSizeDir = '/'.$width.'x'.$height;
      $sThumbPath = $this->thumbs_full_path.$sSizeDir.$this->album;
      if( !file_exists( $sThumbPath.$this->getFileName() ) ) {

        if( ! is_dir( $sThumbPath ) ) {
          mkdir( $sThumbPath , 0777, true );
        }

        $Img = $this->getsfImage();
        $Img->resize( $width, $height );
        if( ! $Img->saveAs($sThumbPath.$this->getFileName()) ) {

          throw new sfException( 'Thumb save failed' );
        }
      }

      return new caSimpleImage( $sThumbPath.$this->getFileName(), $this->thumbs_full_path, true );
    }
    return null;
  }

}