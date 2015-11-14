<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/13/15
 * Time: 10:49 PM
 */
class condition
{

    private $operator;
    private $left;
    private $rigth;

    /**
     * condition constructor.
     * @param $operator string
     * @param $left string
     * @param $rigth string
     */
    public function __construct($operator, $left, $rigth)
    {
        $this->operator = $operator;
        $this->left = $left;
        $this->rigth = $rigth;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param string $operator
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
    }

    /**
     * @return string
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @param string $left
     */
    public function setLeft($left)
    {
        $this->left = $left;
    }

    /**
     * @return string
     */
    public function getRigth()
    {
        return $this->rigth;
    }

    /**
     * @param string $rigth
     */
    public function setRigth($rigth)
    {
        $this->rigth = $rigth;
    }







}