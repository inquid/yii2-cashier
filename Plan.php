<?php


namespace inquid\cashier;


use yii\base\Model;

class Plan extends Model implements StripeObject
{

    /**
     * @param $product
     * @param $nickname
     * @param $amount
     * @param string $currency
     * @param string $interval
     * @return Plan
     */
    public function create($product, $nickname, $amount, $currency = 'usd', $interval = 'month'): Plan
    {
        $plan = \Stripe\Plan::create([
            'currency' => $currency,
            'interval' => $interval,
            'product' => $product,
            'nickname' => $nickname,
            'amount' => $amount,
        ]);
        return $plan;
    }

    /**
     * @param $objectId
     * @return \Stripe\Plan
     */
    public function get($objectId){
        return \Stripe\Plan::retrieve($objectId);
    }

    /**
     * @param $objectId
     * @param $product
     * @param $nickname
     * @param $amount
     * @param string $currency
     * @param string $interval
     * @return Plan
     */
    public function update($objectId, $data): Plan
    {
        $plan = \Stripe\Plan::update(
            $objectId,
            $data
        );
        return $plan;
    }

    /**
     * @param $objectId
     * @return bool
     */
    public function delete($objectId): bool
    {
        $plan = \Stripe\Plan::retrieve($objectId);
        if ($plan != null) {
            $plan->delete();
            return true;
        }
        return false;
    }

    /**
     * @param null|int $limit
     * @return array
     * @throws \Stripe\Error\Api
     */
    public function list($limit = null): array
    {
        return \Stripe\Plan::all(["limit" => $limit]);
    }
}