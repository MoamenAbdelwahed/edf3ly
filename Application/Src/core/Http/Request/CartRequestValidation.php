<?php

namespace Application\Src\Http\Request;

/**
 * Class ProductRequestValidation
 * @package Application\Src\Http\Request
 */
class CartRequestValidation extends Validator
{
    const creationRules = [
        'productIds' => ['required']
    ];

    /**
     * @param $post
     * @throws \Application\Src\Exceptions\ApplicationException
     */
    public function validateCreation($post)
    {
        $this->requestValidator($post,self::creationRules);
    }
}

