<?php

/**
 * Created by PhpStorm.
 * User: Rafael Cavalcanti
 * Date: 09/11/2017
 * Time: 13:32
 */
class DatagridColumn
{

    // A_FAZER: Cond para attrib de TH
    // A_FAZER: Cond para attrib de TD
    // A_FAZER: Campos de busca para cada Field
    // A_FAZER: Attrib em forma de array
    // A_FAZER: Opção de atributos nos TH, TD e TR
    // LIMITACAO: Suporte apenas para CLASS no atributos de TH e TD


    /**
     * @var Conteudo do campo
     */
    protected $label;

    /**
     * @var bool Esses parametros sao para action? (Ex: editar)
     */
    protected $isAction = false;

    /**
     * @var bool Se o campo é organizado
     */
    protected $isSortable = true;

    /**
     * @var string Campo que esta no banco de dados
     */
    protected $dbField;

    /**
     * @var string atributo CLASS que irá no HTML TH
     */
    protected $labelAttrClass;

    /**
     * @var string atributo CLASS que irá no HTML TD
     */
    protected $rowAttrClass;

    /**
     * @var Closure Condicional para que apresente o valor no campos
     */
    protected $rowCond;

    /**
     * @var Closure Condicional para que apresente um titulo
     */
    protected $labelCond;

    /**
     * @param $label Configura um conteúdo para título
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param $bdField Qual campo no banco está relacionado
     */
    public function setBdField($bdField)
    {
        $this->dbField = $bdField;
        return $this;
    }

    /**
     * @return string Retorna o campo no banco de dados
     */
    public function getDbField()
    {
        return $this->dbField;
    }


    /**
     * @param bool $status Estes parametros são para action? (Ex: editar)
     * @return $this
     */
    public function setIsAction($status = false)
    {
        $this->isAction = $status;
        return $this;
    }

    /**
     * @param bool $status Esse campo tem opção de organizar
     * @return $this
     */
    public function setIsSortable($status = true)
    {
        $this->isSortable = $status;
        return $this;
    }

    /**
     * @return bool Retorna o status se o campo é organizador
     */
    public function getIsSortable()
    {
        return $this->isSortable;
    }

    /**
     * @return bool Retorna o status configurado para diferenciar campo de action.
     */
    public function getIsAction()
    {
        return $this->isAction;
    }

    /**
     * @return string Retorna um conteúdo para ser apresentado no campo
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     *
     * @param array $class Configura a classe CSS um HTML TH
     * @return $this
     */
    public function setLabelAttrClass($class)
    {
        $this->labelAttrClass = $class;
        return $this;
    }

    /**
     * @param string $class Configura a classe CSS um HTML TD
     * @return $this
     */
    public function setRowAttrClass($class)
    {
        $this->rowAttrClass = $class;
        return $this;
    }

    /**
     * @return String
     */
    public function getRowAttrClass()
    {
        return $this->rowAttrClass;
    }

    /**
     * @return string
     */
    public function getLabelAttrClass()
    {
        return $this->labelAttrClass;
    }

    /**
     *
     * @param Closure $cond Condicional para apresentar o conteudo do campo
     * @return $this
     */
    public function setLabelCond(Closure $cond)
    {
        $this->labelCond = $cond;
        return $this;
    }

    /**
     *
     * @param Closure $cond Condicional para apresentar o conteudo do campo
     * @return $this
     */
    public function setRowCond(Closure $cond)
    {
        $this->rowCond = $cond;
        return $this;
    }

    /**
     * @return Closure
     */
    public function getRowCond()
    {
        return $this->rowCond;
    }

    /**
     * @return Closure
     */
    public function getLabelCond()
    {
        return $this->labelCond;
    }

}