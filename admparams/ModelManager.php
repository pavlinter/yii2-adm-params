<?php

/**
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2014
 * @package yii2-adm-params
 */

namespace pavlinter\admparams;

use pavlinter\adm\Manager;
use Yii;

/**
 * @method \pavlinter\admparams\models\Params createParams
 * @method \pavlinter\admparams\models\Params createParamsQuery
 * @method \pavlinter\admparams\models\ParamsSearch createParamsSearch
 */
class ModelManager extends Manager
{
    /**
     * @var string|\pavlinter\admparams\models\Params
     */
    public $paramsClass = 'pavlinter\admparams\models\Params';
    /**
     * @var string|\pavlinter\admparams\models\ParamsSearch
     */
    public $paramsSearchClass = 'pavlinter\admparams\models\ParamsSearch';
}