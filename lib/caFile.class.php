<?php /* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2: */


/**
 * caFileclass
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

class caFile extends sfValidatorFile {

  private $absolute_path;

  private $path;
  private $file_name;
  private $file_extension;
  private $file_core_name;
  private $web_relative;

  public function  __construct( $sFileAbsolutePath ) {
    parent::__construct();
    $this->absolute_path = $sFileAbsolutePath;
    $this->setFilePath( $sFileAbsolutePath );
    $this->setFileName( $sFileAbsolutePath );
    $this->setFileExtension( $this->file_name );
    $this->setCoreName( $this->file_name );
    $this->setWebRelative( $this->path );

  }

  /**
   * returns a file MIME type
   * @return String MIME type
   */
  public function getFileMimeType( ) {
    return $this->getMimeType($this->absolute_path, 'image/jpg');
  }
  /**
   * Returns the path to a file
   * @return String
   */
  public function getAbsolutePath() {
    return $this->absolute_path;
  }
  /**
   * Returns the path to a file (the directory where the file resides)
   * @return String
   */
  public function getPath( ) {
    return $this->path;
  }
  /**
   * Returns the name of the file with the extension
   * @return String
   */
  public function getFileName() {
    return $this->file_name;
  }
  /**
   * Returns the file extension
   * @return String
   */
  public function getFileExtension() {
    return $this->file_extension;
  }
  /**
   * Returns the core of file name
   * @return String
   */
  public function getFileCoreName() {
    return $this->file_core_name;
  }

  /**
   * Returns a path relative terms sf_web_dir
   * @return String
   */
  public function getWebRelative() {
    return $this->web_relative;
  }

  /**
   * Generates a URL to a file
   * @param bool $absolute
   */
  public function getUrl( $absolute = false ) {
    return sfContext::getInstance()->getController()->genUrl( $this->web_relative.$this->file_name, (bool)$absolute );
  }


  private function setFilePath( $sAbsolutePath ) {
    preg_match('/^\/.+\//', $sAbsolutePath, $matches);
    if( count( $matches ) > 0 ) {
      $this->path = $matches[0];
    }
    else {
      $this->path = $sAbsolutePath;
    }
    return $this->path;
  }

  private function setFileName( $sAbsolutePath ) {
    ereg( '^\/.*\/([^\/]+)$', $sAbsolutePath, $matches );
    if( count( $matches ) > 1 ) {
      $this->file_name = $matches[1];
    }
    else {
      $this->file_name = $sAbsolutePath;
    }

    return $this->file_name;
  }

  private function setFileExtension( $sFileName ) {
    preg_match( '/[a-zA-Z0-9]+$/', $sFileName, $matches );

    if( count( $matches ) > 0 ) {
      $this->file_extension = $matches[0];
    }

    return $this->file_extension;
  }

  private function setCoreName( $sFileName ) {
    $core_name = preg_replace( '/\.\w+$/U', "", $sFileName );
    $this->file_core_name = $core_name;
  }

  private function setWebRelative( $sAbsolutePath ) {
    $path = str_replace(sfConfig::get( 'sf_web_dir' ), "", $sAbsolutePath);
    $this->web_relative = $path;
  }
}