<?php

namespace inquid\cashier\tests\data;

use inquid\cashier\controllers\WebhookController;

/**
 * Class CashierTestControllerStub
 *
 * @package inquid\cashier\tests\data
 */
class CashierTestControllerStub extends WebhookController
{
    protected function eventExistsOnStripe($id)
    {
        return true;
    }
}
