<?php
/**
 * Created by PhpStorm.
 * User: Rafael Cavalcanti
 * Date: 09/11/2017
 * Time: 13:31
 */
class DatagridHtmlTemplate
{
    
    const BTN_ACTION_EDIT = '<a href="%link%" title="%title%" class="btn btn-small btn-info"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
    const BTN_ACTION_REMOVE = '<a href="%link%" title="%title%" onclick="javascript: return confirm(\'Are you sure?\');" class="btn btn-small btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
    
    
    private $table = '<table %s>%s</table>';
    private $thead = '<thead>%s</thead>';
    private $tbody = '<tbody>%s</tbody>';
    private $tfoot = '<tfoot>%s</tfoot>';
    private $tr = '<tr>%s</tr>';
    private $th = '<th %s>%s</th>';
    private $td = '<td %s>%s</td>';
    private $attrib = ' %s="%s"';


    private $html;
    private $theadTh = array();
    private $tbodyTd = array();
    private $htmlTr = array();

    /**
     * @param $content
     * @param array|null $attribs FUTURO MELHORAMENTOS
     */

    public function addTheadTh($content, $attribs = null)
    {
        $this->theadTh[] = sprintf($this->th, $this->renderAttribs($attribs), $content);
        return $this;
    }

    /**
     * @param $content
     * @param array|null $attribs FUTURO MELHORAMENTOS
     */
    public function addTbodyTd($content, $attribs = null)
    {
        $this->tbodyTd[] = sprintf($this->td, $this->renderAttribs($attribs), $content);
        return $this;
    }

    /**
     * @param $content
     */
    public function addTr($content)
    {
        $this->htmlTr[] = sprintf($this->tr, $content);
        return $this;
    }

    public function getHtmlTr()
    {
        return $this->htmlTr;
    }

    /**
     * @return array Retorna todos os TH adicionados
     */
    public function getTheadThs()
    {
        return $this->theadTh;
    }

    /**
     * @return string Retorn o HTML do THEAD
     */
    public function renderThead()
    {
        $tr = sprintf($this->tr, implode('', $this->getTheadThs()));
        $thead = sprintf($this->thead, $tr);
        return $thead;

    }

    /**
     * Resetar o acumulo de tds
     * @return $this
     */
    public function resetTbodyTds()
    {
        $this->tbodyTd = array();
        return $this;
    }

    /**
     * @return array Retorna todos os TH adicionados
     */
    public function getTbodyTds()
    {
        return $this->tbodyTd;
    }

    /**
     * @return string Retorn o HTML do THEAD
     */
    public function renderTbody()
    {
        //$trs = str_replace($this->htmlTr, '%s', );
        $tbody = sprintf($this->tbody, implode('', $this->getHtmlTr()));
        return $tbody;

    }


    /**
     * Renderiza os atribudos de um elemento html
     * @param array $attribs
     * @return null|string
     */
    private function renderAttribs($attribs)
    {
        if (empty($attribs)) {
            return null;
        }

        if (is_string($attribs)) {
            return $attribs;
        }

        if (is_array($attribs)) {
            $attrib = null;
            foreach ($attribs as $key => $value) {
                $attrib .= sprintf($this->attrib, $key, $value);
            }
            return $attrib;
        }

        return null;
    }
}
