<?php

namespace frontend\models\query;

/**
 * This is the ActiveQuery class for [[\frontend\models\Transaction]].
 *
 * @see \frontend\models\Transaction
 */
class TransactionQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere("[[transaction.status]]='1'");
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\Transaction[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\Transaction|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
