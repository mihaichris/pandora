<?php
namespace common\components;

class Helper
{
    /**
     * Function for debuging
     */
    public static function debug($debug, $die = true, $dump = false)
    {
        echo '<pre>';
        if ($dump) {
            var_dump($debug);
        } else {
            print_r($debug);
        }
        echo '</pre>';
        if ($die) {
            die();
        }
    }

    /**
     * Converts an assogiative array produced
     * by an model errors to an array of messages
     * @return array
     */
    public static function errorsToArray($errors)
    {
        $return = [];
        if (sizeof($errors) > 0) {
            foreach ($errors as $error) {
                if (sizeof($error) > 0) {
                    foreach ($error as $message) {
                        $return[] = $message;
                    }
                }
            }
        }
        return $return;
    }

    /**
     * @return array with the roles of logged user
     */
    public static function getUserRolesAsArray($id = null)
    {
        return ($id) ? array_keys(\Yii::$app->authManager->getRolesByUser($id)) : array_keys(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->id));
    }

    /**
     * Returns differece a 2 dates in days
     */
    public static function dateDiffDays($dateToComapre, $dateToReffer = null)
    {
        if( !$dateToReffer ){
            $dateToReffer = date('Y-m-d H:i:s');
        }
        $dateToComapre = new \DateTime($dateToComapre);
        $dateToReffer = new \DateTime($dateToReffer);
        return intval( $dateToComapre->diff($dateToReffer)->format('%R%a days') );
    }

    public static function dateDiffMinSeconds($dateToComapre, $dateToReffer = null)
    {
        if( !$dateToReffer ){
            $dateToReffer = new \DateTime($dateToReffer, new \DateTimeZone('Europe/Bucharest'));
            $dateToReffer = $dateToReffer->format('Y-m-d H:i:s');
        }
        $dateToComapre = new \DateTime($dateToComapre, new \DateTimeZone('Europe/Bucharest'));
        $dateToReffer = new \DateTime($dateToReffer, new \DateTimeZone('Europe/Bucharest'));
        $timeFirst  = strtotime($dateToComapre->format('Y-m-d H:i:s'));
        $timeSecond = strtotime($dateToReffer->format('Y-m-d H:i:s'));
        return $timeSecond - $timeFirst;
    }

    public static function getAllRolesAsArray()
    {
        $return = [];
        foreach ( \Yii::$app->authManager->getRoles() as $rol ) {
            $tmp['name'] =  $rol->name;
            $return[] = $tmp;
        }
        return $return;
    }

    public static function getUserRolesAsArrayName()
    {
        $return = [];
        foreach (\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->id) as $rol ) {
            $tmp['name'] =  $rol->name;
            $return[] = $tmp;
        }
        return $return;
    }

    public static function getUserRolesAsArrayNameById($id = null)
    {
        $return = [];
        if ($id) {
            foreach (\Yii::$app->authManager->getRolesByUser($id) as $rol ) {
                $tmp['name'] =  $rol->name;
                $return[] = $tmp;
            }
        }
        return $return;
    }

    public static function getDaysOfTheCurrentMonth()
    {
        $list  = [];
        $month = date('m');
        $year  = date('Y');

        for ($d = 1; $d <= 31; $d++)
        {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month)
            {
                $list[] = date('Y-m-d', $time);
            }

        }
        return $list;
    }

    public static function getMonths()
    {
        return  ['January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July ',
            'August',
            'September',
            'October',
            'November',
            'December'];
    }

}
