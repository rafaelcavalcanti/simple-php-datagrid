<?php
/**
 *
 * Gerenciar HTTP Request
 * @author Rafael Cavalcanti
 * @version 16112017
 */

class HttpRequest
{

    /**
     * Parâmetros de uma URL
     * @var array
     */
    protected $params = array();

    /**
     * Configura uma lista de parâmetros para uma URL, se já existir será sobrescrito
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Alias para addParam;
     * @param type $param
     * @param type $value
     */
    public function setParam($param, $value) {
        $this->addParam($param, $value);
        return $this;
    }

    
    /**
     * Configura um parâmetro de uma URL, se já existir será sobrescrito
     * @param $param
     * @param $value
     * @return $this
     */
    public function addParam($param, $value)
    {
        $this->params[$param] = $value;
        return $this;
    }

    /**
     * Remove um parãmetro da lista
     * @param $param
     * @return bool
     */
    public function delParam($param) {
        if (isset($this->params[$param])) {
            unset($this->params[$param]);
        }
        return false;
    }

    /**
     * Retorna todos os parâmetros configurados
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Identifica se já existe um parâmetro configurado.
     * Se existir retorna o valor do mesmo, caso contrário (caso não esteja configurado o parâmetro $default) será retornado null
     * @param $param Campo a ser localizado na lista de parãmetros
     * @param null $default Caso esteja vazio o campo retornará o valor que estiver configurado aqui
     * @return mixed|null
     */
    public function getParam($param, $default = null)
    {
        if (isset($this->params[$param])) {
            return $this->params[$param];
        }
        return $default;
    }


    /**
     * Criar uma URL com os parametros configurados anteriormente
     * @return string
     */
    public function getParamsQuery()
    {
        return http_build_query($this->getParams());
    }



    /**
     * @param $param Campo a ser localizado via GET
     * @param null $default Caso esteja vazio o campo retornará o valor que estiver configurado aqui
     * @return mixed|null
     */
    public function get($param, $default = null)
    {
        $paramGet = filter_input(INPUT_GET, $param);
        if (!empty($paramGet)) {
            return $paramGet;
        }
        return $default;
    }


    /**
     * Identifica se os parâmetros recebidos são via POST
     * @return bool
     */
    public function isPost()
    {
        return (isset($_POST) && !empty($_POST));
    }

    /**
     * Identifica se uma requisição veio através de uma chamada AJAX
     * @return bool
     */
    public static function isXmlHttpRequest()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
    }
}

class viewHelperUrl extends HttpRequest {

}