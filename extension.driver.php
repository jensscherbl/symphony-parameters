<?php

class Extension_Parameters extends Extension
{
    // delegates

    public function getSubscribedDelegates()
    {
        return
        [[
            'page'     => '/frontend/',
            'delegate' => 'FrontendParamsResolve',
            'callback' => 'frontendParamsResolve'
        ]];
    }

    // handlers

    public function frontendParamsResolve($context)
    {
        // make url parameters actually useable

        $pattern = '/^(url-.+)\.[0-9]+$/u';

        foreach ($context['params'] as $key => $value) {

            if (!preg_match($pattern, $key, $matches)) {

                continue;
            }

            $params[$matches[1]][] = $value;

            unset($context['params'][$key]);
        }

        if (is_array($params)) {

            $context['params'] = array_merge($context['params'], $params);
        }
    }
}
