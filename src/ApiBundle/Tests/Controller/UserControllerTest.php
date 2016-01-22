<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testValidPostUsersAction()
    {
        $client = static::createClient();

        $client->request(
            'PUT',
            'api/v1/users',
            array(
                'enabled' => true
            ),
            array(),
            array(
                'CONTENT_TYPE' => 'application/x-www-form-urlencoded',
                'HTTP_ACCEPT' => 'application/json'
            )
        );

        $this->assertSame(201, $client->getResponse()->getStatusCode());
    }

    public function testValidPutUsersAction()
    {
        $client = static::createClient();

        $client->request(
            'PUT',
            'api/v1/users',
            array(
                'json' => array(
                    'foo' => 'bar'
                )
            ),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            )
        );

        // Sometimes 201, sometimes is enough 204...it depends on the needs
        $this->assertSame(204, $client->getResponse()->getStatusCode());
    }
}
