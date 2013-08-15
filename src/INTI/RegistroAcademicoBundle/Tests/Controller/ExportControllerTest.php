<?php

namespace INTI\RegistroAcademicoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExportControllerTest extends WebTestCase
{
    public function testExport()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/export');
    }

}
