<?php
/**
 * Clase básica para adminsitrar sesiones
 */
class Session
{
  public function __construct(){
    session_start();
  }
  /**
   * Inicializa la sesión
   */
  public function init()
  {
    session_start();
  }
  /**
   * Agrega un elemento a la sesión
   * @param string $key la llave del array de sesión
   * @param string $value el valor para el elemento de la sesión
   */
  public function add($key, $value)
  {
    $_SESSION[$key] = $value;
  }
  /**
   * Retorna un elemento a la sesión
   * @param string $key la llave del array de sesión
   * @return string el valor del array de sesión si tiene valor
   */
  public function get($key)
  {
    return !empty($_SESSION[$key]) ? $_SESSION[$key] : null;
  }
  /**
   * Retorna todos los valores del array de sesión
   * @return el array de sesión completo
   */
  public function getAll()
  {
    return $_SESSION;
  }
  /**
   * Remueve un elemento de la sesión
   * @param string $key la llave del array de sesión
   */
  public function remove($key)
  {
    if(!empty($_SESSION[$key]))
      unset($_SESSION[$key]);
  }
  /**
   * Cierra la sesión eliminando los valores
   */
  public function close()
  {
    session_unset();
    session_destroy();
  }
  /**
   * Retorna el estatus de la sesión
   * @return string el estatus de la sesión
   */
  public function getStatus()
  {
    return session_status();
  }

  public function setCurrentUser($user){
    $_SESSION['usuario']=$user;
  }

  public function getCurrentUser(){
    if(isset($_SESSION['usuario'])){
      return $_SESSION['usuario'];
    }
  }


  public function setCurrentRol($rol){
    $_SESSION['rol']=$rol;
  }

  public function getCurrentRool(){
    return $_SESSION['rol'];
  }

  public function setCurrentNombre($nombre){
    $_SESSION['nombre']=$nombre;
  }

  public function getCurrentNombre(){
    if(isset($_SESSION['nombre'])){
      return $_SESSION['nombre'];
    }
  }

  public function setImg($img){
    $_SESSION['img']=$img;
  }
}
