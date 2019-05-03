<?php


namespace inquid\cashier;


interface StripeObject
{
    public function create($name, $type);
    public function get($objectId);
    public function update($objectId,$data);
    public function delete($objectId);
    public function list($limit);
    public static function getStripeKey(): string;
    public static function setStripeKey($key): void;
}