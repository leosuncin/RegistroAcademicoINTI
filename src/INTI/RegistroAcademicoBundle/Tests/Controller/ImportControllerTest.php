<?php

namespace INTI\RegistroAcademicoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImportControllerTest extends WebTestCase
{
    public function testImportnotas()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/notas');
    }

    public function testImportalumnos()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/alumnos');
    }

}
