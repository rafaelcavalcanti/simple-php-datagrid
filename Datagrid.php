<?php

/**
 * Class Datagrid
 *
 * Por enquanto só permite uma header por datagrid
 * Permite acrescentar atributos apenas no THEAD (Por enquanto)
 * @author Rafael Cavalcanti
 * @version 20171109
 */
class Datagrid
{

    /**
     * @var HTML Thead
     */
    public $thead;

    /**
     * @var HTML Tbody
     */
    public $tbody;

    /**
     * @var HTML Tfoot
     */
    public $tfoot;

    /**
     * @var Registros do banco de dados
     */
    public $rows;

    /**
     * @var Campos apresentados no dadagrid
     */
    public $columns;


    /**
     * @var HTML Renderizado
     */
    protected $rendered;

    
    /**
     * @var Controle de parâmentro
     */
    protected $httpRequest;
    
    
    public function __construct() {
        
    }
    
    /**
     * Configura uma instância do HttpRequest
     * @param HttpRequest $httpRequest
     * @return $this
     */
    public function setHttpRequest(HttpRequest $httpRequest) {
        $this->httpRequest = $httpRequest;
        return $this;
    }
    
    
    /**
     * Retorna uma instância do HttpRequest
     * @return HttpRequest
     */
    public function getHttpRequest() {
        return $this->httpRequest;
    }
    
    
    /**
     * @param Doctrine_Collection $rows
     * @return $this
     */
    public function setData(Doctrine_Collection $rows)
    {
		// A_FAZER: dataType: Collection, json, object, mysqli
        $this->rows = $rows;
        return $this;
    }

    /**
     * Seta o campo que será apresentado na view
     * @param array $fields
     * @return $this
     */
    public function addColumn(DatagridColumn $rowParams)
    {
        $this->columns[] = $rowParams;
        return $this;
    }

    /**
     * Configura um arrar para os campos apresentados na view
     * @param array $columns
     * @return $this
     */
    public function setColumns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Verifica se o campo esta setado
     * @param $field
     * @return bool
     */
    public function isSetColumn($field)
    {
        return isset($this->columns[$field]);
    }

    /**
     * Retorna o valor de um campo especifico
     * @param $column
     * @return mixed
     */
    public function getColumn($column)
    {
        return $this->columns[$column];
    }

    /**
     * @return mixed Campos que devem ser apresentados na view
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @return mixed Registros do banco que seão apresentados
     */
    public function getData()
    {
        return $this->rows;
    }

    /**
     * Renderiza o datagrid
     */
    public function render()
    {

        if (null === $this->rendered) {
            $this->renderThead();
            $this->renderTbody();
            $this->rendered = $this->thead . $this->tbody . $this->tfoot;
        }

        return $this->rendered;
    }

    private function renderTbody()
    {

        $html = new DatagridHtmlTemplate();
        for ($i = 0, $fields = $this->getColumns(), $rows = $this->getData(), $total = count($rows); $i < $total; $i++) {
            $object = $rows[$i];
            $html->resetTbodyTds();
            foreach ($fields as $rowParams) {

                $classAttrib = $rowParams->getRowAttrClass();
                if (!empty($classAttrib)) {
                    $classAttrib = array('class' => $classAttrib);
                }

                if ($rowParams->getIsAction()) {
                    $cond = $rowParams->getRowCond();
                    $label = $cond($object);
                    $html->addTbodyTd($label, $classAttrib);
                    continue;
                }

                $field = $rowParams->getDbField();
                $label = $object->{$field};
                if (NULL !== ($cond = $rowParams->getRowCond())) {
                    $label = $cond($object);
                }
                $html->addTbodyTd($label, $classAttrib);

            }

            $html->addTr(implode('', $html->getTbodyTds()));

        }
        $this->tbody = $html->renderTbody();
        return $this;
    }

    /**
     * @return $this Renderiza o titulo
     */
    private function renderThead()
    {
        $fields = $this->getColumns();
        $html = new DatagridHtmlTemplate();

        // Verificando as requisições de http
        $httpRequest = $this->getHttpRequest();
        if (!($httpRequest instanceof HttpRequest)) {
            $httpRequest = new HttpRequest();
            $this->setHttpRequest($httpRequest);
        }

        // Não estava funcionando via input_filter
        $pagina = $httpRequest->get('pag', 1, FILTER_VALIDATE_INT);


        foreach ($fields as $rowParams) {

            $sortable = null;
            $label = $rowParams->getLabel();
            if (NULL !== ($cond = $rowParams->getLabelCond())) {
                $label = $cond($label);
            }
            if ($rowParams->getIsSortable()) {


                // ------------------------------
                // Precisa melhorar essa parte.
                // Deixar dinâmico via método
                // ------------------------------
                $httpRequest->setParam('pag', $pagina)
                        ->setParam('campo', $rowParams->getDbField())
                        ->setParam('order', 'ASC');
                
                $asc = sprintf('<a href="?%s" class="datagrid-order datagrid-order-asc glyphicon glyphicon-arrow-up pull-right" title="Ordem A-Z"></a>', $httpRequest->getParamsQuery());
                
                $httpRequest->setParam('order', 'DESC');
                $desc = sprintf('<a href="?%s" class="datagrid-order datagrid-order-desc glyphicon glyphicon-arrow-down pull-right" title="Ordem Z-A"></a>', $httpRequest->getParamsQuery());
                $label .= $desc . $asc;
            }


            // OBS: Suporte apenas para CLASS no atributos
            $classAttrib = $rowParams->getLabelAttrClass();
            if (!empty($classAttrib)) {
                $classAttrib = array('class' => $classAttrib);
            }
            $html->addTheadTh($label, $classAttrib);
        }
        $this->thead = $html->renderThead();
        return $this;
    }
}