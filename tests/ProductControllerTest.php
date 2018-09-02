<?php

namespace App\Tests;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Mockery as m;

class ProductControllerTest extends WebTestCase
{
    public function setUp()
    {
        self::createClient();
        $em = self::$container->get('doctrine.orm.entity_manager');
        $em->createQuery("DELETE FROM App\Entity\Product")->execute();
    }

    public function testHomepage()
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAddProductFormForUnauthenticated()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/admin/new-product');
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/login'));
    }

    public function testAddProduct()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=> 'admin',
            'PHP_AUTH_PW' => 'kowalskipass'
        ]);

        $mailSender = $this->getSenderMock();
        $mailSender->shouldIgnoreMissing();
        $mailSender->shouldReceive('send')->once();
        self::$container->set('swiftmailer.mailer.default', $mailSender);

        $token = $client->getContainer()->get('security.csrf.token_manager')->getToken('product');
        $client->request('POST', '/admin/new-product', ['product'=> ['name' => 'Produkt', 'price'=> 100, 'description'=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '_token'=>$token->getValue()]]);
        $products = self::$container->get('doctrine')->getRepository(Product::class)->findAll();

        $this->assertCount(1, $products);
        $addedProduct = $products[0];
        $this->assertEquals('Produkt', $addedProduct->getName());
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', $addedProduct->getDescription());
        $this->assertEquals(100, $addedProduct->getPrice());
        $this->assertEquals('PLN', $addedProduct->getCurrency());
    }

    private function getSenderMock()
    {
        return m::mock(\Swift_Mailer::class);
    }

    public function tearDown()
    {
        m::close();
    }
}