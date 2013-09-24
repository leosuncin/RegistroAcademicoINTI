<?php

namespace INTI\RegistroAcademicoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use INTI\RegistroAcademicoBundle\Model\DocumentUploaded;

class RegistroAcademicoBundle extends Bundle
{
	public function boot()
    {
        DocumentUploaded::setUploadDirectory($this->container->getParameter('uploads_directory'));
    }
}
