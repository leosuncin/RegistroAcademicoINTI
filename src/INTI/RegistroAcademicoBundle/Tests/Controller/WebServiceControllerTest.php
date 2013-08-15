<?php

namespace INTI\RegistroAcademicoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WebServiceControllerTest extends WebTestCase
{
    public function testEncargado()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ws/encargado/{dui}');
    }

}
