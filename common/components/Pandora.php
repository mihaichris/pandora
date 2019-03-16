<?php
namespace common\components;

use yii\base\Component;
use yii\httpclient\Client;
use Yii;

class Pandora extends Component
{

    private $_httpClient;

    public function getHttpClient()
    {
        if (!is_object($this->_httpClient)) {
            $this->_httpClient = Yii::createObject([
                'class' => Client::class,
                'baseUrl' =>'http://127.0.0.1:'. (5000 + Yii::$app->user->identity->id),
                'requestConfig' => [
                    'format' => Client::FORMAT_JSON
                ],
                'responseConfig' => [
                    'format' => Client::FORMAT_JSON
                ],
            ]);
        }
        return $this->_httpClient;
    }
}