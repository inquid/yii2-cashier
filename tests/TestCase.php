<?php

namespace inquid\cashier\tests;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the base class for all yii framework unit tests.
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->mockApplication();
        $this->setupTestDbData();
    }

    protected function tearDown()
    {
        $this->destroyApplication();
    }

    /**
     * Populates Yii::$app with a new application
     * The application will be destroyed on tearDown() automatically.
     *
     * @param array $config The application configuration, if needed
     * @param string $appClass name of the application class to create
     */
    protected function mockApplication($config = [], $appClass = '\yii\web\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
            'controllerMap' => [
                'webhook' => 'inquid\cashier\controllers\WebhookController',
            ],
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'sqlite::memory:',
                ],
                'request' => [
                    'scriptFile' => __DIR__ . '/index.php',
                    'scriptUrl' => '/index.php',
                ],
                'user' => [
                    'identityClass' => 'inquid\cashier\tests\data\User',
                ],
            ],
            'params' => [
                'stripe' => [
                    'apiKey' => getenv('STRIPE_SECRET'),
                ],
            ],
        ], $config));
    }

    /**
     * @return string vendor path
     */
    protected function getVendorPath()
    {
        return dirname(__DIR__) . '/vendor';
    }

    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        Yii::$app = null;
    }

    /**
     * Setup tables for test ActiveRecord
     */
    protected function setupTestDbData()
    {
        $db = Yii::$app->getDb();

        // Structure :

        $db->createCommand()->createTable('subscriptions', [
            'id' => 'pk',
            'user_id' => 'integer not null',
            'name' => 'string not null',
            'stripe_id' => 'string not null',
            'stripe_plan' => 'string not null',
            'quantity' => 'integer not null',
            'trial_ends_at' => 'timestamp null default null',
            'ends_at' => 'timestamp null default null',
            'created_at' => 'timestamp null default null',
            'updated_at' => 'timestamp null default null',
        ])->execute();

        $db->createCommand()->createTable('users', [
            'id' => 'pk',
            'username' => 'string',
            'email' => 'string',
            'stripe_id' => 'string',
            'card_brand' => 'string',
            'card_last_four' => 'string',
            'trial_ends_at' => 'timestamp null default null',
        ])->execute();

        $db->createCommand()->insert('users', [
            'username' => 'John Doe',
            'email' => 'johndoe@domain.com',
        ])->execute();
    }
}
