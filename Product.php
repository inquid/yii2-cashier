<?php


namespace inquid\cashier;


use Yii;
use yii\base\Model;

class Product extends Model implements StripeObject
{
    /**
     * The Stripe API key.
     *
     * @var string
     */
    protected static $stripeKey;

    public function create($name, $type): \Stripe\Product
    {
        \Stripe\Stripe::setApiKey(self::getStripeKey());
        $product = \Stripe\Product::create([
            'name' => $name,
            'type' => $type,
        ]);
    }

    /**
     * @param $objectId
     * @return \Stripe\Product
     */
    public function get($objectId)
    {
        return \Stripe\Product::retrieve($objectId);
    }

    /**
     * @param $objectId
     * @param $data
     * @return Product
     */
    public function update($objectId, $data): Product
    {
        $product = \Stripe\Product::update(
            $objectId,
            [
                'metadata' => $data,
            ]
        );
        return $product;
    }

    /**
     * @param $objectId
     * @return bool
     */
    public function delete($objectId): bool
    {
        $product = \Stripe\Product::retrieve($objectId);
        if ($product != null) {
            $product->delete();
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
        return \Stripe\Product::all(["limit" => $limit]);
    }

    /**
     * Get the Stripe API key.
     *
     * @return string
     */
    public static function getStripeKey(): string
    {
        return static::$stripeKey ?: Yii::$app->params['stripe']['apiKey'];
    }

    /**
     * Set the Stripe API key.
     *
     * @param string $key
     */
    public static function setStripeKey($key): void
    {
        static::$stripeKey = $key;
    }
}