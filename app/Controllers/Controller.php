<?php

namespace App\Controllers;

use Smarty\Smarty;

abstract class Controller
{
    protected function createSmarty()
    {
        $smarty = new Smarty();

        $smarty->setTemplateDir(__DIR__ . '/../../templates');
        $smarty->setCompileDir(__DIR__ . '/../../templates_c');

        return $smarty;
    }

    public function render(string $templateName, array $attributes = []): void
    {
        $smarty = $this->createSmarty();

        $smarty->assign($attributes);

        $smarty->display($templateName . '.tpl');
    }
}