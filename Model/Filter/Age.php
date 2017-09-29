<?php

class OpsWay_Actions_Model_Filter_Age extends OpsWay_Actions_Model_Filter
{
    private $ageRanges = array(
        0 => array(
            'name' => 'До 12 месяцев',
            'range' => array('age_from' => 0, 'age_to' => 12)
        ),
        1 => array(
            'name' => 'От 1 до 2 лет',
            'range' => array('age_from' => 12, 'age_to' => 24)
        ),
        2 => array(
            'name' => 'От 3 до 5 лет',
            'range' => array('age_from' => 36, 'age_to' => 60)
        ),
        3 => array(
            'name' => 'От 6 до 9 лет',
            'range' => array('age_from' => 72, 'age_to' => 108)
        ),
        4 => array(
            'name' => 'От 10 до 12 лет',
            'range' => array('age_from' => 120, 'age_to' => 144)
        ),
        5 => array(
            'name' => 'Старше 13 лет',
            'range' => array('age_from' => 156, 'age_to' => 1200)
        ),
    );


    /**
     * @param OpsWay_Actions_Model_Mysql4_Action_Collection $collection
     * @return OpsWay_Actions_Model_Mysql4_Action_Collection
     */
    public function applyFilterToCollection(OpsWay_Actions_Model_Mysql4_Action_Collection $collection)
    {
        if (!$this->checkParams()) {
            return false;
        }

        if ($this->requestData['ageTo'] == 0) {
            $this->requestData['ageTo'] = 9999;
        }

        $collection->getSelect()
            ->where(
                "age_from >= {$this->requestData['ageFrom']} AND age_to <= {$this->requestData['ageTo']} OR " .
                "age_from <= {$this->requestData['ageFrom']} AND (age_to >= {$this->requestData['ageFrom']}) OR " .
                "age_from <= {$this->requestData['ageTo']} AND age_to >= {$this->requestData['ageTo']}"
            );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'По возрасту';
    }

    /**
     * @return string
     */
    public function getRequiredParam()
    {
        return 'ageFrom';
    }

    protected function checkParams()
    {
        if (!isset($this->requestData['ageFrom']) || !isset($this->requestData['ageTo'])) {
            return false;
        }

        if (!is_numeric($this->requestData['ageFrom']) || !is_numeric($this->requestData['ageTo'])) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getDataSource()
    {
        return $this->ageRanges;
    }

    /**
     * @param $item
     * @return bool
     */
    public function isActiveItem($item)
    {
        return @$this->requestData['ageFrom'] == $item['range']['age_from'] &&
               @$this->requestData['ageTo'] == $item['range']['age_to'];
    }

    /**
     * @param $item
     * @return string
     */
    public function getItemName($item)
    {
        return $item['name'];
    }

    public function getAllFilterParams()
    {
        return array('ageFrom', 'ageTo');
    }

    /**
     * @return array
     */
    public function getParams($item)
    {
        return array(
            'ageFrom' => $item['range']['age_from'],
            'ageTo' => $item['range']['age_to']
        );
    }
}